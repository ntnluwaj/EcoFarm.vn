@extends('frontend.layouts.master')

@section('title', 'Chi Tiết Tiến Độ Vận Đơn #ECF' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="container py-4" style="max-width: 920px; min-height: 85vh;">

    <!-- 🌟 1. SHOPEE-STYLE STATUS HEADER BANNER -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden mb-4 text-white position-relative" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #388e3c 100%);">
        <div class="p-4 p-md-4.5 z-2 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-extrabold px-3 py-1.5 rounded-pill text-xs shadow-2xs">
                        <i class="fa-solid fa-truck-fast me-1"></i>Mã vận đơn: #ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="text-white-50 text-xs">
                        <i class="fa-regular fa-clock me-1"></i>Ngày chốt: {{ \Carbon\Carbon::parse($order->created_at)->format('H:i - d/m/Y') }}
                    </span>
                </div>
                
                <span class="badge px-3 py-2 text-uppercase fw-extrabold rounded-pill shadow-xs text-xs
                    @if($order->status === 'pending') bg-warning text-dark
                    @elseif($order->status === 'processing') bg-info text-dark
                    @elseif($order->status === 'shipping') bg-light text-success
                    @elseif($order->status === 'completed') bg-success-subtle text-success border border-white
                    @else bg-danger text-white @endif" style="letter-spacing: 0.5px;">
                    @switch($order->status)
                        @case('pending') ⏳ Chờ tổng đài xác nhận @break
                        @case('processing') 📦 Đang đóng gói bốc xếp @break
                        @case('shipping') 🚚 Đang vận chuyển tới nhà vườn @break
                        @case('completed') 🎉 Giao hàng hoàn tất @break
                        @case('cancelled') ❌ Đã hủy đơn hàng @break
                        @default {{ $order->status }}
                    @endswitch
                </span>
            </div>

            <h3 class="fw-extrabold text-white mb-2" style="font-weight: 800; font-size: 22px;">
                @switch($order->status)
                    @case('pending') ĐƠN HÀNG ĐÃ ĐƯỢC TIẾP NHẬN - ĐANG CHỜ XÁC NHẬN @break
                    @case('processing') KHO CẦN THƠ ĐANG ĐÓNG GÓI & BỐC XẾP VẬT TƯ @break
                    @case('shipping') XE TẢI ĐANG TRÊN ĐƯỜNG VẬN CHUYỂN TỚI NHÀ VƯỜN @break
                    @case('completed') ĐƠN HÀNG ĐÃ ĐƯỢC BÀN GIAO THÀNH CÔNG @break
                    @case('cancelled') ĐƠN HÀNG ĐÃ BỊ HỦY TRÊN HỆ THỐNG @break
                @endswitch
            </h3>
            <p class="text-white-50 small mb-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-heart text-warning"></i>
                <span>Cam kết vật tư chính hãng 100% - Kiểm tra tem chống giả trước khi thanh toán.</span>
            </p>
        </div>
        <!-- Decorative bg icon -->
        <i class="fa-solid fa-truck-ramp-box position-absolute text-white opacity-10" style="font-size: 220px; right: -30px; bottom: -60px; z-index: 1;"></i>
    </div>

    <!-- 🌟 2. SHOPEE 4-STEP PROGRESS STEPPER -->
    @php
        $stepIndex = match($order->status) {
            'pending' => 1,
            'processing' => 2,
            'shipping' => 3,
            'completed' => 4,
            'cancelled' => 0,
            default => 1
        };
    @endphp
    @if($order->status !== 'cancelled')
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
            <div class="position-relative py-2">
                <div class="progress position-absolute top-50 start-0 w-100 translate-middle-y" style="height: 4px; z-index: 1; background-color: #e9ecef;">
                    <div class="progress-bar bg-success" style="width: {{ ($stepIndex - 1) * 33.33 }}%;"></div>
                </div>

                <div class="d-flex justify-content-between position-relative z-2">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-2xs {{ $stepIndex >= 1 ? 'bg-success text-white fw-bold' : 'bg-light text-muted border' }}" style="width: 44px; height: 44px; font-size: 16px; transition: all 0.3s ease;">
                            @if($stepIndex > 1) <i class="fa-solid fa-check"></i> @else 1 @endif
                        </div>
                        <span class="d-block text-xs {{ $stepIndex >= 1 ? 'fw-bold text-success' : 'text-muted' }}">1. Đơn hàng đã đặt</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-2xs {{ $stepIndex >= 2 ? 'bg-success text-white fw-bold' : 'bg-light text-muted border' }}" style="width: 44px; height: 44px; font-size: 16px; transition: all 0.3s ease;">
                            @if($stepIndex > 2) <i class="fa-solid fa-check"></i> @else 2 @endif
                        </div>
                        <span class="d-block text-xs {{ $stepIndex >= 2 ? 'fw-bold text-success' : 'text-muted' }}">2. Đang đóng gói</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-2xs {{ $stepIndex >= 3 ? 'bg-success text-white fw-bold' : 'bg-light text-muted border' }}" style="width: 44px; height: 44px; font-size: 16px; transition: all 0.3s ease;">
                            @if($stepIndex > 3) <i class="fa-solid fa-check"></i> @else 3 @endif
                        </div>
                        <span class="d-block text-xs {{ $stepIndex >= 3 ? 'fw-bold text-success' : 'text-muted' }}">3. Đang vận chuyển</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-2xs {{ $stepIndex >= 4 ? 'bg-success text-white fw-bold' : 'bg-light text-muted border' }}" style="width: 44px; height: 44px; font-size: 16px; transition: all 0.3s ease;">
                            4
                        </div>
                        <span class="d-block text-xs {{ $stepIndex >= 4 ? 'fw-bold text-success' : 'text-muted' }}">4. Hoàn tất đơn</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 🌟 3. SHOPEE RECEIVER & DELIVERY ADDRESS CARD WITH RED RIBBON -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4 position-relative">
        <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: repeating-linear-gradient(45deg, #ef4444, #ef4444 12px, #ffffff 12px, #ffffff 24px, #2e7d32 24px, #2e7d32 36px, #ffffff 36px, #ffffff 48px);"></div>

        <div class="p-4 pt-4.5">
            <div class="row g-4">
                <div class="col-md-6 border-end-md">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-location-dot text-danger fs-5"></i>Địa Chỉ Nhận Hàng Vật Tư
                    </h6>
                    <div class="d-flex flex-column gap-1.5 text-sm">
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark fs-6" style="font-weight: 800;">{{ $order->customer_name }}</strong>
                            <span class="text-muted">|</span>
                            <span class="fw-bold text-success"><i class="fa-solid fa-phone me-1 text-xs"></i>{{ $order->customer_phone }}</span>
                        </div>
                        <p class="text-secondary mb-0 mt-1" style="font-size: 13.5px; line-height: 1.5;">
                            {{ $order->shipping_address }}
                        </p>
                        @if($order->customer_email)
                            <span class="text-muted text-xs mt-1"><i class="fa-solid fa-envelope me-1"></i>{{ $order->customer_email }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-receipt text-success fs-5"></i>Thông Tin Thanh Toán & Vận Chuyển
                    </h6>
                    <div class="d-flex flex-column gap-2 text-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary">Phương thức thanh toán:</span>
                            <strong class="text-dark text-uppercase">
                                @if(strtoupper($order->payment_method) === 'VIETQR')
                                    📲 Chuyển khoản VietQR 24/7
                                @else
                                    🚚 Thanh toán khi nhận hàng (COD)
                                @endif
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary">Trạng thái dòng tiền:</span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-bold {{ $order->payment_status === 'paid' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}" style="font-size: 11px;">
                                {{ $order->payment_status === 'paid' ? 'Đã thanh toán thành công' : 'Chưa thanh toán / Thu tiền COD' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary">Đơn vị vận chuyển:</span>
                            <strong class="text-success"><i class="fa-solid fa-truck-fast me-1"></i>Đội xe EcoFarm Chuyên Nông Nghiệp</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 4. SHOPEE PRODUCT ITEM BREAKDOWN TABLE -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="p-4 border-bottom bg-light-subtle d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="fw-extrabold text-dark mb-0 d-flex align-items-center gap-2" style="font-size: 16px; font-weight: 800;">
                <i class="fa-solid fa-boxes-packing text-success"></i> Danh Mục Vật Tư Sản Phẩm Trong Đơn Hàng
            </h5>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill text-xs fw-bold">
                {{ $order->items ? $order->items->count() : 0 }} loại sản phẩm
            </span>
        </div>

        @if($order->items && $order->items->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 14px;">
                    <thead class="table-light text-muted fw-semibold">
                        <tr>
                            <th class="ps-4 py-3">Sản phẩm vật tư</th>
                            <th class="py-3 text-center">Đơn giá</th>
                            <th class="py-3 text-center">Số lượng</th>
                            <th class="pe-4 py-3 text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            @php
                                $product = $item->product;
                                $variant = $item->productVariant;
                                $imgUrl = $product ? $product->primary_image_url : null;
                                $unitPrice = $item->unit_price ?? 0;
                                $qty = $item->quantity ?? 1;
                                $subtotal = $unitPrice * $qty;
                            @endphp
                            <tr>
                                <td class="ps-4 py-3.5">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-1 bg-light rounded-3 border text-center shrink-0 d-flex align-items-center justify-content-center shadow-2xs" style="width: 60px; height: 60px;">
                                            @if($imgUrl)
                                                <img src="{{ $imgUrl }}" alt="{{ $product->name ?? 'Vật tư' }}" class="img-fluid" style="max-height: 50px; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <div style="display: none;">
                                                    <i class="fa-solid fa-prescription-bottle-medical text-success-subtle fs-4"></i>
                                                </div>
                                            @else
                                                <i class="fa-solid fa-prescription-bottle-medical text-success-subtle fs-4"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-extrabold text-dark mb-1" style="font-size: 14px; font-weight: 700;">{{ $product->name ?? 'Sản phẩm vật tư' }}</h6>
                                            <span class="text-muted text-xs">
                                                <i class="fa-solid fa-box text-success me-1"></i>Quy cách: {{ $variant->capacity ?? ($product->packaging ?? 'Tiêu chuẩn') }} ({{ $product->unit ?? 'Sản phẩm' }})
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center fw-bold text-dark">
                                    {{ number_format($unitPrice, 0, ',', '.') }}đ
                                </td>
                                <td class="py-3.5 text-center fw-extrabold text-success fs-6">
                                    x{{ $qty }}
                                </td>
                                <td class="pe-4 py-3.5 text-end fw-extrabold text-danger fs-6">
                                    {{ number_format($subtotal, 0, ',', '.') }}đ
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SHOPEE FINANCIAL BREAKDOWN SUMMARY -->
            <div class="p-4 bg-light-subtle border-top">
                <div class="row justify-content-end">
                    <div class="col-md-6 col-lg-5">
                        <div class="d-flex justify-content-between mb-2 text-sm text-secondary">
                            <span>Tạm tính hàng hóa:</span>
                            <span class="fw-semibold text-dark">{{ number_format($order->total_amount + ($order->discount_amount ?? 0), 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-sm text-secondary">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success fw-bold">Miễn phí giao bãi kho</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2 text-sm text-secondary">
                                <span>Giảm giá Voucher:</span>
                                <span class="text-success fw-bold">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                            </div>
                        @endif
                        <hr class="my-2 border-light-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark text-sm">TỔNG TỀN THANH TOÁN:</span>
                            <span class="text-danger fw-extrabold fs-4" style="font-weight: 900;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- 🌟 5. LOG TIMELINE JOURNEY -->
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h5 class="fw-extrabold text-dark mb-4 d-flex align-items-center gap-2" style="font-size: 16px; font-weight: 800;">
            <i class="fa-solid fa-timeline text-success"></i> Nhật Ký Chuyển Dịch Trạng Thái Vận Đơn
        </h5>
        
        <div class="position-relative ps-4 border-start border-2 border-success-subtle ms-2 timeline-axis">
            @foreach($logs as $index => $log)
                <div class="mb-4 position-relative timeline-node">
                    <span class="position-absolute bg-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                          style="left: -34px !important; width: 22px; height: 22px; top: 2px; border: 3px solid #fff; box-shadow: 0 0 0 2px #2e7d32;">
                        <span class="bg-white rounded-circle" style="width: 6px; height: 6px;"></span>
                    </span>
                    
                    <div class="ms-2 p-3.5 bg-light rounded-3 transition-all timeline-item-box border border-light-subtle">
                        <strong class="text-dark d-block" style="font-size: 14px;">
                            @switch($log->status)
                                @case('pending') <span class="text-warning-emphasis fw-bold"><i class="fa-solid fa-clock me-1.5"></i> Khởi tạo đơn hàng - Hệ thống ghi nhận chờ xác nhận</span> @break
                                @case('processing') <span class="text-info-emphasis fw-bold"><i class="fa-solid fa-box me-1.5"></i> Nhân viên kho Cần Thơ đang đóng gói & bốc xếp vật tư</span> @break
                                @case('shipping') <span class="text-primary fw-bold"><i class="fa-solid fa-truck-fast me-1.5"></i> Đơn hàng đã giao xe tải vận chuyển, đang tới nhà vườn</span> @break
                                @case('completed') <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1.5"></i> Hoàn tất vận đơn - Quý khách đã kiểm tra & ký nhận</span> @break
                                @case('cancelled') <span class="text-danger fw-bold"><i class="fa-solid fa-ban me-1.5"></i> Đơn hàng bị hủy trên hệ thống</span> @break
                            @endswitch
                        </strong>
                        <span class="text-muted d-block mt-1.5 text-xs">
                            <i class="fa-regular fa-clock me-1"></i> Thời gian ghi vết: {{ \Carbon\Carbon::parse($log->log_time)->format('H:i:s - d/m/Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 🌟 6. ACTION CTA BAR -->
    <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="{{ route('home') }}" class="btn btn-outline-success btn-lg fw-bold px-4 py-2.5 rounded-pill d-inline-flex align-items-center gap-2 text-sm">
            <i class="fa-solid fa-house"></i> Quay Lại Trang Chủ
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-success btn-lg fw-extrabold px-5 py-2.5 rounded-pill d-inline-flex align-items-center gap-2 text-sm shadow-md" style="background-color: #2e7d32; border: none;">
            <i class="fa-solid fa-basket-shopping"></i> Khám Phá Vật Tư Khác
        </a>
    </div>

</div>

<style>
    .shadow-2xs { box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important; }
    .border-end-md { border-right: 1px solid #dee2e6 !important; }
    @media (max-width: 767.98px) {
        .border-end-md { border-right: none !important; border-bottom: 1px solid #dee2e6 !important; padding-bottom: 1rem; }
    }
    .timeline-item-box:hover {
        background-color: #f1f8f5 !important;
        transform: translateX(4px);
    }
    .timeline-node:last-child {
        margin-bottom: 0 !important;
    }
</style>
@endsection