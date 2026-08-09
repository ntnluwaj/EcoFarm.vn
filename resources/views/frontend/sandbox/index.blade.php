@extends('frontend.layouts.master')

@section('title', 'Bảng Điều Khiển Giả Lập Sandbox')

@section('content')
<div class="container py-5">
    
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom gap-3">
        <div>
            <span class="badge badge-status-green mb-2">
                <i class="fa-solid fa-code-branch me-1"></i> DEVELOPER MODE & TESTBED
            </span>
            <h3 class="fw-bold text-dark mb-1">EcoFarm Sandbox Control Panel</h3>
            <p class="text-secondary small mb-0">Cổng kiểm thử giả lập quy trình VietQR SePay, shipper lấy hàng và webhook vận chuyển GHN thời gian thực.</p>
        </div>
        <div>
            <span class="badge badge-tag-blue">
                <span class="status-dot-pulse dot-blue"></span>Tác nghiệp tự động
            </span>
        </div>
    </div>

    <!-- Alert messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
            <i class="fa-solid fa-circle-check fs-4 me-3"></i>
            <div>
                <strong class="d-block">Thành công!</strong>
                <span class="small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert" style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3;">
            <i class="fa-solid fa-circle-xmark fs-4 me-3"></i>
            <div>
                <strong class="d-block">Lỗi thao tác!</strong>
                <span class="small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Test orders table -->
        <div class="col-lg-8">
            <div class="crm-table-card-wrapper">
                <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-database text-success me-2"></i>Đơn hàng kiểm thử mới nhất</h6>
                    <span class="badge badge-tag-gray">Hiện có: {{ $orders->count() }} đơn</span>
                </div>

                <div class="table-responsive">
                    <table class="table crm-data-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">MÃ ĐƠN</th>
                                <th>THÔNG TIN KHÁCH</th>
                                <th>MỨC UUTIÊN</th>
                                <th>THANH TOÁN</th>
                                <th>HÀNH TRÌNH</th>
                                <th class="pe-4 text-end" style="width: 180px;">THAO TÁC SỰ KIỆN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <!-- ID -->
                                    <td class="ps-4">
                                        <span class="crm-cell-title text-success">#DH{{ $order->id }}</span>
                                    </td>
                                    <!-- Info -->
                                    <td>
                                        <span class="crm-cell-title">{{ $order->customer_name }}</span>
                                        <span class="crm-cell-subtext"><i class="fa-solid fa-phone me-1 opacity-75"></i>{{ $order->customer_phone }}</span>
                                    </td>
                                    <!-- Priority Flame Badge -->
                                    <td>
                                        @if($order->status === 'shipping')
                                            <span class="badge-flame-orange"><i class="fa-solid fa-fire"></i>🔥 5 Cháy Rực</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge-flame-yellow"><i class="fa-solid fa-fire"></i>🔥 3 Bén Lửa</span>
                                        @elseif($order->status === 'pending')
                                            <span class="badge-flame-red"><i class="fa-solid fa-fire"></i>🔥 Khẩn cấp</span>
                                        @else
                                            <span class="badge-tag-gray">🔥 Tắt Ngấm</span>
                                        @endif
                                    </td>
                                    <!-- Payment Status -->
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            <span class="badge-status-green mb-1">
                                                <span class="status-dot-pulse dot-green"></span>Đã trả tiền
                                            </span>
                                        @else
                                            <span class="badge-flame-yellow mb-1">
                                                <span class="status-dot-pulse dot-yellow"></span>Chưa trả tiền
                                            </span>
                                        @endif
                                        <div class="text-muted text-xs font-monospace">{{ strtoupper($order->payment_method) }}</div>
                                    </td>
                                    <!-- Progress -->
                                    <td>
                                        @php
                                            $statusLabel = match($order->status) {
                                                'pending' => 'Chờ duyệt',
                                                'processing' => 'Đang đóng gói',
                                                'shipping' => 'Đang giao hàng',
                                                'completed' => 'Hoàn tất',
                                                'cancelled' => 'Đã hủy',
                                                default => $order->status
                                            };
                                            $badgeClass = match($order->status) {
                                                'pending' => 'badge-flame-red',
                                                'processing' => 'badge-flame-yellow',
                                                'shipping' => 'badge-flame-orange',
                                                'completed' => 'badge-status-green',
                                                'cancelled' => 'badge-tag-gray',
                                                default => 'badge-tag-gray'
                                            };
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <!-- Actions -->
                                    <td class="pe-4 text-end">
                                        <div class="d-flex flex-column gap-1.5 align-items-end">
                                            @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                                <form action="{{ route('sandbox.paySimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill fw-bold text-xs py-1 px-3" style="width: 170px;">
                                                        <i class="fa-solid fa-wallet me-1"></i> Báo có VietQR (SePay)
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($order->status, ['pending', 'processing']))
                                                <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="status" value="shipping">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill fw-bold text-xs py-1 px-3" style="width: 170px;">
                                                        <i class="fa-solid fa-truck-fast me-1"></i> Shipper lấy hàng
                                                    </button>
                                                </form>
                                            @endif

                                            @if($order->status === 'shipping')
                                                <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill fw-bold text-xs py-1 px-3" style="width: 170px;">
                                                        <i class="fa-solid fa-box-open me-1"></i> Giao thành công
                                                    </button>
                                                </form>
                                            @endif

                                            @if($order->status === 'cancelled')
                                                <span class="text-danger text-xs"><i class="fa-solid fa-ban me-1"></i>Đã hủy đơn</span>
                                            @elseif($order->status === 'completed' && $order->payment_status === 'paid')
                                                <span class="text-success text-xs"><i class="fa-solid fa-circle-check me-1"></i>Đã đối soát xong</span>
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

        <!-- Right Column: Controls -->
        <div class="col-lg-4">
            <div class="crm-table-card-wrapper p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-terminal text-success me-2"></i>Giả lập VietQR thủ công (SePay)</h6>
                <form action="{{ route('sandbox.payCustomSimulate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-dark">Nội dung chuyển khoản</label>
                        <input type="text" name="content" class="crm-table-search-input font-monospace" placeholder="Ví dụ: ECF000001" required style="padding-left: 14px;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-xs fw-bold text-dark">Số tiền nhận được (VND)</label>
                        <input type="number" name="amount" class="crm-table-search-input font-monospace" placeholder="Ví dụ: 150000" required style="padding-left: 14px;">
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-pill text-xs shadow-xs" style="background-color: #2e7d32; border: none;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Bắn Webhook chuyển khoản
                    </button>
                </form>
            </div>

            <div class="crm-table-card-wrapper p-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-circle-info text-info me-2"></i>Thông tin Endpoint Webhook</h6>
                <ul class="list-unstyled text-xs text-muted mb-0 lh-lg">
                    <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>SePay Webhook:</strong> <code class="font-monospace text-dark">/api/payment/sepay-webhook</code></li>
                    <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>GHN Webhook:</strong> <code class="font-monospace text-dark">/api/shipping/ghn-webhook</code></li>
                    <li><i class="fa-solid fa-caret-right me-1 text-success"></i> <strong>Phương thức:</strong> <code class="text-danger font-monospace">POST (JSON)</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
