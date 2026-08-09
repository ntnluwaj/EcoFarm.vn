@extends('frontend.layouts.master')

@section('title', 'Cổng Giả Lập Webhook & Testbed Tự Động Hóa EcoFarm')

@section('content')
<style>
    .sandbox-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #0f172a;
        color: #f8fafc;
        min-height: 100vh;
    }
    .sandbox-card {
        background: rgba(30, 41, 59, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .sandbox-card:hover {
        border-color: rgba(74, 222, 128, 0.3);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    }
    .terminal-box {
        background-color: #020617;
        border: 1px solid #1e293b;
        border-radius: 12px;
        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
        font-size: 12.5px;
        color: #38bdf8;
    }
    .glow-badge-green {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.3);
    }
    .glow-badge-blue {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .glow-badge-orange {
        background: rgba(251, 146, 60, 0.15);
        color: #fb923c;
        border: 1px solid rgba(251, 146, 60, 0.3);
    }
    .btn-simulator {
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.3px;
        transition: all 0.25s ease;
        padding: 8px 14px;
    }
    .btn-simulator:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .table-dark-custom {
        --bs-table-bg: transparent;
        --bs-table-color: #cbd5e1;
        --bs-table-border-color: rgba(255, 255, 255, 0.08);
    }
    .table-dark-custom th {
        color: #94a3b8;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stepper-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #334155;
    }
    .stepper-dot.active {
        background-color: #4ade80;
        box-shadow: 0 0 10px #4ade80;
    }
    .stepper-line {
        height: 2px;
        background-color: #334155;
        flex-grow: 1;
    }
    .stepper-line.active {
        background-color: #4ade80;
    }
</style>

<div class="sandbox-page py-5">
    <div class="container-fluid px-md-5">
        
        <!-- 🌟 DEVELOPER DASHBOARD HEADER -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5 p-4 rounded-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(255,255,255,0.1);">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge glow-badge-green px-3 py-1.5 rounded-pill text-xs font-monospace">
                        <i class="fa-solid fa-server me-1"></i>ECOFARM DEV ENVIRONMENT
                    </span>
                    <span class="badge glow-badge-blue px-3 py-1.5 rounded-pill text-xs font-monospace">
                        <i class="fa-solid fa-circle-dot me-1 text-success"></i>WEBHOOK ENDPOINTS READY
                    </span>
                </div>
                <h2 class="fw-extrabold text-white mb-1 d-flex align-items-center gap-2" style="font-weight: 800;">
                    <i class="fa-solid fa-microchip text-success"></i> Bảng Điều Khiển Giả Lập Webhook & Testbed API
                </h2>
                <p class="text-slate-400 small mb-0" style="color: #94a3b8;">
                    Mô phỏng các cuộc gọi tín hiệu Webhook tự động thời gian thực từ Cổng Thanh Toán VietQR (SePay) và Đơn Vị Vận Chuyển (GHN Express).
                </p>
            </div>

            <!-- Fast Status Monitor Cards -->
            <div class="d-flex gap-3">
                <div class="p-3 rounded-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); min-width: 150px;">
                    <span class="d-block text-xs text-slate-400 mb-1" style="color: #94a3b8;">SePay Webhook</span>
                    <span class="badge bg-success text-white fw-bold text-xs"><i class="fa-solid fa-check me-1"></i>200 OK Active</span>
                </div>
                <div class="p-3 rounded-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); min-width: 150px;">
                    <span class="d-block text-xs text-slate-400 mb-1" style="color: #94a3b8;">GHN Webhook</span>
                    <span class="badge bg-info text-dark fw-bold text-xs"><i class="fa-solid fa-truck-fast me-1"></i>Listening</span>
                </div>
            </div>
        </div>

        <!-- 🌟 SYSTEM INTEGRATION ARCHITECTURE FLOW -->
        <div class="sandbox-card p-4 mb-5">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-diagram-project text-success"></i> QUY TRÌNH KÍCH HOẠT SỰ KIỆN WEBHOOK NỘI BỘ (EVENT-DRIVEN ARCHITECTURE)
            </h5>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-3.5 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2.5 rounded-3 bg-success bg-opacity-20 text-success fs-4">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">1. Tạo Đơn VietQR/COD</h6>
                                <span class="text-xs text-slate-400" style="color: #94a3b8;">Khởi tạo mã đơn ECF...</span>
                            </div>
                        </div>
                        <p class="text-slate-300 small mb-0" style="font-size: 12.5px; color: #cbd5e1;">
                            Đơn hàng được ghi nhận vào CSDL MySQL ở trạng thái <code>pending</code>. Hệ thống cấp mã quét QR động chứa cú pháp <code>ECF[Order_ID]</code>.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="flow-card p-3.5 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2.5 rounded-3 bg-info bg-opacity-20 text-info fs-4">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">2. Báo Có Ngân Hàng SePay</h6>
                                <span class="text-xs text-slate-400" style="color: #94a3b8;">POST /api/payment/sepay-webhook</span>
                            </div>
                        </div>
                        <p class="text-slate-300 small mb-0" style="font-size: 12.5px; color: #cbd5e1;">
                            Tín hiệu Webhook tự động quét cú pháp <code>ECF...</code>, xác minh số tiền khớp và cập nhật <code>payment_status = paid</code> mà không cần làm mới trang.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3.5 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2.5 rounded-3 bg-warning bg-opacity-20 text-warning fs-4">
                                <i class="fa-solid fa-truck-ramp-box"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">3. Vận Chuyển GHN Webhook</h6>
                                <span class="text-xs text-slate-400" style="color: #94a3b8;">POST /api/shipping/ghn-webhook</span>
                            </div>
                        </div>
                        <p class="text-slate-300 small mb-0" style="font-size: 12.5px; color: #cbd5e1;">
                            Shipper cập nhật trạng thái lấy hàng hoặc giao hàng thành công. Webhook đẩy dữ liệu trực tiếp cập nhật <code>status = shipping / completed</code>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 NOTIFICATION TOAST MESSAGES -->
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-lg mb-4 p-3.5 d-flex align-items-center text-white" role="alert" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%); border-left: 5px solid #4ade80 !important;">
                <i class="fa-solid fa-circle-check fs-3 me-3 text-warning"></i>
                <div>
                    <strong class="d-block fs-6">KÍCH HOẠT WEBHOOK THÀNH CÔNG!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4 shadow-lg mb-4 p-3.5 d-flex align-items-center text-white" role="alert" style="background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%); border-left: 5px solid #f87171 !important;">
                <i class="fa-solid fa-triangle-exclamation fs-3 me-3"></i>
                <div>
                    <strong class="d-block fs-6">KÍCH HOẠT WEBHOOK THẤT BẠI!</strong>
                    <span class="small">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- 🌟 LEFT COLUMN: ORDER TESTBED CONTROL TABLE -->
            <div class="col-lg-8">
                <div class="sandbox-card overflow-hidden">
                    <div class="p-4 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(15, 23, 42, 0.6);">
                        <h5 class="fw-extrabold text-white mb-0 d-flex align-items-center gap-2" style="font-weight: 800; font-size: 16px;">
                            <i class="fa-solid fa-list-check text-success"></i> Danh Sách Đơn Hàng Kiểm Thử Thực Tế
                        </h5>
                        <span class="badge glow-badge-green px-3 py-1 rounded-pill text-xs fw-bold">
                            Tải 15 đơn hàng gần nhất
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3">Mã đơn & Người nhận</th>
                                    <th class="py-3">Giá trị đơn</th>
                                    <th class="py-3">Thanh toán</th>
                                    <th class="py-3">Tiến độ vận đơn</th>
                                    <th class="pe-4 py-3 text-end" style="width: 220px;">Giả lập Webhook</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <!-- Order ID & Customer -->
                                        <td class="ps-4 py-3.5">
                                            <div class="d-flex align-items-center gap-2.5">
                                                <span class="badge bg-slate-800 text-white border border-secondary border-opacity-25 px-2.5 py-1 font-monospace text-xs" style="background-color: #1e293b;">
                                                    #ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </div>
                                            <div class="fw-bold text-white mt-1 text-sm">{{ $order->customer_name }}</div>
                                            <div class="text-slate-400 text-xs" style="color: #94a3b8;"><i class="fa-solid fa-phone me-1"></i>{{ $order->customer_phone }}</div>
                                        </td>

                                        <!-- Amount -->
                                        <td class="py-3.5">
                                            <div class="fw-bold text-white fs-6">{{ number_format($order->total_amount, 0, ',', '.') }}đ</div>
                                            <span class="text-slate-400 text-xs" style="color: #94a3b8;">{{ $order->items ? $order->items->count() : 0 }} món vật tư</span>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="py-3.5">
                                            @if($order->payment_status === 'paid')
                                                <span class="badge glow-badge-green px-2.5 py-1 rounded-pill text-xs fw-bold d-inline-flex align-items-center gap-1 mb-1">
                                                    <i class="fa-solid fa-circle-check"></i> Đã thanh toán
                                                </span>
                                            @else
                                                <span class="badge glow-badge-orange px-2.5 py-1 rounded-pill text-xs fw-bold d-inline-flex align-items-center gap-1 mb-1">
                                                    <i class="fa-solid fa-clock"></i> Chưa trả tiền
                                                </span>
                                            @endif
                                            <div class="text-slate-400 font-monospace text-xs text-uppercase" style="color: #94a3b8;">{{ $order->payment_method }}</div>
                                        </td>

                                        <!-- Order Status Pipeline -->
                                        <td class="py-3.5">
                                            <div class="mb-1.5">
                                                @php
                                                    $statusBadge = match($order->status) {
                                                        'pending' => '<span class="badge glow-badge-orange text-xs">⏳ Chờ duyệt</span>',
                                                        'processing' => '<span class="badge glow-badge-blue text-xs">📦 Đang đóng gói</span>',
                                                        'shipping' => '<span class="badge glow-badge-blue text-xs">🚚 Đang vận chuyển</span>',
                                                        'completed' => '<span class="badge glow-badge-green text-xs">🎉 Hoàn tất</span>',
                                                        'cancelled' => '<span class="badge bg-danger bg-opacity-20 text-danger border border-danger border-opacity-25 text-xs">❌ Đã hủy</span>',
                                                        default => $order->status
                                                    };
                                                @endphp
                                                {!! $statusBadge !!}
                                            </div>

                                            <!-- Stepper Visualizer -->
                                            <div class="d-flex align-items-center gap-1" style="width: 110px;">
                                                <div class="stepper-dot active" title="Tạo đơn"></div>
                                                <div class="stepper-line {{ $order->payment_status === 'paid' || $order->status !== 'pending' ? 'active' : '' }}"></div>
                                                <div class="stepper-dot {{ $order->payment_status === 'paid' || $order->status !== 'pending' ? 'active' : '' }}" title="Thanh toán"></div>
                                                <div class="stepper-line {{ in_array($order->status, ['shipping', 'completed']) ? 'active' : '' }}"></div>
                                                <div class="stepper-dot {{ in_array($order->status, ['shipping', 'completed']) ? 'active' : '' }}" title="Vận chuyển"></div>
                                                <div class="stepper-line {{ $order->status === 'completed' ? 'active' : '' }}"></div>
                                                <div class="stepper-dot {{ $order->status === 'completed' ? 'active' : '' }}" title="Giao thành công"></div>
                                            </div>
                                        </td>

                                        <!-- Webhook Trigger Buttons -->
                                        <td class="pe-4 py-3.5 text-end">
                                            <div class="d-flex flex-column gap-2 align-items-end">
                                                
                                                <!-- SePay Webhook Trigger -->
                                                @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                                    <form action="{{ route('sandbox.paySimulate') }}" method="POST" class="m-0 w-100">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <button type="submit" class="btn btn-success btn-simulator w-100 text-nowrap" style="background-color: #166534; border: 1px solid #22c55e;">
                                                            <i class="fa-solid fa-qrcode me-1"></i> Bắn Webhook VietQR (SePay)
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- GHN Webhook Trigger: Pick Items -->
                                                @if(in_array($order->status, ['pending', 'processing']))
                                                    <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0 w-100">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="status" value="shipping">
                                                        <button type="submit" class="btn btn-primary btn-simulator w-100 text-nowrap" style="background-color: #1e40af; border: 1px solid #3b82f6;">
                                                            <i class="fa-solid fa-truck-fast me-1"></i> Bắn Webhook Shipper Lấy Hàng
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- GHN Webhook Trigger: Delivered -->
                                                @if($order->status === 'shipping')
                                                    <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0 w-100">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn btn-success btn-simulator w-100 text-nowrap" style="background-color: #15803d; border: 1px solid #4ade80;">
                                                            <i class="fa-solid fa-box-check me-1"></i> Bắn Webhook Giao Thành Công
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($order->status === 'cancelled')
                                                    <span class="text-danger text-xs"><i class="fa-solid fa-ban me-1"></i>Đơn hàng bị hủy</span>
                                                @elseif($order->status === 'completed' && $order->payment_status === 'paid')
                                                    <span class="text-success text-xs fw-bold"><i class="fa-solid fa-circle-check me-1"></i>Đã xong trọn vẹn</span>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-slate-400" style="color: #94a3b8;">
                                            <i class="fa-solid fa-folder-open fs-2 d-block mb-2 opacity-50"></i>
                                            Chưa có đơn hàng nào trong CSDL để thử nghiệm Webhook.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 🌟 RIGHT COLUMN: CUSTOM WEBHOOK PAYLOAD INJECTOR & TERMINAL LOGS -->
            <div class="col-lg-4">
                
                <!-- CUSTOM PAYLOAD INJECTOR FORM -->
                <div class="sandbox-card overflow-hidden mb-4">
                    <div class="p-3.5 border-bottom border-secondary border-opacity-25" style="background: rgba(15, 23, 42, 0.6);">
                        <h5 class="fw-bold text-white mb-0 text-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-terminal text-success"></i> Giả Lập Tùy Chỉnh Cú Pháp VietQR
                        </h5>
                    </div>
                    
                    <div class="p-4">
                        <p class="text-slate-400 small mb-3" style="font-size: 12px; color: #94a3b8;">
                            Nhập tùy chọn Mã ghi chú giao dịch và Số tiền để kiểm thử các trường hợp ngoại lệ (chuyển thiếu tiền, thừa tiền, hoặc ghi sai mã đơn).
                        </p>

                        <form action="{{ route('sandbox.payCustomSimulate') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-slate-300 text-xs fw-bold" style="color: #cbd5e1;">Cú Pháp Ghi Chú Chuyển Khoản</label>
                                <input type="text" name="content" class="form-control form-control-sm rounded-3 font-monospace bg-slate-900 border-secondary border-opacity-50 text-success p-2.5" placeholder="Ví dụ: ECF000067 thanh toan" required style="background: #020617; color: #4ade80 !important; font-size: 13px;">
                                <div class="form-text text-slate-400 text-xs mt-1" style="color: #94a3b8; font-size: 11px;">
                                    Gõ đúng cú pháp <code>ECF[Order_ID]</code> để khớp tự động.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-slate-300 text-xs fw-bold" style="color: #cbd5e1;">Số Tiền Ngân Hàng Báo Có (VND)</label>
                                <input type="number" name="amount" class="form-control form-control-sm rounded-3 font-monospace bg-slate-900 border-secondary border-opacity-50 text-warning p-2.5" placeholder="Ví dụ: 350000" required style="background: #020617; color: #facc15 !important; font-size: 13px;">
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm text-sm" style="background-color: #166534; border: 1px solid #22c55e;">
                                <i class="fa-solid fa-paper-plane"></i> Gửi Tín Hiệu Webhook Ngân Hàng
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ENDPOINT LOG INSPECTOR -->
                <div class="sandbox-card p-4">
                    <h6 class="fw-bold text-white mb-3 d-flex align-items-center gap-2" style="font-size: 14px;">
                        <i class="fa-solid fa-network-wired text-info"></i> THÔNG TIN ENDPOINT CHÍNH THỨC
                    </h6>

                    <div class="terminal-box p-3 mb-3">
                        <div class="text-slate-400 mb-1 text-xs" style="color: #94a3b8;">POST /api/payment/sepay-webhook</div>
                        <div class="text-success font-monospace" style="font-size: 11px;">
                            Header: Authorization / Content-Type: application/json<br>
                            Status: <span class="text-warning">200 OK Response</span>
                        </div>
                    </div>

                    <div class="terminal-box p-3">
                        <div class="text-slate-400 mb-1 text-xs" style="color: #94a3b8;">POST /api/shipping/ghn-webhook</div>
                        <div class="text-info font-monospace" style="font-size: 11px;">
                            Header: Content-Type: application/json<br>
                            Payload: { "order_id": 67, "status": "shipping" }
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
