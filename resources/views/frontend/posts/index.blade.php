@extends('frontend.layouts.master')

@section('title', 'Cẩm Nang Nông Nghiệp & Kỹ Thuật Canh Tác')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Cẩm nang nông nghiệp</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <div class="p-2 bg-success-subtle text-success rounded-3 me-3"><i class="fa-solid fa-book-open fs-4"></i></div>
        <div>
            <h4 class="fw-bold text-dark mb-1">CẨM NĂNG NÔNG NGHIỆP & LỊCH MÙA VỤ</h4>
            <p class="text-secondary small mb-0">Hướng dẫn canh tác, kỹ thuật bón phân và giải pháp phòng ngừa dịch bệnh nông sản từ chuyên gia EcoFarm</p>
        </div>
    </div>

    <!-- Category Filters -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('posts.index') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ !request('category') ? 'btn-success' : 'btn-light text-secondary border' }}" style="{{ !request('category') ? 'background-color: #2e7d32; border: none;' : '' }}">
            Tất cả bài viết
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('posts.index', ['category' => $cat]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ request('category') === $cat ? 'btn-success' : 'btn-light text-secondary border' }}" style="{{ request('category') === $cat ? 'background-color: #2e7d32; border: none;' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    @if(isset($posts) && $posts->count() > 0)
        <div class="row g-4 mb-4">
            @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between article-card transition-all">
                        <div>
                            <!-- Thumbnail -->
                            <div class="position-relative bg-light text-center overflow-hidden" style="height: 180px;">
                                @if(!empty($post->thumbnail) && file_exists(public_path('storage/' . $post->thumbnail)))
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 bg-success-subtle d-flex align-items-center justify-content-center text-success opacity-75" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
                                        <i class="fa-solid fa-seedling" style="font-size: 60px;"></i>
                                    </div>
                                @endif
                                <span class="position-absolute top-2 start-2 badge bg-dark text-white text-xs px-2 py-1 rounded-2">
                                    {{ $post->category ?? 'Hướng dẫn B2B' }}
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="p-4">
                                <span class="text-success fw-bold text-xs mb-2 d-block">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $post->created_at ? $post->created_at->format('d/m/Y') : date('d/m/Y') }}
                                </span>
                                <h5 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 15px; line-height: 1.4; min-height: 42px;">
                                    {{ $post->title }}
                                </h5>
                                <p class="text-muted small text-truncate-2 mb-0" style="font-size: 12.5px;">
                                    {{ strip_tags($post->content) }}
                                </p>
                            </div>
                        </div>

                        <!-- Read Link -->
                        <div class="px-4 pb-4 bg-white">
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-success btn-sm w-100 fw-bold rounded-3 py-2 text-xs">
                                Xem cẩm nang kỹ thuật <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <!-- Empty Articles -->
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
            <div class="py-4 text-muted small">
                <i class="fa-solid fa-newspaper text-success-subtle mb-3" style="font-size: 80px;"></i>
                <h5 class="fw-bold text-dark mb-1">Cẩm nang nông nghiệp đang được biên soạn</h5>
                <p class="mb-0">Hệ thống đang tổng hợp bài viết kỹ thuật từ các kỹ sư nông học. Vui lòng quay lại sau!</p>
            </div>
        </div>
    @endif
</div>

<style>
    .article-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .text-xs { font-size: 13px !important; }
</style>
@endsection
