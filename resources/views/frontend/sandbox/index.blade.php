@extends('frontend.layouts.master')

@section('title', 'Bảng Điều Khiển Giả Lập Tự Động Hóa Sandbox')

@section('content')
<!-- Custom style directly injected to give a stunning developer console feel -->
<style>
    .sandbox-container {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
    }
    .console-card {
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    .console-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
    }
    .console-header-success {
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
        color: #ffffff;
    }
    .console-header-primary {
        background: linear-gradient(135deg, #0d47a1, #1565c0);
        color: #ffffff;
    }
    .console-header-dark {
        background: linear-gradient(135deg, #212121, #424242);
        color: #ffffff;
    }
    .btn-action {
        border-radius: 8px;
        font-weight: 700;
        transition: all 0.2s ease;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    .btn-action:hover {
        transform: scale(1.03);
    }
    .flow-step {
        position: relative;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        transition: all 0.3s ease;
    }
    .flow-step:hover {
        border-color: #2e7d32;
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.08);
    }
    .flow-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(46, 125, 50, 0.1);
        color: #2e7d32;
        font-size: 1.25rem;
        margin-bottom: 12px;
    }
    /* Stepper flow for table rows */
    .mini-stepper {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .step-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #cbd5e1;
    }
    .step-dot.active {
        background-color: #2e7d32;
        box-shadow: 0 0 8px #2e7d32;
    }
    .step-dot.processing {
        background-color: #0284c7;
        box-shadow: 0 0 8px #0284c7;
    }
    .step-dot.shipping {
        background-color: #0ea5e9;
        box-shadow: 0 0 8px #0ea5e9;
    }
    .step-line {
        flex-grow: 1;
        height: 2px;
        background-color: #e2e8f0;
        min-width: 15px;
    }
    .step-line.active {
        background-color: #2e7d32;
    }
</style>

<div class="sandbox-container py-5">
    <div class="container">
        
        <!-- Header -->
        <div class="text-center mb-5">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="font-size: 12px;">
                <i class="fa-solid fa-code-branch me-1"></i> DEVELOPER MODE & TESTBED
            </span>
            <h1 class="fw-extrabold text-dark display-6 mb-2">EcoFarm Sandbox Control Panel</h1>
            <p class="text-muted mx-auto" style="max-width: 650px; font-size: 15px;">
                Cổng kiểm thử giả lập quy trình tích hợp ngân hàng và đơn vị vận chuyển. Hỗ trợ kích hoạt các cuộc gọi webhook nội bộ thời gian thực để đối soát hệ thống.
            </p>
        </div>

        <!-- Integration flow diagrams -->
        <div class="console-card p-4 mb-5 border-0 bg-white">
            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <i class="fa-solid fa-square-poll-vertical text-success me-2"></i> TIẾN TRÌNH TỰ ĐỘNG HÓA HỆ THỐNG
            </h5>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="flow-step">
                        <div class="flow-icon"><i class="fa-solid fa-qrcode"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Bước 1: VietQR & COD khởi tạo</h6>
                        <p class="mb-0 text-muted small">
                            Đơn hàng được tạo ở trạng thái Chờ duyệt. Nếu chọn VietQR, mã thanh toán được nhúng kèm nội dung: <code>ECF[Mã_DH]</code>.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="flow-step">
                        <div class="flow-icon"><i class="fa-solid fa-building-columns"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Bước 2: Báo có tự động (SePay)</h6>
                        <p class="mb-0 text-muted small">
                            Khách chuyển khoản. SePay bắt được giao dịch, bắn Webhook <code>POST /api/payment/sepay-webhook</code> để xác thực và tự duyệt đơn.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="flow-step">
                        <div class="flow-icon"><i class="fa-solid fa-shipping-fast"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Bước 3: Vận chuyển (GHN Webhook)</h6>
                        <p class="mb-0 text-muted small">
                            Hệ thống gửi đơn sang GHN. Shipper cập nhật lộ trình bắn Webhook <code>POST /api/shipping/ghn-webhook</code> để cập nhật trạng thái đơn.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert" style="background-color: #e8f5e9; color: #1b5e20;">
                <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                <div>
                    <strong class="d-block">Thành công!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert" style="background-color: #ffebee; color: #b71c1c;">
                <i class="fa-solid fa-circle-xmark fs-4 me-3"></i>
                <div>
                    <strong class="d-block">Lỗi thao tác!</strong>
                    <span class="small">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Test orders list -->
            <div class="col-lg-8">
                <div class="console-card overflow-hidden">
                    <div class="console-header-dark py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-database me-2"></i>Đơn hàng kiểm thử mới nhất</h5>
                        <span class="badge bg-white text-dark fw-bold">Hiện có: {{ $orders->count() }} đơn</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                            <thead class="table-light text-secondary fw-semibold">
                                <tr>
                                    <th class="ps-4 py-3">Mã đơn</th>
                                    <th class="py-3">Thông tin nhận</th>
                                    <th class="py-3">Tổng tiền</th>
                                    <th class="py-3">Thanh toán</th>
                                    <th class="py-3">Hành trình đơn</th>
                                    <th class="pe-4 py-3 text-end" style="width: 200px;">Thao tác nhanh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <!-- ID -->
                                        <td class="ps-4 py-3">
                                            <span class="fw-bold text-dark">#DH{{ $order->id }}</span>
                                            <div class="text-muted small" style="font-size: 10px;">ID: {{ $order->id }}</div>
                                        </td>
                                        <!-- Info -->
                                        <td class="py-3">
                                            <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                                            <div class="text-muted" style="font-size: 11px;"><i class="fa-solid fa-phone me-1"></i>{{ $order->customer_phone }}</div>
                                        </td>
                                        <!-- Amount -->
                                        <td class="py-3 fw-bold text-dark">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                        </td>
                                        <!-- Payment Status -->
                                        <td class="py-3">
                                            @if($order->payment_status === 'paid')
                                                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-3 fw-bold mb-1" style="font-size: 10.5px;">
                                                    <i class="fa-solid fa-circle-check me-1"></i>Đã trả tiền
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded-3 fw-bold mb-1" style="font-size: 10.5px;">
                                                    <i class="fa-regular fa-clock me-1"></i>Chưa trả tiền
                                                </span>
                                            @endif
                                            <div class="text-muted font-monospace" style="font-size: 10px;">{{ strtoupper($order->payment_method) }}</div>
                                        </td>
                                        <!-- Progress Stepper -->
                                        <td class="py-3">
                                            <div class="mb-2">
                                                @php
                                                    $statusLabel = match($order->status) {
                                                        'pending' => 'Chờ duyệt',
                                                        'processing' => 'Đang đóng gói',
                                                        'shipping' => 'Đang giao hàng',
                                                        'completed' => 'Hoàn tất',
                                                        'cancelled' => 'Đã hủy',
                                                        default => $order->status
                                                    };
                                                    $statusColor = match($order->status) {
                                                        'pending' => 'text-secondary',
                                                        'processing' => 'text-primary fw-bold',
                                                        'shipping' => 'text-info fw-bold',
                                                        'completed' => 'text-success fw-bold',
                                                        'cancelled' => 'text-danger',
                                                        default => 'text-dark'
                                                    };
                                                @endphp
                                                <span class="{{ $statusColor }}" style="font-size: 12px;">{{ $statusLabel }}</span>
                                            </div>
                                            <!-- Mini Stepper Flow -->
                                            <div class="mini-stepper">
                                                <!-- Created -->
                                                <div class="step-dot active" title="Đã đặt đơn"></div>
                                                <div class="step-line {{ $order->payment_status === 'paid' || $order->status !== 'pending' ? 'active' : '' }}"></div>
                                                
                                                <!-- Paid -->
                                                <div class="step-dot {{ $order->payment_status === 'paid' ? 'active' : '' }}" title="Đã thanh toán"></div>
                                                <div class="step-line {{ in_array($order->status, ['processing', 'shipping', 'completed']) ? 'active' : '' }}"></div>
                                                
                                                <!-- Processing -->
                                                <div class="step-dot {{ in_array($order->status, ['processing', 'shipping', 'completed']) ? 'active' : '' }}" title="Đang chuẩn bị"></div>
                                                <div class="step-line {{ in_array($order->status, ['shipping', 'completed']) ? 'active' : '' }}"></div>
                                                
                                                <!-- Shipping -->
                                                <div class="step-dot {{ in_array($order->status, ['shipping', 'completed']) ? 'active' : '' }}" title="Đang giao"></div>
                                                <div class="step-line {{ $order->status === 'completed' ? 'active' : '' }}"></div>
                                                
                                                <!-- Completed -->
                                                <div class="step-dot {{ $order->status === 'completed' ? 'active' : '' }}" title="Đã hoàn thành"></div>
                                            </div>
                                            @if($order->payment_transaction_id)
                                                <div class="text-muted mt-2 font-monospace" style="font-size: 10px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    Vận đơn: {{ $order->payment_transaction_id }}
                                                </div>
                                            @endif
                                        </td>
                                        <!-- Actions -->
                                        <td class="pe-4 py-3 text-end">
                                            <div class="d-flex flex-column gap-2 align-items-end">
                                                
                                                <!-- SePay Bank Transfer Simulation -->
                                                @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                                    <form action="{{ route('sandbox.paySimulate') }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-success btn-action py-1.5 px-3 btn-action" style="width: 180px;">
                                                            <i class="fa-solid fa-wallet me-1"></i> Báo có VietQR (SePay)
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- GHN Shipping Simulation -->
                                                @if(in_array($order->status, ['pending', 'processing']))
                                                    <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="status" value="shipping">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary btn-action py-1.5 px-3 btn-action" style="width: 180px;">
                                                            <i class="fa-solid fa-truck-fast me-1"></i> Shipper lấy hàng
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($order->status === 'shipping')
                                                    <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn btn-sm btn-outline-success btn-action py-1.5 px-3 btn-action" style="width: 180px;">
                                                            <i class="fa-solid fa-box-open me-1"></i> Giao thành công
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($order->status === 'cancelled')
                                                    <span class="text-danger small" style="font-size: 11px;"><i class="fa-solid fa-ban me-1"></i>Đơn hàng đã bị hủy</span>
                                                @elseif($order->status === 'completed' && $order->payment_status === 'paid')
                                                    <span class="text-success small" style="font-size: 11px;"><i class="fa-solid fa-circle-check me-1"></i>Đã đối soát xong</span>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-regular fa-folder-open fs-3 d-block mb-2"></i>
                                            Chưa có đơn hàng nào được tạo trên hệ thống để kiểm thử!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Custom Webhook Console & Testing form -->
            <div class="col-lg-4">
                <!-- Custom VietQR Payment Form -->
                <div class="console-card overflow-hidden border-0 mb-4">
                    <div class="console-header-success py-3 px-4">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-terminal me-2"></i>Giả lập VietQR thủ công</h5>
                    </div>
                    <div class="p-4 bg-white">
                        <p class="text-muted small">
                            Nhập tùy chọn mã cú pháp và số tiền để mô phỏng một khách hàng chuyển khoản sai cú pháp hoặc sai số tiền, kiểm thử độ ổn định của Webhook SePay.
                        </p>
                        
                        <form action="{{ route('sandbox.payCustomSimulate') }}" method="POST">
                            @csrf
                            <!-- Custom Content -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Nội dung chuyển khoản</label>
                                <input type="text" name="content" class="form-control form-control-sm rounded-3 font-monospace" placeholder="Ví dụ: ECF000014" required>
                                <div class="form-text text-muted" style="font-size: 11px;">
                                    Ghi đúng cú pháp để khớp đơn hàng (ví dụ: <code>ECF000001</code>). Ghi sai để test phát hiện lỗi.
                                </div>
                            </div>
                            
                            <!-- Custom Amount -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-dark">Số tiền nhận được (VND)</label>
                                <input type="number" name="amount" class="form-control form-control-sm rounded-3 font-monospace" placeholder="Ví dụ: 150000" required>
                                <div class="form-text text-muted" style="font-size: 11px;">
                                    Chuyển sai số tiền đơn hàng sẽ kích hoạt phản hồi cảnh báo số tiền chênh lệch.
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2.5 rounded-3 d-inline-flex justify-content-center align-items-center gap-2" style="font-size: 13px;">
                                <i class="fa-solid fa-paper-plane"></i> Bắn Webhook chuyển khoản
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Webhook information helper -->
                <div class="console-card p-4 bg-white border-0">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                        <i class="fa-solid fa-circle-info text-info me-2"></i> THÔNG TIN ĐỐI SOÁT CỔNG
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0 lh-lg" style="font-size: 12px;">
                        <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>SePay Webhook URL:</strong> <code class="font-monospace text-dark">/api/payment/sepay-webhook</code></li>
                        <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>GHN Webhook URL:</strong> <code class="font-monospace text-dark">/api/shipping/ghn-webhook</code></li>
                        <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>Phương thức gửi:</strong> <code class="text-danger font-monospace">POST (JSON)</code></li>
                        <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>Cơ chế bảo vệ:</strong> Tự động bọc trong khối giao dịch và xử lý ngoại lệ an toàn, ghi nhận log đầy đủ.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
