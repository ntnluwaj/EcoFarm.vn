@extends('backend.layouts.crm_management')

@section('title', 'Deal đã chốt - CRM Ngọn Lửa EcoFarm')

@section('content')
<!-- Header Bar -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="crm-header-title">Deal đã chốt</h1>
        <p class="crm-header-subtitle">
            2 deal trong khoảng đang xem
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light border bg-white rounded-pill px-3 py-2 text-xs font-semibold shadow-xs">
            <i class="fa-solid fa-file-excel me-1 text-success"></i>Xuất Excel
        </button>
        <button class="btn btn-dark rounded-pill px-3.5 py-2 text-xs font-bold shadow-xs">
            <i class="fa-solid fa-plus me-1.5"></i>Ghi deal
        </button>
    </div>
</div>

<!-- Date Filter Bar -->
<form method="GET" action="{{ route('admin.crm.deals') }}" class="crm-card p-3 mb-4">
    <div class="row g-3 align-items-end" style="font-size: 13px;">
        <div class="col-md-3">
            <label class="form-label font-semibold text-secondary text-xs mb-1">Kỳ</label>
            <select name="period" class="form-select rounded-3 text-xs" style="font-size: 13px;">
                <option value="all">Tất cả</option>
                <option value="this_month">Tháng này</option>
                <option value="this_quarter">Quý này</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label font-semibold text-secondary text-xs mb-1">Từ ngày cọc</label>
            <input type="date" name="start_date" class="form-control rounded-3 text-xs" value="{{ $startDate->format('Y-m-d') }}" style="font-size: 13px;">
        </div>
        <div class="col-md-3">
            <label class="form-label font-semibold text-secondary text-xs mb-1">Đến ngày</label>
            <input type="date" name="end_date" class="form-control rounded-3 text-xs" value="{{ $endDate->format('Y-m-d') }}" style="font-size: 13px;">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-success w-100 fw-bold rounded-3 py-2 text-xs" style="background-color: #2e7d32; border: none; height: 38px;">
                <i class="fa-solid fa-filter me-1.5"></i>Lọc dữ liệu
            </button>
        </div>
    </div>
</form>

<!-- 🌟 4 METRIC STAT CARDS (Khớp 100% 4 ô chỉ số ảnh mẫu 3) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Số deal -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <span class="text-secondary font-medium d-block mb-2" style="font-size: 12.5px;">Số deal</span>
            <h2 class="fw-extrabold text-dark mb-0" style="font-size: 32px;">2</h2>
        </div>
    </div>

    <!-- Card 2: Tổng giá trị hợp đồng -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0" style="border-top: 3px solid #0284c7;">
            <span class="text-secondary font-medium d-block mb-2" style="font-size: 12.5px;">Tổng giá trị hợp đồng</span>
            <h2 class="fw-extrabold text-primary mb-0" style="font-size: 32px;">29,5 tỷ</h2>
        </div>
    </div>

    <!-- Card 3: Hoa hồng thực nhận -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0" style="border-top: 3px solid #10b981;">
            <span class="text-secondary font-medium d-block mb-2" style="font-size: 12.5px;">Hoa hồng thực nhận</span>
            <h2 class="fw-extrabold text-success mb-1" style="font-size: 32px;">705 tr</h2>
            <p class="text-muted mb-0" style="font-size: 11px;">Đã gồm thưởng nóng</p>
        </div>
    </div>

    <!-- Card 4: Giá trị trung bình/deal -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <span class="text-secondary font-medium d-block mb-2" style="font-size: 12.5px;">Giá trị trung bình/deal</span>
            <h2 class="fw-extrabold text-dark mb-0" style="font-size: 32px;">14,75 tỷ</h2>
        </div>
    </div>
</div>

<!-- 🌟 CLOSED DEALS DATA TABLE (Khớp 100% bảng ảnh mẫu 3) -->
<div class="crm-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 13px;">
            <thead class="bg-light text-secondary text-uppercase font-bold" style="font-size: 11px; letter-spacing: 0.5px; border-bottom: 1px solid #e5e7eb;">
                <tr>
                    <th class="ps-4 py-3">KHÁCH HÀNG</th>
                    <th class="py-3">CĂN / VẬT TƯ</th>
                    <th class="py-3">NGÀY CỌC</th>
                    <th class="py-3">GIÁ TRỊ HĐ</th>
                    <th class="py-3">HH %</th>
                    <th class="py-3">THỰC NHẬN</th>
                    <th class="py-3">TỆP</th>
                    <th class="py-3">THANH TOÁN</th>
                    <th class="pe-4 py-3 text-end">THAO TÁC</th>
                </tr>
            </thead>
            <tbody>
                <!-- Deal 1 -->
                <tr class="border-bottom">
                    <td class="ps-4">
                        <strong class="text-dark d-block">Nguyễn Hữu Phước</strong>
                        <span class="text-muted text-xs">0908445511</span>
                    </td>
                    <td>
                        <strong class="text-dark d-block">SH-B12</strong>
                        <span class="text-muted text-xs">Vinhomes Green Paradise Cần Giờ</span>
                    </td>
                    <td class="text-secondary">12/06/2026</td>
                    <td class="fw-bold text-dark">18 tỷ</td>
                    <td class="text-muted">2.4%</td>
                    <td class="fw-bold text-success">452 tr</td>
                    <td><span class="badge-status-green">B Dòng tiền</span></td>
                    <td class="text-secondary font-medium">Đã thanh toán đủ</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-link text-secondary p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-link text-danger p-1"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>

                <!-- Deal 2 -->
                <tr>
                    <td class="ps-4">
                        <strong class="text-dark d-block">Trương Khánh Vy</strong>
                        <span class="text-muted text-xs">0913668877</span>
                    </td>
                    <td>
                        <strong class="text-dark d-block">A2-15.08</strong>
                        <span class="text-muted text-xs">Vinhomes Green Paradise Cần Giờ</span>
                    </td>
                    <td class="text-secondary">09/05/2026</td>
                    <td class="fw-bold text-dark">11,5 tỷ</td>
                    <td class="text-muted">2.2%</td>
                    <td class="fw-bold text-success">253 tr</td>
                    <td><span class="badge-tag-blue">A Giữ tài sản</span></td>
                    <td class="text-secondary font-medium">Đã thanh toán một phần</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-link text-secondary p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-link text-danger p-1"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
