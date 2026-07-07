@extends('frontend.layouts.master')

@section('title', $post->title . ' - Cẩm Nang Nông Nghiệp')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-success text-decoration-none">Cẩm nang nông nghiệp</a></li>
            <li class="breadcrumb-item active text-muted text-truncate" aria-current="page" style="max-width: 300px;">{{ $post->title }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <span class="badge bg-success mb-3 px-2.5 py-1.5 text-uppercase fw-semibold align-self-start" style="font-size: 11px;">
                    {{ $post->category ?? 'Cẩm nang vật tư' }}
                </span>
                
                <h1 class="fw-bold text-dark mb-3 fs-2" style="line-height: 1.3;">{{ $post->title }}</h1>
                
                <div class="d-flex align-items-center gap-3 text-muted small pb-4 mb-4 border-bottom border-light-subtle">
                    <span><i class="fa-regular fa-calendar me-1.5 text-success"></i>Đăng ngày: <strong>{{ $post->created_at ? $post->created_at->format('d/m/Y') : date('d/m/Y') }}</strong></span>
                    <span><i class="fa-solid fa-user-doctor me-1.5 text-success"></i>Tác giả: <strong>Kỹ sư Nông học EcoFarm</strong></span>
                </div>

                <!-- Cover Photo / Banner -->
                @if(!empty($post->thumbnail) && file_exists(public_path('storage/' . $post->thumbnail)))
                    <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                @else
                    <div class="mb-4 bg-success-subtle rounded-3 text-center p-5 text-success position-relative overflow-hidden" style="min-height: 200px; display: flex; align-items: center; justify-content: center; opacity: 0.85; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
                        <div>
                            <i class="fa-solid fa-graduation-cap mb-3" style="font-size: 60px;"></i>
                            <h4 class="fw-bold mb-0">HƯỚNG DẪN KỸ THUẬT CANH TÁC</h4>
                        </div>
                    </div>
                @endif

                <!-- Article Content -->
                <div class="article-body text-dark" style="line-height: 1.8; font-size: 14.5px;">
                    {!! $post->content !!}
                </div>

                <!-- Back button -->
                <div class="pt-4 mt-5 border-top border-light-subtle">
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-success btn-sm fw-bold px-3 py-2 rounded-3 text-xs">
                        <i class="fa-solid fa-chevron-left me-1"></i> Quay lại danh mục cẩm nang
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar / Related posts -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 position-sticky" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom" style="font-size: 16px;">
                    <i class="fa-solid fa-bookmark text-success me-2"></i>Hướng dẫn liên quan
                </h5>

                @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                    <div class="d-flex flex-column gap-3.5">
                        @foreach($relatedPosts as $rel)
                            <a href="{{ route('posts.show', $rel->slug) }}" class="text-decoration-none text-dark d-block">
                                <div class="p-3 bg-light rounded-3 border border-light-subtle transition-all hover-success-bg">
                                    <span class="text-success fw-bold text-xs d-block mb-1"><i class="fa-regular fa-clock me-1"></i>{{ $rel->created_at ? $rel->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
                                    <h6 class="fw-bold mb-0 text-truncate-2" style="font-size: 13px; line-height: 1.4;">{{ $rel->title }}</h6>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted small py-3">Không có bài viết liên quan khác trong chuyên mục này.</div>
                @endif
            </div>

            <!-- Recommended Products Card -->
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mt-4">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom" style="font-size: 16px;">
                    <i class="fa-solid fa-seedling text-success me-2"></i>Vật tư khuyên dùng
                </h5>
                @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
                    <div class="d-flex flex-column gap-3">
                        @foreach($recommendedProducts as $prod)
                            <div class="p-2.5 bg-light rounded-3 border border-light-subtle d-flex align-items-center gap-3">
                                <div class="bg-white rounded-2 p-1 border text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                                    @if(is_array($prod->images) && count($prod->images) > 0)
                                        <img src="{{ asset('storage/' . $prod->images[0]) }}" alt="{{ $prod->name }}" class="img-fluid" style="max-height: 40px; object-fit: contain;">
                                    @else
                                        <i class="fa-solid fa-prescription-bottle-medical text-success fs-5"></i>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 12.5px; line-height: 1.3;">
                                        <a href="{{ route('products.show', $prod->slug) }}" class="text-dark text-decoration-none hover-success">{{ $prod->name }}</a>
                                    </h6>
                                    <span class="text-danger fw-bold text-xs">{{ number_format($prod->price, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted small py-3">Không có sản phẩm khuyên dùng liên quan.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .article-body h5 { font-weight: bold; color: #1b5e20; margin-top: 24px; margin-bottom: 12px; font-size: 16px; border-left: 4px solid #2e7d32; padding-left: 10px; }
    .article-body p { margin-bottom: 16px; text-align: justify; }
    .article-body ul { margin-bottom: 16px; padding-left: 20px; }
    .article-body li { margin-bottom: 6px; }
    .hover-success-bg:hover { border-color: #2e7d32 !important; background-color: #e8f5e9 !important; }
    .hover-success:hover { color: #2e7d32 !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .text-xs { font-size: 13px !important; }
</style>
@endsection
