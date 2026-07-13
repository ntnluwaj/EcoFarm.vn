@extends('frontend.layouts.master')

@section('title', 'Bảng Điều Khiển Giả Lập Tự Động Hóa Sandbox')

@section('content')
<div class="container py-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- Title Section -->
    <div class="text-center mb-5">
        <div class="d-inline-flex p-3 bg-success-subtle text-success rounded-circle mb-3 shadow-sm">
            <i class="fa-solid fa-flask fs-2"></i>
        </div>
        <h2 class="fw-bold text-dark">EcoFarm Sandbox Control Panel</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Chào mừng bạn đến với môi trường giả lập cục bộ. Trang này cho phép bạn đóng vai trò là ngân hàng gửi Webhook báo có thanh toán hoặc đóng vai trò đơn vị vận chuyển GHN cập nhật hành trình đơn hàng.
        </p>
    </div>

    <!-- Webhook Flow Diagram -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 bg-white p-4">
        <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
            <i class="fa-solid fa-network-wired text-success me-2"></i> SƠ ĐỒ LUỒNG TỰ ĐỘNG HÓA TÍCH HỢP
        </h5>
        <div class="row text-center g-4 small text-dark">
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="badge bg-success mb-2">Bước 1: Lên Đơn & Quét Mã</div>
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        Khách đặt đơn hàng VietQR. Mã QR hiển thị nội dung cố định: <code>EcoFarm DH[id]</code>.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="badge bg-primary mb-2">Bước 2: Chuyển khoản (SePay)</div>
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        Tiền vào tài khoản ngân hàng. SePay nhận biến động, bắn Webhook <code>POST /api/payment/sepay-webhook</code>.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="badge bg-dark mb-2">Bước 3: Giao vận (GHN Webhook)</div>
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        Hệ thống tự duyệt đóng gói, gửi ĐVVC. Shipper di chuyển bắn Webhook <code>POST /api/shipping/ghn-webhook</code>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4 fw-semibold small" role="alert" style="background-color: #e8f5e9; color: #2e7d32;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4 fw-semibold small" role="alert">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card border-0 shadow-lg rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-2"></i>Danh sách Đơn hàng cần kiểm thử</h5>
            <span class="badge bg-white text-success fw-bold">Hiện có: {{ $orders->count() }} đơn</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                <thead class="table-light text-secondary fw-semibold">
                    <tr>
                        <th class="ps-4 py-3">Mã đơn</th>
                        <th class="py-3">Người nhận & SĐT</th>
                        <th class="py-3">Tổng tiền</th>
                        <th class="py-3">Thanh toán</th>
                        <th class="py-3">Tình trạng đơn</th>
                        <th class="py-3">Mã vận đơn ĐVVC</th>
                        <th class="pe-4 py-3 text-end" style="width: 250px;">Bắn tín hiệu giả lập (Webhook)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <!-- Mã đơn -->
                            <td class="ps-4 py-3 fw-bold text-dark">
                                #DH{{ $order->id }}
                            </td>
                            <!-- Người nhận -->
                            <td class="py-3">
                                <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                                <div class="text-muted" style="font-size: 12px;">SĐT: {{ $order->customer_phone }}</div>
                            </td>
                            <!-- Tổng tiền -->
                            <td class="py-3 fw-bold text-dark">
                                {{ number_format($order->total_amount, 0, ',', '.') }}đ
                            </td>
                            <!-- Trạng thái thanh toán -->
                            <td class="py-3">
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-3 fw-bold" style="font-size: 11px;">
                                        <i class="fa-solid fa-credit-card me-1"></i>Đã thanh toán
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 rounded-3 fw-bold" style="font-size: 11px;">
                                        <i class="fa-regular fa-clock me-1"></i>Chưa thanh toán
                                    </span>
                                @endif
                                <div class="text-muted mt-1" style="font-size: 10px;">Phương thức: {{ $order->payment_method }}</div>
                            </td>
                            <!-- Trạng thái đơn -->
                            <td class="py-3">
                                @php
                                    $statusConfig = match($order->status) {
                                        'pending' => ['label' => 'Chờ duyệt', 'color' => 'bg-secondary-subtle text-secondary'],
                                        'processing' => ['label' => 'Đang chuẩn bị hàng', 'color' => 'bg-primary-subtle text-primary'],
                                        'shipping' => ['label' => 'Đang giao hàng', 'color' => 'bg-info-subtle text-info'],
                                        'completed' => ['label' => 'Đã giao thành công', 'color' => 'bg-success-subtle text-success'],
                                        'cancelled' => ['label' => 'Đã hủy', 'color' => 'bg-danger-subtle text-danger'],
                                        default => ['label' => $order->status, 'color' => 'bg-light text-dark']
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig['color'] }} px-2.5 py-1.5 rounded-3 fw-bold" style="font-size: 11px;">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>
                            <!-- Mã vận đơn -->
                            <td class="py-3 font-monospace text-xs">
                                {{ $order->payment_transaction_id ?: 'Chưa cấp mã' }}
                            </td>
                            <!-- Nút thao tác giả lập -->
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex flex-column gap-1.5 align-items-end">
                                    
                                    <!-- 1. Giả lập thanh toán ngân hàng -->
                                    @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                        <form action="{{ route('sandbox.paySimulate') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-success fw-bold d-inline-flex align-items-center gap-1 py-1 px-2.5 rounded-3 text-xs" style="font-size: 11.5px;">
                                                <i class="fa-solid fa-wallet"></i> Chuyển khoản VietQR (SePay)
                                            </button>
                                        </form>
                                    @endif

                                    <!-- 2. Giả lập shipper nhận hàng giao hàng -->
                                    @if($order->status === 'pending' || $order->status === 'processing')
                                        <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="status" value="shipping">
                                            <button type="submit" class="btn btn-sm btn-outline-primary fw-bold d-inline-flex align-items-center gap-1 py-1 px-2.5 rounded-3 text-xs" style="font-size: 11.5px;">
                                                <i class="fa-solid fa-truck-fast"></i> Shipper nhận hàng (GHN)
                                            </button>
                                        </form>
                                    @endif

                                    <!-- 3. Giả lập shipper giao hàng thành công -->
                                    @if($order->status === 'shipping')
                                        <form action="{{ route('sandbox.shipSimulate') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-outline-success fw-bold d-inline-flex align-items-center gap-1 py-1 px-2.5 rounded-3 text-xs" style="font-size: 11.5px;">
                                                <i class="fa-solid fa-circle-check"></i> Đã giao thành công (GHN)
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->status === 'cancelled')
                                        <span class="text-danger small" style="font-size: 11px;"><i class="fa-solid fa-ban"></i> Đơn đã hủy</span>
                                    @elseif($order->status === 'completed')
                                        <span class="text-success small" style="font-size: 11px;"><i class="fa-solid fa-circle-check"></i> Quy trình khép kín</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
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
@endsection
