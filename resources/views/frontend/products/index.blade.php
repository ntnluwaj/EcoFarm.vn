@extends('frontend.layouts.master')

@section('title', 'Danh Sách Vật Tư Nông Nghiệp - EcoFarm')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-4 border shadow-xs small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none fw-bold"><i class="fa-solid fa-house me-1"></i>Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Sản phẩm vật tư</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filter Card -->
        <div class="col-lg-3">
            <div class="ecofarm-card p-4 sticky-top" style="top: 20px; z-index: 10;">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center">
                    <i class="fa-solid fa-sliders text-success me-2"></i>Bộ lọc vật tư
                </h5>
                
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search Input -->
                    <div class="mb-4">
                        <label class="form-label text-muted text-xs font-bold text-uppercase mb-1.5">Từ khóa tìm kiếm</label>
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 14px; top: 50%; transform: translateY(-50%); font-size: 12px;"></i>
                            <input type="text" name="search" class="form-control rounded-pill bg-light border ps-5 py-2 text-xs" placeholder="Tìm tên phân bón, thuốc..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category List -->
                    <div class="mb-4">
                        <label class="form-label text-muted text-xs font-bold text-uppercase mb-2">Danh mục ngành hàng</label>
                        <div class="d-flex flex-column gap-1.5">
                            <a href="{{ route('products.index') }}" class="text-decoration-none text-xs p-2.5 rounded-3 d-flex align-items-center justify-content-between {{ !request('category_id') ? 'bg-success text-white fw-bold shadow-xs' : 'text-dark bg-light hover-bg-emerald' }}">
                                <span><i class="fa-solid fa-boxes-stacked me-2"></i>Tất cả ngành hàng</span>
                                <span class="badge {{ !request('category_id') ? 'bg-white text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill" style="font-size: 10px;">Tất cả</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="text-decoration-none text-xs p-2.5 rounded-3 d-flex align-items-center justify-content-between {{ request('category_id') == $cat->id ? 'bg-success text-white fw-bold shadow-xs' : 'text-dark bg-light hover-bg-emerald' }}">
                                    <span>
                                        <i class="fa-solid @if(str_contains(strtolower($cat->name), 'bảo vệ') || str_contains(strtolower($cat->name), 'thuốc') || str_contains(strtolower($cat->name), 'sâu')) fa-flask-vial @elseif(str_contains(strtolower($cat->name), 'phân')) fa-mound @else fa-seedling @endif me-2"></i>{{ $cat->name }}
                                    </span>
                                    <span class="badge {{ request('category_id') == $cat->id ? 'bg-white text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill" style="font-size: 10px;">Vật tư</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    @if(request()->has('category_id') || request()->has('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-ecofarm-outline w-100 py-2">
                            <i class="fa-solid fa-arrow-rotate-left me-1"></i>Đặt lại bộ lọc
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Main Product Grid -->
        <div class="col-lg-9">
            <!-- Header Result Bar -->
            <div class="ecofarm-card p-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-xs d-block">Danh mục vật tư nông nghiệp chính hãng</span>
                    <h5 class="fw-bold text-dark mb-0">Kho Sản Phẩm Khai Thác B2C & B2B</h5>
                </div>
                <span class="ecofarm-badge ecofarm-badge-success">
                    <span class="ecofarm-dot ecofarm-dot-green"></span>{{ $products->count() }} mặt hàng sẵn kho
                </span>
            </div>

            @if($products->count() > 0)
                <div class="row g-3">
                    @foreach($products as $prod)
                        <div class="col-sm-6 col-md-4">
                            <div class="ecofarm-product-card">
                                <!-- Image Header -->
                                <div class="ecofarm-product-image-wrapper">
                                    @php
                                        $imgArray = is_array($prod->images) ? $prod->images : [];
                                        $firstImg = count($imgArray) > 0 ? $imgArray[0] : null;
                                        $imgUrl = \App\Models\Product::formatImageUrl($firstImg);
                                    @endphp
                                    
                                    @if($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="{{ $prod->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div style="display: none; height: 100%; width: 100%; align-items: center; justify-content: center; background: #f8fafc;">
                                            <i class="fa-solid fa-prescription-bottle-medical text-success opacity-50" style="font-size: 50px;"></i>
                                        </div>
                                    @else
                                        <div style="display: flex; height: 100%; width: 100%; align-items: center; justify-content: center; background: #f8fafc;">
                                            <i class="fa-solid fa-prescription-bottle-medical text-success opacity-50" style="font-size: 50px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Body -->
                                <div class="ecofarm-product-body">
                                    <div class="d-flex justify-content-between align-items-center mb-1.5">
                                        <span class="ecofarm-badge ecofarm-badge-info" style="font-size: 10px; padding: 2px 8px;">
                                            {{ $prod->category->name ?? 'Vật tư EcoFarm' }}
                                        </span>
                                        <label class="form-check-label text-xs text-muted cursor-pointer select-none d-inline-flex align-items-center gap-1">
                                            <input type="checkbox" class="form-check-input btn-compare-toggle" data-id="{{ $prod->id }}" data-name="{{ $prod->name }}" data-image="{{ $imgUrl ?? '' }}" style="width: 13px; height: 13px;"> So sánh
                                        </label>
                                    </div>

                                    <h6 class="ecofarm-product-title">{{ $prod->name }}</h6>
                                    
                                    <p class="text-xs text-muted mb-2" style="font-size: 11.5px;">
                                        <i class="fa-solid fa-box text-success me-1"></i>Quy cách: {{ $prod->packaging }}
                                    </p>

                                    <!-- Price & CTA -->
                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                                        <div>
                                            <span class="ecofarm-product-price d-block p-0">
                                                {{ number_format($prod->price, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-muted" style="font-size: 10px;">Niêm yết B2C</span>
                                        </div>

                                        <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-ecofarm-primary py-1.5 px-3">
                                            Chi tiết <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="ecofarm-card p-5 text-center text-muted">
                    <i class="fa-solid fa-magnifying-glass-blur fs-1 text-success opacity-50 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark mb-1">Không tìm thấy vật tư nông nghiệp phù hợp</h6>
                    <p class="small text-muted mb-0">Vui lòng thay đổi từ khóa tìm kiếm hoặc chọn lại danh mục phân loại khác.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-bg-emerald:hover {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
    }
</style>
@endsection