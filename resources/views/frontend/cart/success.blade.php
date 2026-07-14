@extends('frontend.layouts.master')

@section('title', 'Đặt Hàng Thành Công - EcoFarm')

@section('content')
<div class="container py-5 text-center" style="min-height: 75vh;">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="mb-4">
                <i class="fa-solid fa-circle-check text-success animate__animated animate__bounceIn" style="font-size: 70px;"></i>
            </div>

            <span class="text-uppercase text-muted small fw-bold tracking-wider d-block mb-1">Hệ thống ghi nhận thành công</span>
            <h2 class="fw-bold text-dark mb-3">Cảm Ơn Bạn Đã Đặt Hàng!</h2>
            <p class="text-secondary small mb-5">Đơn hàng của bạn đã được chuyển đến bộ phận điều phối bến kho Cần Thơ để tiến hành đối soát và bốc xếp vận chuyển trong thời gian ngắn nhất.</p>

            <div class="card border-0 shadow-sm rounded-4 text-start bg-white p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-receipt text-success me-2"></i>Chi tiết vận đơn #{ $order->id }
                </h5>
                
                <div class="d-flex flex-column gap-2.5" style="font-size: 14px;">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Người nhận vật tư:</span>
                        <strong class="text-dark">{{ $order->customer_name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Số điện thoại:</span>
                        <strong class="text-dark">{{ $order->customer_phone }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Địa chỉ bến nhận:</span>
                        <strong class="text-dark text-end" style="max-width: 70%;">{{ $order->shipping_address }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Phương thức dòng tiền:</span>
                        <strong class="text-uppercase text-success">{{ $order->payment_method }}</strong>
                    </div>
                    <hr class="my-2 text-muted opacity-25">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Tổng tiền hóa đơn:</span>
                        <span class="text-danger fw-bold fs-4">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                    </div>
                </div>
            </div>

            @if(strtolower($order->payment_method) === 'vietqr')
                <div class="card border-0 shadow-sm rounded-4 text-center bg-white p-4 mb-4 border border-success-subtle animate__animated animate__fadeInUp">
                    <h5 class="fw-bold text-success mb-3">
                        <i class="fa-solid fa-qrcode me-2"></i>Quét mã VietQR thanh toán nhanh
                    </h5>
                    <p class="text-secondary small mb-3">
                        Mở ứng dụng Ngân hàng (Mobile Banking) của bạn, chọn chức năng <strong>Quét mã QR</strong> và quét mã dưới đây để tự động điền số tiền & thông tin chuyển khoản:
                    </p>
                    
                    @php
                        $bankId = 'vcb';
                        $accountNo = '1031309340';
                        $accountName = rawurlencode('NGUYEN THI NGOC LUA');
                        $memo = rawurlencode('EcoFarm DH' . $order->id);
                        $amount = (int) $order->total_amount;
                        $qrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.jpg?amount={$amount}&addInfo={$memo}&accountName={$accountName}";
                    @endphp
                    
                    <div class="d-inline-block p-3 bg-light rounded-4 border border-light-subtle mb-3 position-relative shadow-sm" style="max-width: 250px;">
                        <img src="{{ $qrUrl }}" alt="Mã thanh toán VietQR EcoFarm" class="img-fluid rounded-3" style="max-height: 220px;">
                    </div>
                    
                    <div class="p-3 bg-light rounded-3 text-start small border text-dark" style="font-size: 13px;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ngân hàng thụ hưởng:</span>
                            <strong class="text-success-emphasis">Vietcombank (VCB)</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Chủ tài khoản:</span>
                            <strong>NGUYEN THI NGOC LUA</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Số tài khoản:</span>
                            <strong class="text-success-emphasis">1031309340</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Số tiền chuyển:</span>
                            <strong class="text-danger">{{ number_format($amount, 0, ',', '.') }}đ</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Nội dung chuyển khoản:</span>
                            <strong class="text-primary">EcoFarm DH{{ $order->id }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-lg fw-bold px-4 py-2.5 text-xs rounded-3 d-inline-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-basket-shopping"></i> Tiếp tục mua vật tư
                </a>
                
                @if(auth()->check())
                    <a href="{{ route('cart.history') }}" class="btn btn-success btn-lg fw-bold px-4 py-2.5 text-xs rounded-3 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm" style="background-color: #2e7d32; border: none;">
                        <i class="fa-solid fa-clock-rotate-left"></i> Xem lịch sử đơn hàng
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .text-xs { font-size: 14px !important; }
</style>
@endsection