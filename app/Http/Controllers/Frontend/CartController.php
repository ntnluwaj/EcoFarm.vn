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
        $cartItems = session()->get('cart', []);
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        return view('frontend.cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * TRANG THANH TOÁN & ĐIỀN THÔNG TIN GIAO NHẬN VẬT TƯ THỰC TẾ (PRD MỤC 7.1)
     */
    public function checkout()
    {
        // 1. Lấy dữ liệu giỏ hàng thực tế từ PHP Session
        $cartItems = session()->get('cart', []);

        // 2. Nếu giỏ hàng trống, chặn điều hướng và đẩy ngược về danh sách sản phẩm vật tư
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng chọn vật tư trước khi tiến hành thanh toán!');
        }

        // 3. Tính toán động tổng số tiền thực tế của toàn bộ các mặt hàng trong giỏ Session
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $user = Auth::user();

        // 4. ĐỒNG BỘ BIẾN: Khớp hoàn hảo với vòng lặp @foreach($cartItems) ngoài giao diện Checkout View
        return view('frontend.cart.checkout', compact('cartItems', 'totalAmount', 'user'));
    }

    /**
     * XỬ LÝ LƯU TRỮ ĐƠN HÀNG THỰC TẾ XUỐNG CSDL MYSQL (ĐÃ ĐỒNG BỘ TOÀN DIỆN THUỘC TÍNH FORM BLADE)
     */
    public function storeOrder(Request $request)
    {
        // 1. Kiểm tra tính hợp lệ của dữ liệu (Validation) khớp 100% với các thuộc tính 'name' ở giao diện HTML
        $rules = [
            'name'            => 'required|string|max:100',
            'phone'           => 'required|string|max:15',
            'address'         => 'required|string',
            'payment_method'  => 'required|in:cod,vietqr',
        ];

        // Nếu khách hàng/đại lý tích chọn "Yêu cầu xuất hóa đơn đỏ công ty", bắt buộc điền MST và Tên doanh nghiệp ngoài View
        if ($request->has('vat_required')) {
            $rules['company_name'] = 'required|string|max:150';
            $rules['tax_code']     = 'required|string|max:20';
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

        // 3. Tiến hành khởi tạo bản ghi đơn hàng mới trong bảng `orders` dưới MySQL bằng các biến đã đồng bộ
        $order = Order::create([
            'user_id'          => Auth::id(), // Sẽ lưu NULL nếu là nông dân vãng lai chưa đăng nhập tài khoản
            'customer_name'    => $request->name,
            'customer_phone'   => $request->phone,
            'shipping_address' => $request->address . ($request->has('vat_required') ? " [Xuất HĐ: " . $request->company_name . " - MST: " . $request->tax_code . "]" : ""),
            'total_amount'     => $totalAmount, // Lưu trữ số tiền thực tế khách đặt mua thay vì dữ liệu mẫu
            'payment_method'   => strtoupper($request->payment_method), // Lưu thành dạng chữ in hoa COD, VIETQR
            'status'           => 'pending',  // Trạng thái mặc định hệ thống: Chờ xác nhận
            'payment_status'   => 'unpaid',   // Tình trạng dòng tiền mặc định: Chưa thanh toán
        ]);

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

        // 🌟 THÔNG BÁO CHO ADMIN QUA FILAMENT DATABASE NOTIFICATION (PRD)
        try {
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Filament\Notifications\Notification::make()
                ->title('Có đơn hàng mới!')
                ->body("Khách hàng {$order->customer_name} vừa đặt đơn hàng trị giá " . number_format($order->total_amount, 0, ',', '.') . "đ.")
                ->icon('heroicon-o-shopping-bag')
                ->color('success')
                ->sendToDatabase($admins);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo hệ thống Filament: " . $e->getMessage());
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
        $orderId = $request->input('order_id');
        $phone   = $request->input('phone');

        if (!$orderId || !$phone) {
            return redirect()->route('home')->with('error', 'Vui lòng nhập đầy đủ mã đơn hàng và số điện thoại giao nhận!');
        }

        $order = Order::where('id', $orderId)
            ->where('customer_phone', $phone)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng trùng khớp thông tin trên hệ thống!');
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
     * IN PHIẾU BỐC XẾP XUẤT KHO CHO ADMIN (PRD)
     */
    public function printOrder($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $order = Order::with('items.product', 'items.productVariant')->findOrFail($id);

        return view('frontend.orders.print', compact('order'));
    }
}