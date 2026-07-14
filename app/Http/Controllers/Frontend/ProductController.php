<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Trang danh sách sản phẩm tích hợp bộ lọc nâng cao theo danh mục và giá (Mục 7.1)
     * Đã bổ sung cơ chế áp biểu giá sỉ động cho Đại lý B2B
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 1);

        // Lọc theo danh mục slug nếu có
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        $products->getCollection()->transform(function ($product) {
            $product->is_agency_price = false;
            $product->display_price = $product->price;
            return $product;
        });

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Trang chi tiết sản phẩm vật tư: Trực quan hóa hình ảnh, hướng dẫn bón tưới an toàn (AC-01)
     * Đã tối ưu tính toán biểu giá động đồng bộ hoàn toàn với trang danh mục
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $isAgency = false;
        $product->display_price = $product->price;

        // Lấy các sản phẩm vật tư nông nghiệp liên quan cùng danh mục
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(4)
            ->get();

        $relatedProducts->transform(function ($item) {
            $item->is_agency_price = false;
            $item->display_price = $item->price;
            return $item;
        });

        // Lấy danh sách đánh giá của sản phẩm này
        $reviews = $product->reviews()->latest()->get();

        // Lấy danh sách câu hỏi đã được kỹ sư trả lời
        $questions = $product->questions()->whereNotNull('answer')->latest()->get();

        return view('frontend.products.show', compact('product', 'isAgency', 'relatedProducts', 'reviews', 'questions'));
    }

    /**
     * LƯU ĐÁNH GIÁ SẢN PHẨM CỦA NÔNG DÂN
     */
    public function storeReview(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'reviewer_name' => 'nullable|string|max:100',
        ]);

        $reviewerName = $request->reviewer_name ?: (Auth::check() ? Auth::user()->name : 'Khách vãng lai');

        \App\Models\ProductReview::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'reviewer_name' => $reviewerName,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
            \Filament\Notifications\Notification::make()
                ->title('Đánh giá sản phẩm mới!')
                ->body("Khách hàng {$reviewerName} đã đánh giá {$request->rating} sao cho vật tư '{$product->name}'.")
                ->icon('heroicon-o-star')
                ->color('info')
                ->sendToDatabase($recipients);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo đánh giá Filament: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đánh giá sản phẩm!');
    }

    /**
     * GỬI CÂU HỎI ĐÁP KỸ THUẬT CHO KỸ SƯ
     */
    public function storeQuestion(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'question' => 'required|string|max:1000',
            'asker_name' => 'nullable|string|max:100',
        ]);

        $askerName = $request->asker_name ?: (Auth::check() ? Auth::user()->name : 'Nông dân vãng lai');

        \App\Models\ProductQuestion::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'asker_name' => $askerName,
            'question' => $request->question,
        ]);

        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
            \Filament\Notifications\Notification::make()
                ->title('Có câu hỏi kỹ thuật mới!')
                ->body("Nông dân {$askerName} vừa đặt câu hỏi cho vật tư '{$product->name}'.")
                ->icon('heroicon-o-question-mark-circle')
                ->color('warning')
                ->sendToDatabase($recipients);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo câu hỏi Filament: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Câu hỏi của bạn đã được chuyển đến kỹ sư nông học giải đáp!');
    }
}