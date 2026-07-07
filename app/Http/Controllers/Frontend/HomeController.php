<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Nghiệp vụ hiển thị trang chủ công ty vật tư (PRD mục 7.1)
     */
    public function index()
    {
        // Lấy danh mục gốc (parent_id là null) phục vụ duyệt nhanh danh mục đa tầng
        $categories = Category::whereNull('parent_id')->get();

        // Lấy 8 mặt hàng vật tư nông nghiệp nổi bật đang kinh doanh
        $featuredProducts = Product::where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        // Lấy 3 bài viết cẩm nang kỹ thuật, lịch mùa vụ mới nhất vừa xuất bản (chỉ lấy bài đã duyệt)
        $latestPosts = Post::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(3)
            ->get();

        // Lấy danh sách banner động đang hoạt động ngoài trang chủ
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Trả dữ liệu về view trang chủ ngoài Frontend
        return view('frontend.index', compact('categories', 'featuredProducts', 'latestPosts', 'banners'));
    }
    
}