<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * TRANG CHI TIẾT GIỎ HÀNG (DUYỆT, SỬA SỐ LƯỢNG, XÓA VẬT TƯ)
     */
    public function index()
    {
        $rawCart = session()->get('cart', []);
        $cartItems = [];
        $totalAmount = 0;
        $totalVat = 0;

        if (is_array($rawCart)) {
            foreach ($rawCart as $key => $item) {
                if (!is_array($item)) continue;

                $price = floatval($item['price'] ?? 0);
                $quantity = max(1, intval($item['quantity'] ?? 1));
                $productId = $item['product_id'] ?? (is_numeric($key) ? $key : (explode('-', $key)[0] ?? null));

                $itemTotal = $price * $quantity;
                $totalAmount += $itemTotal;

                $product = $productId ? Product::find($productId) : null;
                $vatRate = $product ? $product->getVatRate() : 0;
                if ($vatRate > 0) {
                    $totalVat += $itemTotal * $vatRate / (100 + $vatRate);
                }

                $cartItems[$key] = array_merge($item, [
                    'product_id' => $productId,
                    'price'      => $price,
                    'quantity'   => $quantity,
                    'name'       => $item['name'] ?? ($product->name ?? 'Sản phẩm vật tư'),
                    'packaging'  => $item['packaging'] ?? ($product->packaging ?? 'Tiêu chuẩn'),
                    'unit'       => $item['unit'] ?? ($product->unit ?? 'Sản phẩm'),
                    'image'      => $item['image'] ?? ($product ? (is_array($product->images) && count($product->images) > 0 ? $product->images[0] : null) : null)
                ]);
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'totalAmount', 'totalVat'));
    }

    /**
     * TRANG THANH TOÁN & ĐIỀN THÔNG TIN GIAO NHẬN VẬT TƯ THỰC TẾ (PRD MỤC 7.1)
     */
    public function checkout()
    {
        // 1. Lấy dữ liệu giỏ hàng thực tế từ PHP Session
        $rawCart = session()->get('cart', []);
        $cartItems = [];
        $totalAmount = 0;
        $totalVat = 0;

        if (is_array($rawCart)) {
            foreach ($rawCart as $key => $item) {
                if (!is_array($item)) continue;

                $price = floatval($item['price'] ?? 0);
                $quantity = max(1, intval($item['quantity'] ?? 1));
                $productId = $item['product_id'] ?? (is_numeric($key) ? $key : (explode('-', $key)[0] ?? null));

                $itemTotal = $price * $quantity;
                $totalAmount += $itemTotal;

                $product = $productId ? Product::find($productId) : null;
                $vatRate = $product ? $product->getVatRate() : 0;
                if ($vatRate > 0) {
                    $totalVat += $itemTotal * $vatRate / (100 + $vatRate);
                }

                $cartItems[$key] = array_merge($item, [
                    'product_id' => $productId,
                    'price'      => $price,
                    'quantity'   => $quantity,
                    'name'       => $item['name'] ?? ($product->name ?? 'Sản phẩm vật tư'),
                    'packaging'  => $item['packaging'] ?? ($product->packaging ?? 'Tiêu chuẩn'),
                    'unit'       => $item['unit'] ?? ($product->unit ?? 'Sản phẩm'),
                    'image'      => $item['image'] ?? ($product ? (is_array($product->images) && count($product->images) > 0 ? $product->images[0] : null) : null)
                ]);
            }
        }

        // 2. Nếu giỏ hàng trống, chặn điều hướng và đẩy ngược về danh sách sản phẩm vật tư
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng chọn vật tư trước khi tiến hành thanh toán!');
        }

        $user = Auth::user();

        // Kiểm tra và cập nhật voucher từ session
        $discountAmount = 0;
        $finalTotal = $totalAmount;

        if (session()->has('applied_voucher')) {
            $voucher = \App\Models\Voucher::where('code', session('applied_voucher.code'))->first();
            if ($voucher && $voucher->isValidForCart($cartItems, $totalAmount)) {
                $discountAmount = $voucher->calculateDiscountForCart($cartItems, $totalAmount);
                session()->put('applied_voucher.discount', $discountAmount);
                $finalTotal = $totalAmount - $discountAmount;
                
                // Điều chỉnh thuế VAT tương ứng sau khi áp voucher giảm giá
                if ($totalAmount > 0) {
                    $totalVat = $totalVat * ($finalTotal / $totalAmount);
                }
            } else {
                session()->forget('applied_voucher');
            }
        }

        // Lấy danh sách mã giảm giá khả dụng để hiển thị gợi ý cho bà con ở Checkout
        $vouchers = \App\Models\Voucher::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->whereColumn('uses', '<', 'max_uses')
            ->where(function($q) {
                $q->whereNull('user_id');
                if (auth()->check()) {
                    $q->orWhere('user_id', auth()->id());
                }
            })
            ->orderBy('min_order_amount', 'asc')
            ->get();

        // 4. ĐỒNG BỘ BIẾN: Khớp hoàn hảo với vòng lặp @foreach($cartItems) ngoài giao diện Checkout View
        return view('frontend.cart.checkout', compact('cartItems', 'totalAmount', 'totalVat', 'user', 'discountAmount', 'finalTotal', 'vouchers'));
    }

    /**
     * XỬ LÝ LƯU TRỮ ĐƠN HÀNG THỰC TẾ XUỐNG CSDL MYSQL (ĐÃ ĐỒNG BỘ TOÀN DIỆN THUỘC TÍNH FORM BLADE)
     */
    public function storeOrder(Request $request)
    {
        // Tự động phân tách và bổ sung Tỉnh/Huyện/Xã nếu gửi từ thẻ địa chỉ mặc định
        if ($request->filled('address_street') && (!$request->filled('address_province') || !$request->filled('address_district') || !$request->filled('address_ward'))) {
            $parts = array_filter(array_map('trim', explode(',', $request->input('address_street'))));
            if (count($parts) >= 4) {
                $request->merge([
                    'address_street'   => implode(', ', array_slice($parts, 0, count($parts) - 3)),
                    'address_ward'     => $request->input('address_ward') ?: $parts[count($parts) - 3],
                    'address_district' => $request->input('address_district') ?: $parts[count($parts) - 2],
                    'address_province' => $request->input('address_province') ?: $parts[count($parts) - 1],
                ]);
            } elseif (count($parts) === 3) {
                $request->merge([
                    'address_street'   => $parts[0],
                    'address_ward'     => $request->input('address_ward') ?: $parts[0],
                    'address_district' => $request->input('address_district') ?: $parts[1],
                    'address_province' => $request->input('address_province') ?: $parts[2],
                ]);
            } else {
                $request->merge([
                    'address_ward'     => $request->input('address_ward') ?: 'Giao tận vườn',
                    'address_district' => $request->input('address_district') ?: 'Địa phương',
                    'address_province' => $request->input('address_province') ?: 'Đồng bằng sông Cửu Long',
                ]);
            }
        }

        // 1. Kiểm tra tính hợp lệ của dữ liệu (Validation) khớp 100% với các thuộc tính 'name' ở giao diện HTML
        $rules = [
            'name'             => 'required|string|max:100',
            'phone'            => 'required|string|max:15',
            'email'            => 'required|email|max:100',
            'address_street'   => 'required|string|min:4|max:255',
            'address_ward'     => 'required|string|min:2|max:100',
            'address_district' => 'required|string|min:2|max:100',
            'address_province' => 'required|string|min:2|max:100',
            'payment_method'   => 'required|in:cod,vietqr',
        ];

        // Nếu khách hàng/đại lý tích chọn "Yêu cầu xuất hóa đơn điện tử công ty", bắt buộc điền MST, tên DN và địa chỉ công ty
        if ($request->has('vat_required')) {
            $rules['company_name']    = 'required|string|max:150';
            $rules['tax_code']        = 'required|string|max:20';
            $rules['company_address'] = 'required|string|max:255';
        }

        $request->validate($rules);

        // 2. Tái bốc tách giỏ hàng từ Session để tính toán tổng tiền bảo mật tuyệt đối tại Backend
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'Phiên làm việc giỏ hàng đã hết hạn hoặc trống!');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Kiểm tra và áp dụng mã giảm giá thực tế để tính toán doanh số chính xác
        $discountAmount = 0;
        $couponCode = null;

        if (session()->has('applied_voucher')) {
            $voucher = \App\Models\Voucher::where('code', session('applied_voucher.code'))->first();
            if ($voucher && $voucher->isValidForCart($cartItems, $totalAmount)) {
                $discountAmount = $voucher->calculateDiscountForCart($cartItems, $totalAmount);
                $couponCode = $voucher->code;
                
                // Tăng số lượt sử dụng voucher
                $voucher->increment('uses');
            }
        }

        // Ghép địa chỉ có cấu trúc chặt chẽ
        $shippingAddress = $request->address_street . ", " . $request->address_ward . ", " . $request->address_district . ", " . $request->address_province;

        // 3. Tiến hành khởi tạo bản ghi đơn hàng mới trong bảng `orders` dưới MySQL bằng các biến đã đồng bộ
        $order = Order::create([
            'user_id'          => Auth::id(), // Sẽ lưu NULL nếu là nông dân vãng lai chưa đăng nhập tài khoản
            'customer_name'    => $request->name,
            'customer_phone'   => $request->phone,
            'customer_email'   => $request->email,
            'shipping_address' => $shippingAddress . ($request->has('vat_required') ? " [Xuất HĐĐT: " . $request->company_name . " - MST: " . $request->tax_code . " - ĐC: " . $request->company_address . "]" : ""),
            'total_amount'     => max(0, $totalAmount - $discountAmount),
            'coupon_code'      => $couponCode,
            'discount_amount'  => $discountAmount,
            'payment_method'   => strtoupper($request->payment_method), // Lưu thành dạng chữ in hoa COD, VIETQR
            'status'           => 'pending',  // Trạng thái mặc định hệ thống: Chờ xác nhận
            'payment_status'   => 'unpaid',   // Tình trạng dòng tiền mặc định: Chưa thanh toán
        ]);

        // Xóa thông tin giảm giá trong session
        session()->forget('applied_voucher');

        // 🌟 LƯU CHI TIẾT CÁC MẶT HÀNG ĐẶT MUA VÀO CSDL VÀ GIẢM TỒN KHO THỰC TẾ
        foreach ($cartItems as $cartKey => $item) {
            $order->items()->create([
                'product_id'         => $item['product_id'],
                'product_variant_id' => $item['variant_id'] ?? null,
                'quantity'           => $item['quantity'],
                'unit_price'         => $item['price'],
                'price_type'         => 'retail',
            ]);

            // Trừ tồn kho thực tế trong CSDL ngay khi khách chốt đơn để giữ hàng cho khách
            if (!empty($item['variant_id'])) {
                $variant = \App\Models\ProductVariant::find($item['variant_id']);
                if ($variant) {
                    $variant->decrement('stock', $item['quantity']);
                }
            } else {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
        }

        // 🌟 GỬI BÁO ĐỘNG HỎA TỐC CHO ROBOT TELEGRAM SAU KHI ĐƠN ĐÃ CÓ ĐỦ SẢN PHẨM (PRD)
        try {
            $order->load('items.product', 'items.productVariant');
            \App\Services\TelegramService::sendOrderAlert($order);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi bắn cảnh báo đơn hàng Telegram: " . $e->getMessage());
        }

        // 🌟 THÔNG BÁO CHO ADMIN, NHÂN VIÊN & KỸ SƯ
        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'staff', 'engineer'])->get();
            foreach ($recipients as $recipient) {
                $recipient->notify(new \App\Notifications\SystemNotification([
                    'title' => 'Có đơn hàng mới!',
                    'body' => "Khách hàng {$order->customer_name} vừa đặt đơn hàng ECF{$order->id} trị giá " . number_format($order->total_amount, 0, ',', '.') . "đ.",
                    'icon' => 'heroicon-o-shopping-bag',
                    'color' => 'success',
                    'url' => '/admin/orders'
                ]));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo đơn hàng mới cho admin: " . $e->getMessage());
        }

        // 🌟 THÔNG BÁO CHO KHÁCH HÀNG (NẾU ĐÃ ĐĂNG NHẬP)
        if (Auth::check()) {
            try {
                Auth::user()->notify(new \App\Notifications\SystemNotification([
                    'title' => 'Đặt hàng thành công!',
                    'body' => "Đơn hàng ECF{$order->id} trị giá " . number_format($order->total_amount, 0, ',', '.') . "đ của bạn đã được tiếp nhận thành công. Chúng tôi đang xử lý đơn hàng.",
                    'icon' => 'heroicon-o-check-circle',
                    'color' => 'success',
                    'url' => route('cart.history')
                ]));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo đặt hàng thành công cho khách: " . $e->getMessage());
            }
        }

        // 🌟 BẢO MẬT & TRẢI NGHIỆM: Dọn dẹp sạch sẽ mảng giỏ hàng Session sau khi đã chốt đơn thành công để tránh đặt trùng
        session()->forget('cart');

        // 4. Chuyển hướng ra phân hệ giao diện chúc mừng đặt hàng thành công bám sát luồng Use Case
        return view('frontend.cart.success', compact('order'));
    }

    /**
     * XỬ LÝ LƯU TẠM SẢN PHẨM VẬT TƯ VÀO PHP SESSION (PRD MỤC 5 - LUỒNG UC-01)
     */
    public function addToCart(Request $request, $slug)
    {
        // 1. Kiểm tra số lượng đặt mua đầu vào từ giao diện Form
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // 2. Tìm kiếm và đối soát thông tin mặt hàng vật tư trong MySQL dựa trên slug đường dẫn
        $product = Product::where('slug', $slug)->firstOrFail();
        
        $quantity = (int) $request->input('quantity', 1);
        $variant = null;
        $cartKey = $product->id;

        // Nếu khách hàng chọn dung tích cụ thể
        if ($request->has('variant_id') && !empty($request->variant_id)) {
            $variant = \App\Models\ProductVariant::where('product_id', $product->id)->find($request->variant_id);
            if ($variant) {
                $cartKey = $product->id . '-' . $variant->id;
            }
        }

        $stockLimit = $variant ? $variant->stock : $product->stock;
        $priceApply = $variant ? $variant->price : $product->price;
        $displayName = $variant ? "{$product->name} ({$variant->capacity})" : $product->name;

        // KIỂM KHO BÃI: Chặn đứng nếu lượng đặt mua vượt quá lượng hàng tồn kho thực tế
        if ($stockLimit < $quantity) {
            return redirect()->back()->with('error', 'Số lượng đặt mua vượt quá lượng hàng tồn thực tế!');
        }

        // 3. Khởi tạo hoặc bốc tách cấu trúc mảng giỏ hàng hiện tại lưu trữ vào Session hệ thống
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
            
            // Tiếp tục đối soát tổng hàng trong giỏ với lượng tồn kho bãi thực tế
            if ($stockLimit < $newQuantity) {
                return redirect()->back()->with('error', 'Tổng số lượng vật tư cộng dồn trong giỏ vượt quá lượng hàng tồn kho bãi!');
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "variant_id" => $variant ? $variant->id : null,
                "name"       => $displayName,
                "quantity"   => $quantity,
                "price"      => $priceApply,
                "unit"       => $product->unit,
                "packaging"  => $product->packaging,
                "image"      => is_array($product->images) && count($product->images) > 0 ? $product->images[0] : null
            ];
        }

        // Ghi nhận mảng dữ liệu giỏ hàng mới đè lại vào PHP Session hệ thống
        session()->put('cart', $cart);

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('cart.checkout');
        }

        return redirect()->back()->with('success', 'Đã thêm vật tư vào giỏ hàng thành công!');
    }

    /**
     * NGHIỆP VỤ TRA CỨU TRỤC ĐỒ HỌA TIMELINE VẬN ĐƠN (PRD MỤC 5 - UC-03)
     */
    public function trackOrder(Request $request)
    {
        $orderIdInput = $request->input('order_id');
        $phone   = $request->input('phone');

        if (auth()->check() && !$orderIdInput && !$phone) {
            return redirect()->route('cart.history');
        }

        $orderId = null;
        if ($orderIdInput) {
            // Chuẩn hóa mã đơn hàng: loại bỏ tiền tố ECF/ecf và ép kiểu nguyên
            $orderId = (int) preg_replace('/^[Ee][Cc][Ff]/', '', trim($orderIdInput));
        }

        // Trường hợp 1: Không nhập gì cả
        if (!$orderId && !$phone) {
            return view('frontend.orders.track_form');
        }

        // Trường hợp 2: Chỉ nhập số điện thoại (Khi quên mã đơn)
        if ($phone && !$orderId) {
            $orders = Order::where('customer_phone', $phone)
                ->orderBy('id', 'desc')
                ->get();

            if ($orders->isEmpty()) {
                return view('frontend.orders.track_form', [
                    'error' => 'Không tìm thấy bất kỳ đơn hàng nào liên kết với số điện thoại này!',
                    'phone' => $phone
                ]);
            }

            return view('frontend.orders.track_form', [
                'foundOrders' => $orders,
                'phone' => $phone
            ]);
        }

        // Trường hợp 3: Có nhập đầy đủ mã đơn và số điện thoại
        $order = Order::where('id', $orderId)
            ->where('customer_phone', $phone)
            ->first();

        // Nếu không tìm thấy đơn, hiển thị form kèm thông báo lỗi
        if (!$order) {
            return view('frontend.orders.track_form', [
                'error' => 'Không tìm thấy đơn hàng trùng khớp thông tin trên hệ thống!',
                'phone' => $phone
            ]);
        }

        $logs = $order->orderLogs()->orderBy('id', 'asc')->get();

        return view('frontend.orders.track', compact('order', 'logs'));
    }

    /**
     * CẬP NHẬT SỐ LƯỢNG MẶT HÀNG TRONG GIỎ SESSION (PRD - UC-05)
     */
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if ($request->id && $request->quantity) {
            $cartKey = $request->id;
            
            // Tách composite key
            $parts = explode('-', $cartKey);
            $productId = $parts[0];
            $variantId = isset($parts[1]) ? $parts[1] : null;

            $product = \App\Models\Product::find($productId);
            $variant = $variantId ? \App\Models\ProductVariant::find($variantId) : null;
            $stockLimit = $variant ? $variant->stock : ($product ? $product->stock : 0);
            
            if ($stockLimit < $request->quantity) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm vượt quá lượng hàng tồn kho!');
            }

            $cart[$cartKey]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Đã cập nhật số lượng vật tư thành công!');
        }
    }

    /**
     * XÓA HẲN MỘT MẶT HÀNG RA KHỎI GIỎ TRONG PHIÊN LÀM VIỆC
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if ($request->id) {
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Đã xóa vật tư khỏi giỏ hàng!');
        }
    }

    /**
     * XEM LỊCH SỬ ĐƠN HÀNG CÁ NHÂN (KHÔNG CẦN NHỚ MÃ ĐƠN - UC-03)
     */
    public function orderHistory()
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng!');
        }

        $orders = Order::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.orders.history', compact('orders'));
    }

    /**
     * KHÁCH HÀNG TỰ HỦY ĐƠN HÀNG (CHỈ ÁP DỤNG CHO ĐƠN CHỜ DUYỆT PENDING)
     */
    public function cancelOrder(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ], [
            'cancel_reason.required' => 'Vui lòng nhập lý do hủy đơn hàng của bạn!',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Bảo mật: Chỉ cho phép tự hủy khi trạng thái còn là 'pending'
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng này do đơn đã chuyển sang bến kho bốc xếp hoặc giao vận!');
        }

        // Cập nhật trạng thái và lý do hủy
        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason
        ]);

        return redirect()->back()->with('success', 'Đã hủy đơn hàng #' . $id . ' thành công và hoàn trả số lượng hàng về bến kho!');
    }

    /**
     * KHÁCH HÀNG THAY ĐỔI PHƯƠNG THỨC THANH TOÁN VÀ ĐỊA CHỈ GIAO HÀNG (CHỈ ÁP DỤNG KHI CHƯA XÁC NHẬN PENDING)
     */
    public function updateOrderInfo(Request $request, $id)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cod,vietqr',
        ], [
            'shipping_address.required' => 'Địa chỉ giao hàng không được để trống.',
            'payment_method.required' => 'Phương thức thanh toán không hợp lệ.',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Chỉ cho phép chỉnh sửa khi trạng thái đơn hàng là 'pending' (Chờ xác nhận)
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Không thể chỉnh sửa đơn hàng này do đơn hàng đã được xác nhận hoặc đang bốc xếp!');
        }

        $order->update([
            'shipping_address' => $request->shipping_address,
            'payment_method' => strtoupper($request->payment_method),
        ]);

        // Gửi thông báo đến trang quản trị cho Admin & Staff
        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
            foreach ($recipients as $recipient) {
                $recipient->notify(new \App\Notifications\SystemNotification([
                    'title' => 'Đơn hàng cập nhật thông tin!',
                    'body' => "Khách hàng {$order->customer_name} vừa thay đổi thông tin thanh toán/địa chỉ của đơn hàng ECF{$order->id}.",
                    'icon' => 'heroicon-o-check-circle',
                    'color' => 'info',
                    'url' => '/admin/orders'
                ]));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi thông báo cập nhật đơn hàng: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thay đổi thông tin giao hàng và thanh toán thành công!');
    }

    /**
     * IN PHIẾU BỐC XẾP XUẤT KHO CHO ADMIN (PRD)
     */
    public function printOrder($id)
    {
        // Bảo vệ tuyến đường chỉ cho Admin/Nhân viên
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Từ chối truy cập!');
        }

        $order = Order::with(['items.product', 'items.productVariant'])->findOrFail($id);
        
        return view('frontend.orders.print', compact('order'));
    }

    /**
     * IN BÁO CÁO THỐNG KÊ DOANH THU & VẬN ĐƠN (PDF)
     */
    public function printRevenueReport()
    {
        // Bảo vệ tuyến đường chỉ cho Admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Từ chối truy cập!');
        }

        $orders = Order::orderBy('id', 'desc')->get();
        
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        
        // Doanh thu theo trạng thái thanh toán
        $paidRevenue = $orders->where('payment_status', 'paid')->sum('total_amount');
        $unpaidRevenue = $orders->where('payment_status', 'unpaid')->sum('total_amount');
        
        // Đếm theo phương thức thanh toán
        $codCount = $orders->where('payment_method', 'COD')->count();
        $vietqrCount = $orders->where('payment_method', 'VIETQR')->count();
        
        // Đếm theo trạng thái đơn hàng
        $pendingCount = $orders->where('status', 'pending')->count();
        $processingCount = $orders->where('status', 'processing')->count();
        $shippingCount = $orders->where('status', 'shipping')->count();
        $completedCount = $orders->where('status', 'completed')->count();
        $cancelledCount = $orders->where('status', 'cancelled')->count();

        return view('frontend.orders.revenue_report', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'paidRevenue',
            'unpaidRevenue',
            'codCount',
            'vietqrCount',
            'pendingCount',
            'processingCount',
            'shippingCount',
            'completedCount',
            'cancelledCount'
        ));
    }

    public function applyVoucher(Request $request)
    {
        $code = $request->input('code');
        
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng của bạn đang trống!'
            ]);
        }

        $subtotal = 0;
        $totalVat = 0;
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            
            $product = Product::find($item['product_id']);
            $vatRate = $product ? $product->getVatRate() : 0;
            if ($vatRate > 0) {
                $totalVat += $itemTotal * $vatRate / (100 + $vatRate);
            }
        }

        // HỦY MÃ GIẢM GIÁ
        if (empty($code)) {
            session()->forget('applied_voucher');
            return response()->json([
                'success' => true,
                'message' => 'Đã hủy áp dụng mã giảm giá.',
                'code' => '',
                'discount_amount' => 0,
                'discount_amount_formatted' => '0đ',
                'new_total' => $subtotal,
                'new_total_formatted' => number_format($subtotal, 0, ',', '.') . 'đ',
                'new_vat_formatted' => $totalVat > 0 ? number_format($totalVat, 0, ',', '.') . 'đ' : 'Không chịu thuế GTGT'
            ]);
        }

        // Tìm kiếm voucher
        $voucher = \App\Models\Voucher::where('code', strtoupper($code))->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc không tồn tại!'
            ]);
        }

        $errorMessage = '';
        if (!$voucher->isValidForCart($cartItems, $subtotal, $errorMessage)) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ]);
        }

        // Tính toán chiết khấu dựa trên giỏ hàng
        $discount = $voucher->calculateDiscountForCart($cartItems, $subtotal);
        
        // Lưu thông tin vào session
        session()->put('applied_voucher', [
            'code' => $voucher->code,
            'discount' => $discount
        ]);

        $newTotal = $subtotal - $discount;
        if ($subtotal > 0) {
            $totalVat = $totalVat * ($newTotal / $subtotal);
        }

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'code' => $voucher->code,
            'discount_amount' => $discount,
            'discount_amount_formatted' => number_format($discount, 0, ',', '.') . 'đ',
            'new_total' => $newTotal,
            'new_total_formatted' => number_format($newTotal, 0, ',', '.') . 'đ',
            'new_vat_formatted' => $totalVat > 0 ? number_format($totalVat, 0, ',', '.') . 'đ' : 'Không chịu thuế GTGT'
        ]);
    }
}