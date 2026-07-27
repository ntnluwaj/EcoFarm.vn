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
     * TRANG CẨM NĂNG PHÒNG TRỪ SÂU BỆNH HẠI
     */
    public function pestManagement()
    {
        $posts = Post::query()
            ->where('category', 'Quan ly sau benh hai')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontend.posts.pest_management', compact('posts'));
    }

    /**
     * TRANG KỸ THUẬT CANH TÁC & DINH DƯỠNG
     */
    public function farmingTechniques()
    {
        $posts = Post::query()
            ->where('category', 'Ky thuat canh tac')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontend.posts.farming_techniques', compact('posts'));
    }

    /**
     * TRANG TIN TỨC NÔNG NGHIỆP & THỊ TRƯỜNG
     */
    public function news()
    {
        $posts = Post::query()
            ->where('category', 'Tin tuc nong nghiep')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontend.posts.news', compact('posts'));
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
