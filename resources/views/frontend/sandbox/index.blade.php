@extends('frontend.layouts.master')

@section('title', 'Nhật ký tác nghiệp & Giả lập Sandbox')

@section('content')
<div class="crm-table-container container my-5">
    
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom gap-3">
        <div>
            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2 shadow-xs" style="font-size: 11px;">
                <i class="fa-solid fa-code-branch me-1"></i> TESTBED & CRM CONTROL PANEL
            </span>
            <h3 class="fw-bold text-dark mb-1">Nhật Ký Tương Tác & Giả Lập Tác Nghiệp</h3>
            <p class="text-secondary small mb-0">Cổng kiểm thử giả lập quy trình VietQR SePay, shipper lấy hàng và webhook vận chuyển GHN thời gian thực.</p>
        </div>
        <div>
            <span class="status-dot-pulse dot-green me-1.5"></span>
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill font-semibold text-xs shadow-xs">
                39 lượt chạm hệ thống &bull; 31 phản hồi thật
            </span>
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
        <!-- Left Column: Test orders CRM table list -->
        <div class="col-lg-8">
            <div class="crm-filter-panel mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-list-check text-success me-2"></i>Nhật ký tác nghiệp & Đơn hàng kiểm thử</h6>
                    <span class="crm-badge badge-pill-green">Hiện có: {{ $orders->count() }} đơn</span>
                </div>

                <div class="table-responsive">
                    <table class="crm-table">
                        <thead>
                            <tr>
                                <th class="ps-3">Mã đơn / Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Thanh toán</th>
                                <th>Hành trình đơn</th>
                                <th class="pe-3 text-end" style="width: 190px;">Thao tác tác nghiệp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <!-- ID & Customer -->
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center me-2">
                                            @if($order->status === 'completed')
                                                <span class="status-dot-pulse dot-green me-2"></span>
                                            @elseif($order->status === 'shipping')
                                                <span class="status-dot-pulse dot-blue me-2"></span>
                                            @elseif($order->status === 'processing')
                                                <span class="status-dot-pulse dot-orange me-2"></span>
                                            @else
                                                <span class="status-dot-pulse dot-red me-2"></span>
                                            @endif
                                            <div>
                                                <span class="fw-bold text-dark text-xs d-block">#DH{{ $order->id }} &bull; {{ $order->customer_name }}</span>
                                                <span class="text-muted text-xs"><i class="fa-solid fa-phone me-1 opacity-75"></i>{{ $order->customer_phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Amount -->
                                    <td class="fw-bold text-success text-xs">
                                        {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                    </td>
                                    <!-- Payment Status -->
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            <span class="crm-badge badge-pill-green mb-1" style="font-size: 10.5px;">
                                                <i class="fa-solid fa-circle-check me-1"></i>Đã thanh toán
                                            </span>
                                        @else
                                            <span class="crm-badge badge-flame-yellow mb-1" style="font-size: 10.5px;">
                                                <i class="fa-regular fa-clock me-1"></i>Chưa thanh toán
                                            </span>
                                        @endif
                                        <div class="text-muted text-xs font-monospace" style="font-size: 10px;">{{ strtoupper($order->payment_method) }}</div>
                                    </td>
                                    <!-- Progress Stepper -->
                                    <td>
                                        @php
                                            $statusLabel = match($order->status) {
                                                'pending' => 'Chờ duyệt',
                                                'processing' => 'Đóng gói',
                                                'shipping' => 'Đang giao',
                                                'completed' => 'Hoàn tất',
                                                'cancelled' => 'Đã hủy',
                                                default => $order->status
                                            };
                                            $badgeClass = match($order->status) {
                                                'pending' => 'badge-flame-red',
                                                'processing' => 'badge-flame-yellow',
                                                'shipping' => 'badge-flame-orange',
                                                'completed' => 'badge-pill-green',
                                                'cancelled' => 'badge-tag-outline',
                                                default => 'badge-tag-outline'
                                            };
                                        @endphp
                                        <span class="crm-badge {{ $badgeClass }} mb-1">{{ $statusLabel }}</span>
                                        @if($order->payment_transaction_id)
                                            <div class="text-muted font-monospace text-xs" style="font-size: 10px; max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                Vận đơn: {{ $order->payment_transaction_id }}
                                            </div>
                                        @endif
                                    </td>
                                    <!-- Actions -->
                                    <td class="pe-3 text-end">
                                        <div class="d-flex flex-column gap-1.5 align-items-end">
                                            @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                                <form action="{{ route('sandbox.paySimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold rounded-pill text-xs px-2.5 py-1" style="font-size: 11px; width: 175px;">
                                                        <i class="fa-solid fa-wallet me-1"></i> Báo có VietQR (SePay)
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($order->status, ['pending', 'processing']))
                                                <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="status" value="shipping">
                                                    <button type="submit" class="btn btn-sm btn-primary fw-bold rounded-pill text-xs px-2.5 py-1" style="font-size: 11px; width: 175px;">
                                                        <i class="fa-solid fa-truck-fast me-1"></i> Shipper lấy hàng
                                                    </button>
                                                </form>
                                            @endif

                                            @if($order->status === 'shipping')
                                                <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold rounded-pill text-xs px-2.5 py-1" style="font-size: 11px; width: 175px;">
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
                                    <td colspan="5" class="text-center py-5 text-muted text-xs">
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

        <!-- Right Column: Webhook console & manual form -->
        <div class="col-lg-4">
            <div class="crm-filter-panel mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-terminal text-success me-2"></i>Giả lập VietQR thủ công (SePay)</h6>
                <p class="text-muted text-xs mb-3">
                    Mô phỏng khách hàng chuyển khoản khớp hoặc sai cú pháp để kiểm thử phản hồi tự động của hệ thống.
                </p>
                
                <form action="{{ route('sandbox.payCustomSimulate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-dark">Nội dung chuyển khoản</label>
                        <input type="text" name="content" class="crm-search-input font-monospace" placeholder="Ví dụ: ECF000001" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-xs fw-bold text-dark">Số tiền nhận được (VND)</label>
                        <input type="number" name="amount" class="crm-search-input font-monospace" placeholder="Ví dụ: 150000" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-pill text-xs shadow-xs" style="background-color: #2e7d32; border: none;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Bắn Webhook chuyển khoản
                    </button>
                </form>
            </div>

            <div class="crm-filter-panel">
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
