@extends('frontend.layouts.master')

@section('title', 'Xác Nhận Đặt Hàng Thành Công - EcoFarm')

@section('content')
<div class="container py-5" style="min-height: 80vh;">

    <!-- 🌟 SHOPEE-STYLE STEP PROGRESS TRACKER BAR -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <div class="row align-items-center text-center g-3">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center justify-content-center gap-2 text-success fw-bold">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-extrabold shadow-sm" style="width: 32px; height: 32px; font-size: 14px;">1</div>
                    <span style="font-size: 13px;">Giỏ Hàng</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center justify-content-center gap-2 text-success fw-bold">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-extrabold shadow-sm" style="width: 32px; height: 32px; font-size: 14px;">2</div>
                    <span style="font-size: 13px;">Điền Thông Tin</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center justify-content-center gap-2 text-success fw-extrabold">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-extrabold shadow-md" style="width: 36px; height: 36px; font-size: 15px;">3</div>
                    <span style="font-size: 14px; color: #1b5e20;">Đặt Hàng Thành Công</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center justify-content-center gap-2 text-muted fw-medium">
                    <div class="rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center font-bold" style="width: 32px; height: 32px; font-size: 14px;">4</div>
                    <span style="font-size: 13px;">Nhận Hàng & Kiểm Trải</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-lg-8">

            <!-- 🌟 SHOPEE SUCCESS BANNER -->
            <div class="card border-0 shadow-sm rounded-4 text-center bg-white p-4 p-md-5 mb-4 position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background: linear-gradient(90deg, #1b5e20 0%, #2e7d32 60%, #f59e0b 100%);"></div>
                
                @if(strtolower($order->payment_method) === 'vietqr')
                    <div class="mb-3">
                        <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-10 text-warning mb-2">
                            <i class="fa-solid fa-clock-rotate-left fs-1 animate__animated animate__pulse animate__infinite"></i>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark fw-bold text-uppercase px-3 py-1.5 rounded-pill mb-2">Trạng thái: Chờ thanh toán VietQR</span>
                    <h2 class="fw-extrabold text-dark mb-2" style="font-weight: 800;">Vui Lòng Chuyển Khoản Thanh Toán!</h2>
                    <p class="text-secondary small max-w-xl mx-auto mb-0" style="max-width: 600px; font-size: 14px; line-height: 1.6;">
                        Đơn hàng của quý khách đã được khởi tạo thành công. Vui lòng quét mã VietQR bên dưới để kích hoạt hệ thống tự động duyệt đơn và bốc xếp hàng hóa hỏa tốc.
                    </p>
                @else
                    <div class="mb-3">
                        <div class="d-inline-flex p-3 rounded-circle bg-success bg-opacity-10 text-success mb-2">
                            <i class="fa-solid fa-circle-check fs-1 animate__animated animate__bounceIn"></i>
                        </div>
                    </div>
                    <span class="badge bg-success text-white fw-bold text-uppercase px-3 py-1.5 rounded-pill mb-2" style="background-color: #2e7d32 !important;">Đã tiếp nhận đơn hàng</span>
                    <h2 class="fw-extrabold text-dark mb-2" style="font-weight: 800;">Cảm Ơn Quý Khách Đã Đặt Hàng!</h2>
                    <p class="text-secondary small max-w-xl mx-auto mb-0" style="max-width: 600px; font-size: 14px; line-height: 1.6;">
                        Đơn hàng vật tư của bạn đã chuyển đến bộ phận điều phối bến kho EcoFarm Cần Thơ. Đội ngũ giao vận sẽ gọi điện xác nhận trước khi giao tận tay.
                    </p>
                @endif
            </div>

            <!-- 🌟 VIETQR PAYMENT CARD WITH ONE-CLICK COPY BUTTONS -->
            @if(strtolower($order->payment_method) === 'vietqr')
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4 border border-success-subtle">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <h5 class="fw-extrabold text-success mb-0 d-flex align-items-center gap-2" style="font-weight: 800;">
                            <i class="fa-solid fa-qrcode fs-4"></i> Mã Thanh Toán VietQR Tự Động 24/7
                        </h5>
                        <span class="badge bg-danger-subtle text-danger fw-bold text-xs">Duyệt tự động 30 giây</span>
                    </div>

                    @php
                        $bankId = 'vcb';
                        $accountNo = '1031309340';
                        $accountName = rawurlencode('NGUYEN THI NGOC LUA');
                        $orderCode = 'ECF' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                        $memo = rawurlencode($orderCode);
                        $amount = (int) $order->total_amount;
                        $qrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.jpg?amount={$amount}&addInfo={$memo}&accountName={$accountName}";
                    @endphp

                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-3 bg-light rounded-4 border d-inline-block shadow-sm">
                                <img src="{{ $qrUrl }}" alt="Mã VietQR EcoFarm" class="img-fluid rounded-3" style="max-height: 230px;">
                            </div>
                            <div class="text-muted text-xs mt-2">
                                <i class="fa-solid fa-camera me-1"></i> Mở App Ngân Hàng & Quét Mã QR
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="p-3.5 bg-light rounded-3 border text-dark" style="font-size: 13.5px;">
                                <div class="d-flex justify-content-between align-items-center mb-2.5">
                                    <span class="text-muted">Ngân hàng thụ hưởng:</span>
                                    <span class="fw-extrabold text-success">Vietcombank (VCB)</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2.5">
                                    <span class="text-muted">Chủ tài khoản:</span>
                                    <span class="fw-bold">NGUYEN THI NGOC LUA</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2.5">
                                    <span class="text-muted">Số tài khoản:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong class="text-dark fs-6">{{ $accountNo }}</strong>
                                        <button type="button" class="btn btn-outline-success btn-xs py-0.5 px-2 rounded-pill fw-bold" onclick="copyToClipboard('{{ $accountNo }}', 'Số tài khoản')">
                                            <i class="fa-regular fa-copy"></i> Sao chép
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2.5">
                                    <span class="text-muted">Số tiền thanh toán:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong class="text-danger fs-5">{{ number_format($amount, 0, ',', '.') }}đ</strong>
                                        <button type="button" class="btn btn-outline-danger btn-xs py-0.5 px-2 rounded-pill fw-bold" onclick="copyToClipboard('{{ $amount }}', 'Số tiền')">
                                            <i class="fa-regular fa-copy"></i> Sao chép
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted font-bold">Nội dung chuyển khoản:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong class="text-primary fs-6">{{ $orderCode }}</strong>
                                        <button type="button" class="btn btn-primary btn-xs py-0.5 px-2 rounded-pill fw-bold" onclick="copyToClipboard('{{ $orderCode }}', 'Nội dung chuyển khoản')">
                                            <i class="fa-regular fa-copy"></i> Sao chép
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 alert alert-warning border-0 rounded-3 p-2.5 text-xs mb-0 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-warning fs-5"></i>
                                <span>Vui lòng nhập <strong>chính xác nội dung chuyển khoản {{ $orderCode }}</strong> để hệ thống tự động kích hoạt đơn!</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 🌟 SHOPEE-STYLE ORDER SUMMARY & SHIPPING DETAILS -->
            <div class="card border-0 shadow-sm rounded-4 text-start bg-white p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h5 class="fw-extrabold text-dark mb-0 d-flex align-items-center gap-2" style="font-weight: 800;">
                        <i class="fa-solid fa-receipt text-success fs-5"></i> Chi Tiết Đơn Hàng #ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </h5>
                    <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill text-xs fw-bold">
                        {{ $order->created_at ? $order->created_at->format('H:i d/m/Y') : now()->format('H:i d/m/Y') }}
                    </span>
                </div>

                <div class="row g-3 mb-4 text-sm" style="font-size: 13.5px;">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border">
                            <div class="fw-bold text-dark mb-2"><i class="fa-solid fa-user me-1 text-success"></i> Người Nhận Hàng</div>
                            <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                            <div class="text-muted">{{ $order->customer_phone }}</div>
                            <div class="text-muted text-xs">{{ $order->customer_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border">
                            <div class="fw-bold text-dark mb-2"><i class="fa-solid fa-location-dot me-1 text-success"></i> Địa Chỉ Giao Vật Tư</div>
                            <div class="text-dark leading-snug">{{ $order->shipping_address }}</div>
                            <div class="mt-2 pt-2 border-top d-flex justify-content-between">
                                <span class="text-muted">Phương thức:</span>
                                <span class="badge bg-success-subtle text-success fw-bold text-uppercase">{{ $order->payment_method }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Items Table -->
                <div class="table-responsive rounded-3 border mb-3">
                    <table class="table align-middle mb-0 text-sm">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3">Sản phẩm vật tư</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end pe-3">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset($item.product->image) }}" alt="{{ $item->product->name }}" class="rounded-3 border object-cover" style="width: 48px; height: 48px;">
                                            @else
                                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark text-sm">{{ $item->product->name ?? 'Sản phẩm vật tư' }}</div>
                                                @if($item->productVariant)
                                                    <span class="badge bg-secondary-subtle text-secondary font-medium text-xs">{{ $item->productVariant->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                                    <td class="text-center fw-bold">x{{ $item->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold text-dark">{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Price Summary -->
                <div class="d-flex flex-column gap-2 pt-2 border-top text-sm" style="font-size: 14px;">
                    @if($order->discount_amount > 0)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Giảm giá Voucher:</span>
                            <span class="text-success fw-bold">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí giao bãi kho</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="fw-extrabold text-dark fs-6">TỔNG THÀNH TIỀN:</span>
                        <span class="text-danger fw-black fs-4" style="font-weight: 900;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>

            <!-- 🌟 ACTION BUTTONS -->
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('orders.track') }}" class="btn btn-outline-success btn-lg fw-bold px-4 py-2.5 rounded-pill d-inline-flex align-items-center gap-2 text-sm">
                    <i class="fa-solid fa-magnifying-glass-location"></i> Tra Cứu Vận Đơn
                </a>
                <a href="{{ route('home') }}" class="btn btn-success btn-lg fw-extrabold px-5 py-2.5 rounded-pill d-inline-flex align-items-center gap-2 text-sm shadow-md" style="background-color: #2e7d32; border: none;">
                    <i class="fa-solid fa-basket-shopping"></i> Tiếp Tục Mua Sắm
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function copyToClipboard(text, label) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Đã sao chép ' + label + ': ' + text);
        }, function(err) {
            console.error('Không thể sao chép: ', err);
        });
    }
</script>

@endsection