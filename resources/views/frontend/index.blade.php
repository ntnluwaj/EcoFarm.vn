@extends('frontend.layouts.master')

@section('title', 'Cung Ứng Vật Tư Nông Nghiệp ')

@section('content')
<div class="overflow-hidden-x">
    <div class="bg-glow-green"></div>
    <div class="bg-glow-orange"></div>
@if(isset($banners) && $banners->count() > 0)
    <!-- Bootstrap Carousel Slider cho Banner động -->
    <div id="heroCarousel" class="carousel slide mb-5 shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($banners as $index => $banner)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="carousel-item-container">
                        <!-- Ken Burns Background Image -->
                        <div class="carousel-item-bg" style="background-image: url('{{ asset('storage/' . $banner->image_path) }}');"></div>
                        
                        <!-- Lớp phủ màu mượt từ trái qua phải -->
                        <div class="carousel-overlay"></div>
                        
                        <div class="carousel-content-card">
                            @if($banner->subtitle)
                                <span class="badge bg-success text-white fw-bold mb-3 px-3 py-2 text-uppercase tracking-wide carousel-badge" style="font-size: 10px; letter-spacing: 1px;">
                                    {{ $banner->subtitle }}
                                </span>
                            @endif
                            <h1 class="display-6 fw-bold mb-3 carousel-title" style="line-height: 1.3; font-weight: 800; color: #1b5e20;">
                                {{ $banner->title }}
                            </h1>
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" class="btn btn-success btn-lg fw-bold px-4 py-2.5 text-white shadow-sm mt-3 d-inline-flex align-items-center gap-2 carousel-btn" style="font-size: 13px; border-radius: 12px; transition: all 0.3s ease; background-color: #2e7d32; border: none;">
                                    <i class="fa-solid fa-circle-chevron-right"></i> KHÁM PHÁ NGAY
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@else
    <!-- Default Static Fallback Banner -->
    <div class="container mb-5">
        <div class="p-5 text-white rounded-4 shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);">
            <div class="row align-items-center py-4">
                <div class="col-md-7 z-3 position-relative">
                    <span class="badge bg-warning text-dark fw-bold mb-3 px-3 py-2 text-uppercase tracking-wide">Giải pháp số nông nghiệp vụ mới 2026</span>
                    <h1 class="display-5 fw-bold mb-3">Đồng Hành Cùng Nhà Vườn Việt</h1>
                    <p class="lead text-white-50 mb-4">Cung cấp phân bón hữu cơ, thuốc bảo vệ thực vật chính hãng, chất lượng cao với biểu giá sỉ ưu đãi lớn, tối ưu hóa năng suất mùa vụ tại khu vực Đồng bằng sông Cửu Long.</p>
                    <a href="#danh-muc-vattu" class="btn btn-warning btn-lg fw-bold px-4 py-2.5 text-dark shadow-sm">
                        <i class="fa-solid fa-basket-shopping me-2"></i>Xem ngay danh mục vật tư
                    </a>
                </div>
                <div class="col-md-5 d-none d-md-block text-center position-relative">
                    <i class="fa-solid fa-seedling text-white opacity-10 position-absolute" style="font-size: 300px; right: -50px; top: -150px;"></i>
                    <i class="fa-solid fa-leaf text-warning fs-1 mb-3"></i>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container mb-5" id="danh-muc-vattu">
    <div class="d-flex align-items-center mb-4">
        <div class="p-2 bg-success-subtle text-success rounded-3 me-3"><i class="fa-solid fa-layer-group fs-5"></i></div>
        <h4 class="fw-bold text-dark mb-0">Danh mục vật tư ngành hàng</h4>
    </div>
    <div class="row g-3">
        @foreach($categories as $cat)
            <div class="col-md-6">
                <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 transition-all border-start border-4 border-success hover-shadow">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-3 text-success me-3">
                                    <i class="fa-solid @if($cat->id == 1) fa-flask-vial @else fa-mound @endif fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $cat->name }}</h5>
                                    <p class="text-muted small mb-0">Cung ứng sản phẩm đạt chuẩn quy trình GlobalGAP</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted opacity-50"></i>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <div class="p-2 bg-success-subtle text-success rounded-3 me-3"><i class="fa-solid fa-star fs-5"></i></div>
            <h4 class="fw-bold text-dark mb-0">Sản phẩm vật tư nổi bật đầu vụ</h4>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-sm fw-bold px-3 py-2 rounded-3">
            Xem tất cả hàng hóa <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $prod)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between product-card transition-all">
                        
                        <div class="position-relative p-3 bg-light text-center d-flex align-items-center justify-content-center" style="height: 200px; overflow: hidden;">
                            @php
                                $imgArray = is_array($prod->images) ? $prod->images : [];
                                $firstImg = count($imgArray) > 0 ? $imgArray[0] : null;
                            @endphp
                            
                            @if($loop->iteration <= 2)
                                <span class="position-absolute badge text-white text-xs px-2.5 py-1 rounded-pill" style="top: 8px; right: 8px; font-size: 9px; background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%) !important; border: 1px solid rgba(255,255,255,0.3); z-index: 10;">
                                    <i class="fa-solid fa-fire me-1 text-warning"></i>Bán chạy
                                </span>
                            @endif
                            
                            @if($firstImg)
                                <img src="{{ asset('storage/' . $firstImg) }}" alt="{{ $prod->name }}" class="img-fluid product-img" style="max-height: 160px; object-fit: contain;">
                            @else
                                <i class="fa-solid fa-prescription-bottle-medical text-success-subtle" style="font-size: 60px;"></i>
                            @endif
                        </div>

                        <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <span class="text-muted text-xs d-block mb-1">{{ $prod->category->name ?? 'Vật tư EcoFarm' }}</span>
                                <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="min-height: 44px; line-height: 1.4;">{{ $prod->name }}</h6>
                                <p class="text-xs text-muted mb-3"><i class="fa-solid fa-box me-1"></i>Quy cách: {{ $prod->packaging }}</p>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div>
                                        <span class="text-success fw-bold fs-6">{{ number_format($prod->price, 0, ',', '.') }}đ</span>
                                    </div>
                                    <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-success btn-sm px-2.5 py-1.5 rounded-3 fw-bold text-xs shadow-xs" style="background-color: #2e7d32; border: none;">
                                        Xem chi tiết <i class="fa-solid fa-angle-right ms-0.5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info border-0 rounded-3 shadow-sm p-4 text-center small text-muted">
            <i class="fa-solid fa-folder-open d-block fs-3 mb-2 opacity-50"></i> Hệ thống hiện tại đang cập nhật kho hàng hóa mới!
        </div>
    @endif
