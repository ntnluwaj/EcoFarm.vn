@extends('frontend.layouts.master')

@section('title', 'Tiến Độ Đơn Hàng #' . $order->id)

@section('content')
<div class="container py-4" style="max-width: 850px; min-height: 80vh;">
    
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold text-success mb-1">
                    <i class="fa-solid fa-route me-2"></i>Chi tiết tiến trình vận đơn nông nghiệp
                </h4>
                <p class="text-muted small mb-0">
                    Mã đơn hệ thống: <span class="text-dark fw-bold">#{{ $order->id }}</span> | Ngày chốt đơn: {{ \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y') }}
                </p>
            </div>
            <span class="badge p-2.5 px-3 text-uppercase font-weight-bold rounded-3 shadow-sm text-xs
                @if($order->status === 'pending') bg-warning text-dark
                @elseif($order->status === 'processing') bg-info text-dark
                @elseif($order->status === 'shipping') bg-primary text-white
                @elseif($order->status === 'completed') bg-success text-white
                @else bg-danger text-white @endif">
                @switch($order->status)
                    @case('pending') Chờ duyệt @break
                    @case('processing') Đang đóng gói @break
                    @case('shipping') Đang giao hàng @break
                    @case('completed') Hoàn tất @break
                    @case('cancelled') Đã hủy đơn @break
                @endswitch
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h5 class="fw-bold text-dark mb-4">
            <i class="fa-solid fa-timeline text-success me-2"></i>Trục thời gian chuyển dịch trạng thái bãi kho
        </h5>
        
        <div class="position-relative ps-4 border-start border-2 border-success-subtle ms-2 timeline-axis">
            @foreach($logs as $index => $log)
                <div class="mb-4 position-relative timeline-node">
                    <span class="position-absolute bg-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                          style="left: -34px !important; width: 20px; height: 20px; top: 2px; border: 3px solid #fff; box-shadow: 0 0 0 2px #2e7d32;">
                        <span class="bg-white rounded-circle" style="width: 6px; height: 6px;"></span>
                    </span>
                    
                    <div class="ms-2 p-3 bg-light rounded-3 transition-all timeline-item-box">
                        <strong class="text-dark d-block" style="font-size: 14px;">
                            @switch($log->status)
                                @case('pending') <span class="text-warning fw-bold"><i class="fa-solid fa-clock me-1"></i> Khởi tạo đơn hàng - Chờ tổng đài viên xác nhận</span> @break
                                @case('processing') <span class="text-info fw-bold"><i class="fa-solid fa-box me-1"></i> Nhân viên kho Cần Thơ đang đóng gói / Bốc xếp vật tư</span> @break
                                @case('shipping') <span class="text-primary fw-bold"><i class="fa-solid fa-truck me-1"></i> Đơn hàng đã bàn giao xe tải vận chuyển, đang trên đường giao nhận</span> @break
                                @case('completed') <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> Hoàn tất vận đơn - Bà con đã ký nhận & thanh toán đủ</span> @break
                                @case('cancelled') <span class="text-danger fw-bold"><i class="fa-solid fa-ban me-1"></i> Đơn hàng bị hủy hệ thống</span> @break
                            @endswitch
                        </strong>
                        <span class="text-muted d-block mt-2" style="font-size: 11px;">
                            <i class="fa-solid fa-calendar-day me-1"></i> Thời gian ghi vết thực tế: {{ \Carbon\Carbon::parse($log->log_time)->format('H:i:s d/m/Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 block-hover">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-tag text-success me-2"></i>Thông tin người nhận</h6>
                <div class="d-flex flex-column gap-2" style="font-size: 13.5px;">
                    <p class="text-secondary mb-0">Họ tên khách hàng: <strong class="text-dark">{{ $order->customer_name }}</strong></p>
                    <p class="text-secondary mb-0">Số điện thoại liên hệ: <strong class="text-dark">{{ $order->customer_phone }}</strong></p>
                    <p class="text-secondary mb-0">Địa chỉ bàn giao: <span class="text-dark fw-medium">{{ $order->shipping_address }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 block-hover">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-wallet text-success me-2"></i>Thông tin dòng tiền toán học</h6>
                <div class="d-flex flex-column gap-2" style="font-size: 13.5px;">
                    <p class="text-secondary mb-0">Giải pháp thanh toán: <strong class="text-dark">{{ $order->payment_method }}</strong></p>
                    <p class="text-secondary mb-0">Tình trạng tài chính: 
                        <span class="badge rounded-2 px-2 py-1 fw-bold {{ $order->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}" style="font-size: 11px;">
                            {{ $order->payment_status === 'paid' ? 'Đã thanh toán thành công' : 'Chưa thanh toán / Giao COD' }}
                        </span>
                    </p>
                    <hr class="my-1 opacity-25">
                    <p class="text-secondary mb-0 d-flex align-items-center justify-content-between">
                        <span>Tổng giá trị hóa đơn:</span> 
                        <strong class="text-danger fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} VND</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* CSS Tối ưu đồ họa trục đứng và hiệu ứng Hover */
    .border-success-subtle { border-color: #a3cfbb !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .text-xs { font-size: 12px !important; }
    .transition-all { transition: all 0.2s ease-in-out; }
    
    .timeline-item-box:hover {
        background-color: #f1f8f5 !important;
        transform: translateX(4px);
    }
    .block-hover:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.04) !important;
    }
    .timeline-node:last-child {
        margin-bottom: 0 !important;
    }
</style>
@endsection