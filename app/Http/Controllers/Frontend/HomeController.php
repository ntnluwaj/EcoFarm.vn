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
        // Cấu hình Cache 5 phút (300 giây) tối ưu hóa hiệu năng chịu tải thực tế
        $categories = cache()->remember('home_categories', 300, fn() => Category::whereNull('parent_id')->get());

        $featuredProducts = cache()->remember('home_featured_products', 300, fn() => Product::where('status', 1)
            ->latest()
            ->take(8)
            ->get());

        $latestPosts = cache()->remember('home_latest_posts', 300, fn() => Post::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(3)
            ->get());

        $banners = cache()->remember('home_banners', 300, fn() => Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get());

        return view('frontend.index', compact('categories', 'featuredProducts', 'latestPosts', 'banners'));
    }
    
}