</div>

<!-- Homepage About Introduction Section -->
<div class="container mb-5">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="row g-0">
            <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                <span class="badge bg-success-subtle text-success fw-bold align-self-start mb-3 px-3 py-1.5 rounded-pill text-xs">Về chúng tôi</span>
                <h3 class="fw-bold text-dark mb-3">EcoFarm - Nền Tảng Cung Ứng Vật Tư Số Hóa</h3>
                <p class="text-secondary small mb-3" style="line-height: 1.7;">
                    EcoFarm tự hào là đối tác chiến lược đồng hành cùng hơn 5.000 nhà vườn trên khắp vùng Đồng bằng sông Cửu Long. Chúng tôi đem đến mô hình cung ứng vật tư bán lẻ B2C hiện đại, minh bạch, loại bỏ hoàn toàn nỗi lo hàng giả, hàng nhái.
                </p>
                <p class="text-secondary small mb-4" style="line-height: 1.7;">
                    Tất cả sản phẩm phân bón hữu cơ, thuốc bảo vệ thực vật sinh học phân phối bởi EcoFarm đều đạt chuẩn GlobalGAP, an toàn cho thổ nhưỡng đất đai và bảo vệ sức khỏe con người.
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('about') }}" class="btn btn-success btn-sm fw-bold px-3 py-2 rounded-3" style="background-color: #2e7d32; border: none;">
                        Đọc câu chuyện của chúng tôi <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f1f8e9 0%, #dcedc8 100%); position: relative; overflow: hidden; min-height: 250px;">
                <div class="text-center z-3">
                    <i class="fa-solid fa-leaf text-success mb-3" style="font-size: 70px;"></i>
                    <h5 class="fw-bold text-success">Đồng Hành Cùng Nhà Nông</h5>
                    <p class="text-muted small mb-0">Cam kết 100% chất lượng từ chuyên gia</p>
                </div>
                <i class="fa-solid fa-circle-nodes text-success opacity-5 position-absolute" style="font-size: 200px; left: -50px; bottom: -50px;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex align-items-center mb-4">
        <div class="p-2 bg-success-subtle text-success rounded-3 me-3"><i class="fa-solid fa-book-open fs-5"></i></div>
        <h4 class="fw-bold text-dark mb-0">Cẩm nang kỹ thuật & Lịch mùa vụ mới</h4>
    </div>
    
    <div class="row g-4">
        @if(isset($latestPosts) && $latestPosts->count() > 0)
            @foreach($latestPosts as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-shadow transition-all">
                        <div class="p-4">
                            <span class="text-success fw-bold text-xs mb-2 d-block"><i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->format('d/m/Y') }}</span>
                            <h5 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 16px; line-height: 1.4;">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-success-text">{{ $post->title }}</a>
                            </h5>
                            <p class="text-muted small text-truncate-2 mb-0">{{ strip_tags($post->content) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="p-4 bg-white rounded-4 shadow-sm text-center text-muted small">
                    <i class="fa-solid fa-newspaper d-block fs-4 mb-2 opacity-50"></i> Các bài viết hướng dẫn canh tác nông nghiệp đang được biên soạn.
                </div>
            </div>
        @endif
    </div>
</div>
</div>

<style>
    .overflow-hidden-x {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
    .bg-glow-green {
        position: absolute;
        width: 450px;
        height: 450px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(46, 125, 50, 0.07) 0%, rgba(255, 255, 255, 0) 70%);
        top: 15%;
        left: -200px;
        z-index: -1;
        pointer-events: none;
    }
    .bg-glow-orange {
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 152, 0, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        bottom: 25%;
        right: -250px;
        z-index: -1;
        pointer-events: none;
    }
    .product-img {
        transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
    }
    .product-card:hover .product-img {
        transform: scale(1.08) rotate(1deg);
    }
    .product-card {
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        position: relative;
    }
    .product-card::after {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        border-radius: inherit;
        box-shadow: 0 15px 35px rgba(46, 125, 50, 0.15);
        opacity: 0;
        z-index: -1;
        transition: opacity 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .product-card:hover {
        transform: translateY(-8px);
        border-color: rgba(46, 125, 50, 0.18) !important;
    }
    .product-card:hover::after {
        opacity: 1;
    }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .hover-success-text:hover { color: #2e7d32 !important; }
    .hover-shadow:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; transform: translateY(-3px); }

    /* Premium Carousel Layout & Glassmorphism Styling */
    .carousel-item-container {
        height: 480px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    .carousel-item-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
        transform: scale(1);
        transition: transform 0.6s ease-in-out;
    }
    /* Ken Burns Zoom Effect */
    .carousel-item.active .carousel-item-bg {
        animation: kenburns 20s ease-out forwards;
    }
    @keyframes kenburns {
        0% { transform: scale(1.02); }
        100% { transform: scale(1.12); }
    }
    /* Smooth left-fade overlay blending into the body background #f8f9fa */
    .carousel-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(248, 249, 250, 0.95) 0%, rgba(248, 249, 250, 0.7) 35%, rgba(248, 249, 250, 0.25) 70%, rgba(248, 249, 250, 0) 100%);
        z-index: 1;
    }
    /* Premium Glowing Glassmorphic Card */
    .carousel-content-card {
        z-index: 2;
        position: relative;
        background: rgba(255, 255, 255, 0.78);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-left: 8px solid #2e7d32;
        padding: 40px 45px;
        border-radius: 24px;
        max-width: 580px;
        box-shadow: 0 30px 60px rgba(27, 94, 32, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        margin-left: 8%;
    }
    
    /* Modern Pill Badge Glow */
    .carousel-badge {
        background: rgba(46, 125, 50, 0.1) !important;
        color: #2e7d32 !important;
        border: 1px solid rgba(46, 125, 50, 0.25) !important;
        border-radius: 50px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 6px 16px !important;
        letter-spacing: 1px !important;
        display: inline-block;
    }

    /* Premium Gradient Title */
    .carousel-title {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #388e3c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 850 !important;
        line-height: 1.3;
    }
    
    /* Staggered Animations for content inside active slide */
    .carousel-item .carousel-content-card > * {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .carousel-item.active .carousel-content-card > * {
        opacity: 1;
        transform: translateY(0);
    }
    .carousel-item.active .carousel-content-card .carousel-badge {
        transition-delay: 0.1s;
    }
    .carousel-item.active .carousel-content-card .carousel-title {
        transition-delay: 0.25s;
    }
    .carousel-item.active .carousel-content-card .carousel-btn {
        transition-delay: 0.4s;
    }

    /* Pulse Glowing Button (Green Glow) */
    .carousel-btn {
        animation: buttonGlow 2.5s infinite;
        border-radius: 12px !important;
    }
    @keyframes buttonGlow {
        0% { box-shadow: 0 0 0 0 rgba(46, 125, 80, 0.45); }
        70% { box-shadow: 0 0 0 12px rgba(46, 125, 80, 0); }
        100% { box-shadow: 0 0 0 0 rgba(46, 125, 80, 0); }
    }

    /* Premium Pill-shaped Indicators */
    .carousel-indicators [data-bs-target] {
        width: 20px;
        height: 5px;
        border-radius: 30px;
        background-color: rgba(46, 125, 50, 0.25);
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .carousel-indicators .active {
        width: 40px;
        background-color: #2e7d32 !important;
        box-shadow: 0 0 8px rgba(46, 125, 50, 0.4);
    }

    /* Glassmorphic Rounded Navigation Arrows */
    .carousel-control-prev, .carousel-control-next {
        width: 48px;
        height: 48px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 50%;
        margin: 0 20px;
        opacity: 0;
        transition: all 0.3s ease;
        border: 1px solid rgba(46, 125, 50, 0.1);
        color: #1b5e20 !important;
        box-shadow: 0 8px 24px rgba(27, 94, 32, 0.08);
    }
    #heroCarousel:hover .carousel-control-prev, 
    #heroCarousel:hover .carousel-control-next {
        opacity: 1;
    }
    .carousel-control-prev:hover, .carousel-control-next:hover {
        background: #2e7d32;
        border-color: #2e7d32;
        color: white !important;
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.3);
    }
</style>
@endsection