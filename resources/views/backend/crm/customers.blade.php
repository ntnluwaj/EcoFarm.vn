@extends('backend.layouts.crm_management')

@section('title', 'Danh sách khách hàng - CRM Ngọn Lửa EcoFarm')

@section('content')
<!-- Header Bar -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="crm-header-title">Khách hàng</h1>
        <p class="crm-header-subtitle">
            15 khách khớp bộ lọc &bull; kỳ vọng trang này 27,05 tỷ
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light border bg-white rounded-pill px-3 py-2 text-xs font-semibold shadow-xs">
            <i class="fa-solid fa-arrow-up-from-bracket me-1 text-secondary"></i>Nhập file
        </button>
        <button class="btn btn-light border bg-white rounded-pill px-3 py-2 text-xs font-semibold shadow-xs">
            <i class="fa-solid fa-download me-1 text-secondary"></i>Xuất
        </button>
        <button class="btn btn-dark rounded-pill px-3.5 py-2 text-xs font-bold shadow-xs">
            <i class="fa-solid fa-plus me-1.5"></i>Thêm khách
        </button>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="crm-card p-3 mb-4">
    <!-- Row 1: Search & Advanced Filters -->
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div class="position-relative flex-grow-1">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 14px; top: 50%; transform: translateY(-50%); font-size: 13px;"></i>
            <input type="text" class="form-control rounded-pill bg-light border-0 ps-5 py-2 text-xs" placeholder="Tìm theo tên hoặc số điện thoại..." style="font-size: 13px;">
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light border bg-white rounded-pill px-3 py-1.5 text-xs font-semibold">
                <i class="fa-solid fa-sliders me-1 text-secondary"></i>Lọc nâng cao
            </button>
            <button class="btn btn-light border bg-white rounded-pill px-3 py-1.5 text-xs font-semibold">
                <i class="fa-solid fa-table-columns me-1 text-secondary"></i>Cột
            </button>
        </div>
    </div>

    <!-- Row 2: Filter Tag Pills (Matching screenshot 1 pills) -->
    <div class="d-flex align-items-center flex-wrap gap-2">
        <button class="btn btn-dark rounded-pill px-3 py-1.5 text-xs font-bold">Tất cả <span class="badge bg-secondary-subtle text-white rounded-circle ms-1">15</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Mới hôm nay <span class="badge bg-info-subtle text-info rounded-circle ms-1">0</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Cần follow hôm nay <span class="badge bg-warning-subtle text-warning-emphasis rounded-circle ms-1">6</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Đang bị bỏ đói <span class="badge bg-danger-subtle text-danger rounded-circle ms-1">7</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Sắp hết 14 ngày <span class="badge bg-danger-subtle text-danger rounded-circle ms-1">2</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Sinh nhật tháng này <span class="badge bg-primary-subtle text-primary rounded-circle ms-1">1</span></button>
        <button class="btn btn-light border rounded-pill px-3 py-1.5 text-xs font-medium text-secondary">Đã chốt <span class="badge bg-success-subtle text-success rounded-circle ms-1">2</span></button>
    </div>
</div>

