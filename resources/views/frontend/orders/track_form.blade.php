@extends('frontend.layouts.master')

@section('title', 'Tra Cứu Tiến Độ Đơn Hàng - EcoFarm')

@section('content')
<div class="container py-5" style="max-width: 500px; min-height: 75vh;">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-3 shadow" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-route fs-4"></i>
            </div>
            <h4 class="fw-bold text-success">Tra Cứu Đơn Hàng</h4>
            <p class="text-muted small">Dành cho cả khách mua lẻ vãng lai không cần đăng nhập tài khoản</p>
        </div>

        @if(session('error') || isset($error))
            <div class="alert alert-danger border-0 rounded-3 text-center small mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') ?? $error }}
            </div>
        @endif

        <form action="{{ route('orders.track') }}" method="GET">
            <div class="mb-3">
                <label for="order_id" class="form-label text-secondary small fw-bold">Mã số đơn hàng (Ví dụ: 15)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-hashtag"></i></span>
                    <input type="number" name="order_id" id="order_id" class="form-control bg-light border-start-0 focus-ring" placeholder="Nhập mã số đơn hàng..." required value="{{ request('order_id') }}">
                </div>
            </div>

            <div class="mb-4">
                <label for="phone" class="form-label text-secondary small fw-bold">Số điện thoại giao nhận (Ví dụ: 0987654321)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-phone"></i></span>
                    <input type="tel" name="phone" id="phone" class="form-control bg-light border-start-0 focus-ring" placeholder="Nhập số điện thoại đặt hàng..." required value="{{ request('phone') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #2e7d32; border: none; font-size: 15px;">
                <i class="fa-solid fa-magnifying-glass"></i> Kiểm tra tiến độ
            </button>
        </form>
    </div>
</div>

<style>
    .focus-ring:focus {
        border-color: #a3cfbb !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
    }
</style>
@endsection
