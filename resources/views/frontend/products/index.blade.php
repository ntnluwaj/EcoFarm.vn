@extends('frontend.layouts.master')

@section('title', 'Danh Sách Vật Tư Nông Nghiệp - EcoFarm')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Sản phẩm vật tư</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 20px; z-index: 10;">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-filter text-success me-2"></i>Bộ lọc vật tư
                </h5>
                
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Từ khóa tìm kiếm</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control text-xs" placeholder="Tìm tên thuốc, phân bón..." value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit" style="background-color: #2e7d32; border: none;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Danh mục ngành hàng</label>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('products.index') }}" class="text-decoration-none text-xs p-2 rounded-2 {{ !request('category_id') ? 'bg-success text-white fw-bold' : 'text-dark bg-light hover-success' }}">
                                <i class="fa-solid fa-boxes-stacked me-2"></i>Tất cả ngành hàng
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="text-decoration-none text-xs p-2 rounded-2 {{ request('category_id') == $cat->id ? 'bg-success text-white fw-bold' : 'text-dark bg-light hover-success' }}">
                                    <i class="fa-solid @if($cat->id == 1) fa-flask-vial @else fa-mound @endif me-2"></i>{{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    @if(request()->has('category_id') || request()->has('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100 fw-bold rounded-3 text-xs">
                            <i class="fa-solid fa-arrow-rotate-left me-1"></i>Xóa bộ lọc
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-3 rounded-4 shadow-sm">
                <div class="text-dark">
                    <span class="text-muted text-xs">Phân hệ hiển thị hàng hóa</span>
                    <h5 class="fw-bold mb-0">Kho Vật Tư Sẵn Sàng Khai Thác</h5>
                </div>
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-3 fw-bold text-xs">
                    Tổng cộng: {{ $products->count() }} mặt hàng
                </span>
            </div>

            @if($products->count() > 0)
                <div class="row g-3">
                    @foreach($products as $prod)
                        <div class="col-sm-6 col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between product-card transition-all">
                                
                                <div class="position-relative p-3 bg-light text-center d-flex align-items-center justify-content-center" style="height: 190px;">
                                    @php
                                        $imgArray = is_array($prod->images) ? $prod->images : [];
                                        $firstImg = count($imgArray) > 0 ? $imgArray[0] : null;
                                    @endphp
                                    
                                    @if($firstImg)
                                        <img src="{{ asset('storage/' . $firstImg) }}" alt="{{ $prod->name }}" class="img-fluid" style="max-height: 150px; object-fit: contain;">
                                    @else
                                        <i class="fa-solid fa-prescription-bottle-medical text-success-subtle" style="font-size: 55px;"></i>
                                    @endif
                                    <span class="position-absolute top-2 start-2 badge bg-dark text-white text-xs px-2 py-1 rounded-2" style="font-size: 10px;">ĐVT: {{ $prod->unit }}</span>
                                </div>

                                <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="text-muted text-xs d-block mb-1" style="font-size: 11px;">{{ $prod->category->name ?? 'Vật tư EcoFarm' }}</span>
                                        <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="min-height: 40px; line-height: 1.4; font-size: 14px;">{{ $prod->name }}</h6>
                                        <p class="text-xs text-muted mb-3" style="font-size: 12px;"><i class="fa-solid fa-box me-1 text-success"></i>Quy cách: {{ $prod->packaging }}</p>
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                            <div class="flex-grow-1">
                                                    <span class="text-success fw-bold d-block" style="font-size: 15px;">
                                                        {{ number_format($prod->price, 0, ',', '.') }}đ
                                                    </span>
                                                    <span class="text-muted d-block" style="font-size: 10px; color: #7f8c8d !important;">
                                                        <i class="fa-solid fa-tags"></i> Giá bán lẻ công khai
                                                    </span>
                                            </div>
                                            
                                            <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-success btn-sm px-2.5 py-1.5 rounded-3 fw-bold text-xs flex-shrink-0" style="background-color: #2e7d32; border: none;">
                                                Chi tiết <i class="fa-solid fa-angle-right ms-0.5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white text-muted small">
                    <i class="fa-solid fa-magnifying-glass-blur d-block fs-2 text-success-subtle mb-3"></i>
                    <p class="fw-bold text-dark mb-1">Không tìm thấy sản phẩm phù hợp</p>
                    <p class="mb-0 text-xs">Vui lòng thay đổi từ khóa tìm kiếm hoặc chọn danh mục ngành hàng khác.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .product-card {
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        position: relative;
        z-index: 1;
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
    .hover-success:hover { background-color: #e8f5e9 !important; color: #2e7d32 !important; font-weight: 500; }
    .text-xs { font-size: 13px !important; }
</style>
@endsection