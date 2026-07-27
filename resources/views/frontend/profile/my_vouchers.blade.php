@extends('frontend.layouts.master')

@section('title', 'Ví Voucher của tôi - EcoFarm')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.index') }}" class="text-success text-decoration-none">Tài khoản</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Ví Voucher của tôi</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-2.5" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-circle-user fs-1"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                    <span class="badge bg-success-subtle text-success text-xs px-2.5 py-1">{{ strtoupper($user->role) }}</span>
                </div>
                <div class="list-group list-group-flush" style="font-size: 14px;">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-user-gear me-2"></i>Thông tin cá nhân
                    </a>
                    <a href="{{ route('cart.history') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Lịch sử đơn hàng
                    </a>
                    <a href="{{ route('rewards.index') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-gift me-2"></i>Tích điểm đổi quà
                    </a>
                    <a href="{{ route('profile.vouchers') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-success bg-success-subtle rounded-3">
                        <i class="fa-solid fa-ticket me-2"></i>Ví Voucher của tôi
                    </a>
                </div>
            </div>
        </div>

        <!-- Voucher Details -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa-solid fa-ticket text-success me-2"></i>Ví Voucher cá nhân của bạn
                    </h5>

                    @if($vouchers->count() > 0)
                        <div class="row g-3">
                            @foreach($vouchers as $voucher)
                                @php
                                    $isExpired = $voucher->expires_at && $voucher->expires_at->isPast();
                                    $isUsed = $voucher->uses >= $voucher->max_uses;
                                    
                                    if ($isUsed) {
                                        $statusClass = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                                        $statusText = 'Đã sử dụng';
                                    } elseif ($isExpired) {
                                        $statusClass = 'bg-danger-subtle text-danger border-danger-subtle';
                                        $statusText = 'Đã hết hạn';
                                    } else {
                                        $statusClass = 'bg-success-subtle text-success border-success-subtle';
                                        $statusText = 'Khả dụng';
                                    }
                                @endphp
                                <div class="col-md-6">
                                    <div class="card border rounded-4 p-3 position-relative bg-light" style="border-left: 5px solid {{ $isUsed || $isExpired ? '#6c757d' : '#2e7d32' }} !important;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge border {{ $statusClass }} px-2 py-0.5 text-xs fw-bold">{{ $statusText }}</span>
                                                @if($voucher->product)
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-0.5 text-xs ms-1">Mã sản phẩm</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-muted" style="font-size: 11px;">
                                                Hạn dùng: {{ $voucher->expires_at ? $voucher->expires_at->format('d/m/Y H:i') : 'Vô thời hạn' }}
                                            </span>
                                        </div>
                                        
                                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">
                                            Giảm {{ $voucher->type === 'percent' ? $voucher->value . '%' : number_format($voucher->value, 0, ',', '.') . 'đ' }}
                                        </h5>
                                        
                                        <p class="text-xs text-muted mb-3" style="font-size: 12px; line-height: 1.4;">
                                            @if($voucher->product)
                                                Áp dụng riêng cho vật tư: <strong class="text-dark">{{ $voucher->product->name }}</strong>.
                                            @else
                                                Áp dụng cho toàn bộ đơn hàng.
                                            @endif
                                            Đơn hàng tối thiểu: <strong>{{ number_format($voucher->min_order_amount, 0, ',', '.') }}đ</strong>.
                                        </p>

                                        <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                            <div>
                                                <span class="text-xs text-muted d-block" style="font-size: 10px;">MÃ GIẢM GIÁ</span>
                                                <code class="fw-bold text-success fs-6">{{ $voucher->code }}</code>
                                            </div>
                                            @if(!$isUsed && !$isExpired)
                                                <button type="button" class="btn btn-outline-success btn-sm px-2.5 py-1 fw-bold rounded-3 btn-copy-code" data-code="{{ $voucher->code }}" style="font-size: 11px;">
                                                    <i class="fa-regular fa-copy me-1"></i> Sao chép
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted small">
                            <i class="fa-solid fa-receipt d-block fs-1 text-success-subtle mb-3"></i>
                            <p class="fw-bold text-dark mb-1">Ví voucher của bạn đang trống!</p>
                            <p class="mb-3 text-xs">Bạn chưa đổi điểm thưởng lấy mã giảm giá cá nhân nào.</p>
                            <a href="{{ route('rewards.index') }}" class="btn btn-success btn-sm px-3.5 py-2 fw-bold rounded-3" style="background-color: #2e7d32; border: none;">
                                <i class="fa-solid fa-gift me-1"></i> Đi tích lũy & đổi quà
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-copy-code').forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                navigator.clipboard.writeText(code).then(() => {
                    // Hiển thị phản hồi sao chép
                    const origHTML = this.innerHTML;
                    this.innerHTML = '<i class="fa-solid fa-check me-1"></i> Đã chép';
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success', 'text-white');
                    
                    setTimeout(() => {
                        this.innerHTML = origHTML;
                        this.classList.remove('btn-success', 'text-white');
                        this.classList.add('btn-outline-success');
                    }, 2000);
                }).catch(err => {
                    console.error('Lỗi sao chép mã: ', err);
                });
            });
        });
    });
</script>
@endsection
