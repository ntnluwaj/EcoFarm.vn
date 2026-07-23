@extends('frontend.layouts.master')

@section('title', 'Tra Cứu Tiến Độ Đơn Hàng - EcoFarm')

@section('content')
<div class="container py-5" style="max-width: 550px; min-height: 75vh;">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-3 shadow" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-route fs-4"></i>
            </div>
            <h4 class="fw-bold text-success">Tra Cứu Đơn Hàng</h4>
            <p class="text-muted small">Nhập thông tin giao nhận để kiểm tra tiến trình vận chuyển</p>
        </div>

        @if(session('error') || isset($error))
            <div class="alert alert-danger border-0 rounded-3 text-center small mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') ?? $error }}
            </div>
        @endif

        <form action="{{ route('orders.track') }}" method="GET">
            <div class="mb-3">
                <label for="phone" class="form-label text-secondary small fw-bold">Số điện thoại giao nhận (Bắt buộc)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-phone"></i></span>
                    <input type="tel" name="phone" id="phone" class="form-control bg-light border-start-0 focus-ring" placeholder="Nhập số điện thoại đặt hàng..." required value="{{ request('phone', $phone ?? '') }}">
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="order_id" class="form-label text-secondary small fw-bold mb-0">Mã số đơn hàng (Nếu có)</label>
                    <span class="text-muted small" style="font-size: 11px;">* Để trống nếu quên mã đơn</span>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-hashtag"></i></span>
                    <input type="number" name="order_id" id="order_id" class="form-control bg-light border-start-0 focus-ring" placeholder="Nhập mã số đơn (Ví dụ: 15)..." value="{{ request('order_id') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #2e7d32; border: none; font-size: 15px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm đơn hàng
            </button>
        </form>

        <!-- Hiển thị danh sách đơn hàng tìm thấy khi quên mã đơn -->
        @if(isset($foundOrders) && count($foundOrders) > 0)
            <div class="mt-4 border-t pt-4">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-list-check text-success me-2"></i>Đơn hàng liên kết với số điện thoại:
                </h6>
                <div class="list-group rounded-3 shadow-xs">
                    @foreach($foundOrders as $o)
                        <a href="{{ route('orders.track', ['order_id' => $o->id, 'phone' => $o->customer_phone]) }}" class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center hover-light">
                            <div>
                                <span class="fw-bold text-success">Đơn hàng #{{ $o->id }}</span>
                                <div class="text-muted mt-1" style="font-size: 11.5px;">
                                    <i class="fa-solid fa-calendar-days me-1"></i>{{ $o->created_at->format('H:i d/m/Y') }}
                                    <span class="mx-1">|</span>
                                    <strong>{{ number_format($o->total_amount, 0, ',', '.') }}đ</strong>
                                </div>
                            </div>
                            <span class="badge rounded-2 text-uppercase px-2 py-1.5 text-2xs
                                @if($o->status === 'pending') bg-warning text-dark
                                @elseif($o->status === 'processing') bg-info text-dark
                                @elseif($o->status === 'shipping') bg-primary text-white
                                @elseif($o->status === 'completed') bg-success text-white
                                @else bg-danger text-white @endif" style="font-size: 10px;">
                                @switch($o->status)
                                    @case('pending') Chờ duyệt @break
                                    @case('processing') Đang gói @break
                                    @case('shipping') Đang giao @break
                                    @case('completed') Hoàn tất @break
                                    @case('cancelled') Đã hủy @break
                                    @default {{ $o->status }}
                                @endswitch
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .focus-ring:focus {
        border-color: #a3cfbb !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
    }
    .hover-light:hover {
        background-color: #f8f9fa !important;
    }
    .text-2xs {
        font-size: 11px;
    }
</style>
@endsection
