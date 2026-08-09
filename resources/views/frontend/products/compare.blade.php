@extends('frontend.layouts.master')

@section('title', 'So Sánh Vật Tư Nông Nghiệp - EcoFarm')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Sản phẩm vật tư</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">So sánh vật tư</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-4 bg-white p-4 rounded-4 shadow-sm">
        <h3 class="fw-bold text-dark mb-1"><i class="fa-solid fa-scale-balanced text-success me-2"></i>Bàn So Sánh Kỹ Thuật Vật Tư</h3>
        <p class="text-muted small mb-0">Phân tích chi tiết và đối chiếu trực quan các thông số kỹ thuật giữa các loại phân bón, thuốc bảo vệ thực vật để giúp quý khách đưa ra quyết định mua hàng chính xác nhất.</p>
    </div>

    @if(count($products) > 0)
        <div class="crm-filter-panel mb-4 overflow-hidden">
            <div class="table-responsive no-scrollbar">
                <table class="table table-bordered align-middle mb-0 text-center" style="min-width: 750px; table-layout: fixed;">
                    <thead>
                        <tr>
                            <!-- Cột thuộc tính tiêu đề -->
                            <th class="bg-light text-start text-muted fw-bold align-middle border-end-2" style="width: 20%; font-size: 13px;">
                                Thuộc tính đối chiếu
                            </th>
                            
                            <!-- Cột sản phẩm -->
                            @foreach($products as $prod)
                                <th class="p-4 position-relative align-middle" style="width: calc(80% / {{ count($products) }});">
                                    <!-- Nút loại khỏi so sánh -->
                                    <button type="button" 
                                            class="btn-remove-from-table position-absolute top-0 end-0 m-2 bg-light border text-danger rounded-circle d-flex align-items-center justify-content-center hover-danger transition-all" 
                                            data-id="{{ $prod->id }}" 
                                            title="Loại khỏi so sánh"
                                            style="width: 28px; height: 28px; font-size: 12px; z-index: 10;">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <!-- Ảnh sản phẩm -->
                                    <div class="mb-3 bg-light rounded-3 p-2 d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                                        @php
                                            $imgArray = is_array($prod->images) ? $prod->images : [];
                                            $firstImg = count($imgArray) > 0 ? $imgArray[0] : null;
                                            $imgUrl = \App\Models\Product::formatImageUrl($firstImg);
                                        @endphp
                                        @if($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="{{ $prod->name }}" class="img-fluid" style="max-height: 100px; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <div style="display: none;">
                                                <i class="fa-solid fa-prescription-bottle-medical text-success-subtle" style="font-size: 40px;"></i>
                                            </div>
                                        @else
                                            <i class="fa-solid fa-prescription-bottle-medical text-success-subtle" style="font-size: 40px;"></i>
                                        @endif
                                    </div>

                                    <!-- Tên sản phẩm -->
                                    <h6 class="fw-bold text-dark text-truncate-2 mb-2 px-1" style="font-size: 13.5px; line-height: 1.4; min-height: 38px;">
                                        <a href="{{ route('products.show', $prod->slug) }}" class="text-dark text-decoration-none hover-success">
                                            {{ $prod->name }}
                                        </a>
                                    </h6>

                                    <!-- Đánh giá sao -->
                                    <div class="mb-2 text-warning small" style="font-size: 11px;">
                                        @php
                                            $avgRating = round($prod->reviews->avg('rating') ?? 5);
                                        @endphp
                                        {!! str_repeat('<i class="fa-solid fa-star"></i>', $avgRating) !!}
                                        {!! str_repeat('<i class="fa-regular fa-star"></i>', 5 - $avgRating) !!}
                                        <span class="text-muted text-xs ms-1">({{ $prod->reviews->count() }})</span>
                                    </div>

                                    <!-- Giá bán -->
                                    <div class="mb-3">
                                        <strong class="text-success fs-5">{{ number_format($prod->price, 0, ',', '.') }}đ</strong>
                                        <span class="d-block text-muted text-xs" style="font-size: 10px;">Giá bán lẻ niêm yết</span>
                                    </div>

                                    <!-- Nút đưa vào giỏ hàng -->
                                    <form action="{{ route('cart.add', $prod->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm w-100 py-2 rounded-3 fw-bold shadow-sm text-xs" style="background-color: #2e7d32; border: none;">
                                            <i class="fa-solid fa-cart-plus me-1"></i> Mua ngay
                                        </button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Giai đoạn/Loại vật tư -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2">Phân loại ngành hàng</td>
                            @foreach($products as $prod)
                                <td class="small fw-medium text-dark">{{ $prod->category->name ?? 'Không phân loại' }}</td>
                            @endforeach
                        </tr>

                        <!-- Thương hiệu / Nhà cung cấp -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2">Thương hiệu / Nhà sản xuất</td>
                            @foreach($products as $prod)
                                <td class="small text-dark fw-medium text-success">{{ $prod->brand->name ?? 'EcoFarm cung ứng' }}</td>
                            @endforeach
                        </tr>

                        <!-- Quy cách đóng gói -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2">Quy cách đóng gói</td>
                            @foreach($products as $prod)
                                <td class="small text-dark">{{ $prod->packaging }}</td>
                            @endforeach
                        </tr>

                        <!-- Đơn vị cơ bản -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2">Đơn vị cơ sở</td>
                            @foreach($products as $prod)
                                <td class="small text-dark">{{ $prod->unit }}</td>
                            @endforeach
                        </tr>

                        <!-- Tình trạng hàng hóa -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2">Tồn kho khả dụng</td>
                            @foreach($products as $prod)
                                <td class="small">
                                    @if($prod->stock > 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">Còn {{ $prod->stock }} {{ $prod->unit }}</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1">Hết hàng</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Hướng dẫn kỹ thuật/sử dụng -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2 align-top pt-3">Hướng dẫn sử dụng & Liều lượng</td>
                            @foreach($products as $prod)
                                <td class="text-start small text-muted px-3 py-3 align-top" style="font-size: 11.5px; line-height: 1.6; word-break: break-word;">
                                    {!! nl2br(e($prod->usage_guide ?? 'Vui lòng liên hệ kỹ sư nông nghiệp hoặc hotline tư vấn để nhận hướng dẫn sử dụng cụ thể cho từng loại thổ nhưỡng.')) !!}
                                </td>
                            @endforeach
                        </tr>

                        <!-- Mô tả kỹ thuật -->
                        <tr>
                            <td class="text-start bg-light fw-semibold ps-3 small text-muted border-end-2 align-top pt-3">Mô tả đặc tính sản phẩm</td>
                            @foreach($products as $prod)
                                <td class="text-start small text-muted px-3 py-3 align-top" style="font-size: 11.5px; line-height: 1.6; word-break: break-word;">
                                    {!! nl2br(e($prod->description ?? 'Không có mô tả bổ sung.')) !!}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
            <i class="fa-solid fa-scale-balanced text-muted mb-3" style="font-size: 55px;"></i>
            <h5 class="text-muted fw-bold">Bàn so sánh của bạn đang trống!</h5>
            <p class="text-muted small px-3">Vui lòng quay lại danh sách sản phẩm, tích chọn từ 2 đến 3 sản phẩm vật tư nông nghiệp để tiến hành phân tích đối chiếu thông số.</p>
            <a href="{{ route('products.index') }}" class="btn btn-success px-4 py-2 mt-3 fw-bold rounded-3" style="background-color: #2e7d32; border: none;">
                Quay lại trang sản phẩm
            </a>
        </div>
    @endif
</div>

<style>
    .border-end-2 {
        border-right: 2px solid #dee2e6 !important;
    }
    .hover-danger:hover {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
        box-shadow: 0 4px 8px rgba(220,53,69,0.25);
    }
    .table th, .table td {
        border-color: #dee2e6;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const compareKey = 'ecofarm_compare_list';
        let compareList = JSON.parse(localStorage.getItem(compareKey)) || [];

        // Xử lý nút xóa sản phẩm trực tiếp từ bảng
        document.querySelectorAll('.btn-remove-from-table').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                compareList = compareList.filter(item => item.id != id);
                localStorage.setItem(compareKey, JSON.stringify(compareList));

                // Cập nhật URL và tải lại trang
                if (compareList.length > 0) {
                    const idsString = compareList.map(item => item.id).join(',');
                    window.location.href = `{{ url('/so-sanh') }}?ids=` + idsString;
                } else {
                    window.location.href = `{{ url('/so-sanh') }}`;
                }
            });
        });
    });
</script>
@endsection
