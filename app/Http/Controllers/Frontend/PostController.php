<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * TRANG DANH SÁCH CẨM NĂNG KỸ THUẬT & MÙA VỤ
     */
    public function index(Request $request)
    {
        $query = Post::query();

        // 1. Bộ lọc chuyên mục nếu có
        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category', $request->input('category'));
        }

        // Chỉ lấy các bài viết đã được phê duyệt xuất bản
        $query->whereNotNull('published_at')->where('published_at', '<=', now());

        // 2. Lấy danh sách bài viết mới nhất phân trang 9 bản ghi/trang
        $posts = $query->orderBy('id', 'desc')->paginate(9);

        // 3. Lấy động danh sách các chuyên mục hiện có để hiển thị thanh lọc
        $categories = Post::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('frontend.posts.index', compact('posts', 'categories'));
    }

    /**
     * TRANG CHI TIẾT BÀI VIẾT CẨM NĂNG
     */
    public function show($slug)
    {
        // 1. Đối soát lấy thông tin bài viết theo slug (đảm bảo đã xuất bản)
        $post = Post::where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // 2. Lấy 3 bài viết liên quan cùng chuyên mục (ngoại trừ bài viết hiện tại, đã xuất bản)
        $relatedPosts = Post::where('category', $post->category)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        // 3. Lấy 3 sản phẩm vật tư gợi ý ngẫu nhiên chào hàng tăng doanh thu (PRD)
        $recommendedProducts = \App\Models\Product::where('status', 1)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('frontend.posts.show', compact('post', 'relatedPosts', 'recommendedProducts'));
    }
}