<!-- 🌟 CUSTOMER DATA TABLE (Khớp 100% bảng dữ liệu ảnh mẫu 1) -->
<div class="crm-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 13px;">
            <thead class="bg-light text-secondary text-uppercase font-bold" style="font-size: 11px; letter-spacing: 0.5px; border-bottom: 1px solid #e5e7eb;">
                <tr>
                    <th class="ps-4 py-3" style="width: 40px;"><input class="form-check-input" type="checkbox"></th>
                    <th class="py-3">KHÁCH HÀNG</th>
                    <th class="py-3">MỨC LỬA</th>
                    <th class="py-3">TRẠNG THÁI</th>
                    <th class="py-3">TỆP KHÁCH</th>
                    <th class="py-3">IM LẶNG</th>
                    <th class="py-3">ĐỒNG HỒ 14N</th>
                    <th class="py-3">FOLLOW TIẾP</th>
                    <th class="py-3 text-end">GIÁ TRỊ CƠ HỘI</th>
                    <th class="pe-4 py-3 text-center">CHẠM</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Phạm Thị Kim Ngân</strong>
                        <span class="text-muted text-xs">0938776655</span>
                    </td>
                    <td><span class="badge-flame-yellow">🔥 3 Bén Lửa</span></td>
                    <td><span class="badge-status-green"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>Đang chăm</span></td>
                    <td><span class="badge-status-green">B Dòng tiền</span></td>
                    <td><span class="badge bg-danger-subtle text-danger rounded-pill px-2">6n / 5n</span></td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-danger fw-bold">02/08/2026</td>
                    <td class="text-end fw-bold text-dark">4,5 tỷ</td>
                    <td class="pe-4 text-center text-muted">3 (3★)</td>
                </tr>

                <!-- Row 2 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Trương Khánh Vy</strong>
                        <span class="text-muted text-xs">0913668877</span>
                    </td>
                    <td><span class="badge-flame-red">🔥 5 Cháy Rực</span></td>
                    <td><span class="badge-status-green"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>Đã chốt</span></td>
                    <td><span class="badge-tag-blue">A Giữ tài sản</span></td>
                    <td class="text-muted">89 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">chưa đặt</td>
                    <td class="text-end fw-bold text-dark">11 tỷ</td>
                    <td class="pe-4 text-center text-muted">4 (4★)</td>
                </tr>

                <!-- Row 3 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Nguyễn Hữu Phước</strong>
                        <span class="text-muted text-xs">0908445511</span>
                    </td>
                    <td><span class="badge-flame-red">🔥 5 Cháy Rực</span></td>
                    <td><span class="badge-status-green"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>Đã chốt</span></td>
                    <td><span class="badge-status-green">B Dòng tiền</span></td>
                    <td class="text-muted">56 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">chưa đặt</td>
                    <td class="text-end fw-bold text-dark">9 tỷ</td>
                    <td class="pe-4 text-center text-muted">4 (4★)</td>
                </tr>

                <!-- Row 4 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Cao Nhật Minh</strong>
                        <span class="text-muted text-xs">0967003344</span>
                    </td>
                    <td><span class="badge-tag-gray">🔥 1 Tắt Ngấm</span></td>
                    <td><span class="badge bg-danger-subtle text-danger border rounded-pill px-2"><span class="d-inline-block rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span>Mất liên lạc</span></td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">71 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">chưa đặt</td>
                    <td class="text-end text-muted">&mdash;</td>
                    <td class="pe-4 text-center text-muted">1</td>
                </tr>

                <!-- Row 5 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Đỗ Thu Hà</strong>
                        <span class="text-muted text-xs">0922889900</span>
                    </td>
                    <td><span class="badge-flame-yellow">🔥 2 Khói Nhẹ</span></td>
                    <td><span class="badge bg-light text-secondary border rounded-pill px-2"><span class="d-inline-block rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>Từ chối</span></td>
                    <td><span class="badge bg-purple-subtle text-purple border rounded-pill px-2" style="background: #f3e8ff; color: #7e22ce;">C Nghi dưỡng</span></td>
                    <td class="text-muted">41 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">chưa đặt</td>
                    <td class="text-end text-muted">&mdash;</td>
                    <td class="pe-4 text-center text-muted">2 (2★)</td>
                </tr>

                <!-- Row 6 -->
                <tr class="border-bottom">
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Lý Gia Huy</strong>
                        <span class="text-muted text-xs">0901556644</span>
                    </td>
                    <td><span class="badge-flame-yellow">🔥 3 Bén Lửa</span></td>
                    <td><span class="badge bg-warning-subtle text-warning-emphasis border rounded-pill px-2"><span class="d-inline-block rounded-circle bg-warning me-1" style="width: 6px; height: 6px;"></span>Nuôi thưa</span></td>
                    <td><span class="badge-tag-blue">A Giữ tài sản</span></td>
                    <td class="text-muted">46 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">chưa đặt</td>
                    <td class="text-end fw-bold text-dark">20 tỷ</td>
                    <td class="pe-4 text-center text-muted">2 (2★)</td>
                </tr>

                <!-- Row 7 -->
                <tr>
                    <td class="ps-4"><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <strong class="text-dark d-block">Trịnh Bảo Châu</strong>
                        <span class="text-muted text-xs">0944118822</span>
                    </td>
                    <td><span class="badge-tag-gray">🔥 1 Tắt Ngấm</span></td>
                    <td><span class="badge-status-green"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>Đang chăm</span></td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-muted">1 ngày</td>
                    <td class="text-muted">&mdash;</td>
                    <td class="text-danger fw-bold">03/08/2026</td>
                    <td class="text-end text-muted">&mdash;</td>
                    <td class="pe-4 text-center text-muted">0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
