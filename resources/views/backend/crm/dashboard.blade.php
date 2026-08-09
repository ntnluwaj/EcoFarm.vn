@extends('backend.layouts.crm_management')

@section('title', 'Tổng quan hệ thống - CRM Ngọn Lửa EcoFarm')

@section('content')
<!-- Header Bar -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="crm-header-title">Tổng quan</h1>
        <p class="crm-header-subtitle">
            10 khách đang chăm trên tổng {{ $totalCount ?? 15 }} &bull; 0 lead mới hôm nay
        </p>
    </div>
</div>

<!-- 🌟 TOP 4 METRIC STAT CARDS (Khớp 100% 4 ô chỉ số ảnh mẫu 2) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Doanh thu dự báo -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold" style="font-size: 12.5px;">Doanh thu dự báo (có trọng số)</span>
                <div class="p-2 bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-arrow-trend-up fs-6"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark mb-1" style="font-size: 26px;">27,05 tỷ</h2>
            <p class="text-muted mb-0" style="font-size: 11.5px;">Từ 47,5 tỷ cơ hội đang mở</p>
        </div>
    </div>

    <!-- Card 2: Hoa hồng tháng này -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold" style="font-size: 12.5px;">Hoa hồng tháng này</span>
                <div class="p-2 bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-wallet fs-6"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark mb-1" style="font-size: 26px;">0</h2>
            <p class="text-muted mb-0" style="font-size: 11.5px;">0 deal &bull; +0 so với tháng trước</p>
        </div>
    </div>

    <!-- Card 3: Khách đang bị bỏ đói -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold" style="font-size: 12.5px;">Khách đang bị bỏ đói</span>
                <div class="p-2 bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-bolt fs-6"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-danger mb-1" style="font-size: 26px;">7</h2>
            <p class="text-muted mb-0" style="font-size: 11.5px;">Im lặng quá ngưỡng của mức lửa</p>
        </div>
    </div>

    <!-- Card 4: Đồng hồ 14 ngày -->
    <div class="col-md-3">
        <div class="crm-card h-100 p-3.5 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold" style="font-size: 12.5px;">Đồng hồ 14 ngày</span>
                <div class="p-2 bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-regular fa-clock fs-6"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-warning mb-1" style="font-size: 26px;">2</h2>
            <p class="text-muted mb-0" style="font-size: 11.5px;">2 quá hạn &bull; 0 sắp hết</p>
        </div>
    </div>
</div>

<!-- 🌟 MAIN ANALYTICS SECTION (Khớp 100% 2 ô biểu đồ ảnh mẫu 2) -->
<div class="row g-3 mb-4">
    <!-- Panel 1: Phễu mức lửa (Funnel breakdown) -->
    <div class="col-lg-8">
        <div class="crm-card h-100 p-4 mb-0">
            <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Phễu mức lửa</h5>
            <p class="text-muted mb-4" style="font-size: 12.5px;">Số khách đang chăm ở từng mức, kèm tiền kỳ vọng mức đó mang lại</p>

            <div class="d-flex flex-column gap-3 mb-4">
                <!-- Row 1: Tắt Ngấm -->
                <div class="row align-items-center g-2" style="font-size: 12.5px;">
                    <div class="col-2 fw-semibold text-secondary">
                        <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #94a3b8;"></span>Tắt Ngấm
                    </div>
                    <div class="col-6">
                        <div class="progress" style="height: 10px; border-radius: 9999px; background-color: #f1f5f9;">
                            <div class="progress-bar" style="width: 60%; background-color: #94a3b8;"></div>
                        </div>
                    </div>
                    <div class="col-1 text-center fw-bold">3</div>
                    <div class="col-1 text-muted text-center">2%</div>
                    <div class="col-2 text-end text-muted">&mdash;</div>
                </div>

                <!-- Row 2: Khói Nhẹ -->
                <div class="row align-items-center g-2" style="font-size: 12.5px;">
                    <div class="col-2 fw-semibold text-warning">
                        <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #eab308;"></span>Khói Nhẹ
                    </div>
                    <div class="col-6">
                        <div class="progress" style="height: 10px; border-radius: 9999px; background-color: #f1f5f9;">
                            <div class="progress-bar" style="width: 40%; background-color: #eab308;"></div>
                        </div>
                    </div>
                    <div class="col-1 text-center fw-bold">2</div>
                    <div class="col-1 text-muted text-center">10%</div>
                    <div class="col-2 text-end fw-bold text-success">500 tr</div>
                </div>

                <!-- Row 3: Bén Lửa -->
                <div class="row align-items-center g-2" style="font-size: 12.5px;">
                    <div class="col-2 fw-semibold text-danger">
                        <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #f97316;"></span>Bén Lửa
                    </div>
                    <div class="col-6">
                        <div class="progress" style="height: 10px; border-radius: 9999px; background-color: #f1f5f9;">
                            <div class="progress-bar" style="width: 40%; background-color: #f97316;"></div>
                        </div>
                    </div>
                    <div class="col-1 text-center fw-bold">2</div>
                    <div class="col-1 text-muted text-center">30%</div>
                    <div class="col-2 text-end fw-bold text-success">4,35 tỷ</div>
                </div>

                <!-- Row 4: Lửa Lớn -->
                <div class="row align-items-center g-2" style="font-size: 12.5px;">
                    <div class="col-2 fw-semibold text-danger">
                        <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #ef4444;"></span>Lửa Lớn
                    </div>
                    <div class="col-6">
                        <div class="progress" style="height: 10px; border-radius: 9999px; background-color: #f1f5f9;">
                            <div class="progress-bar" style="width: 40%; background-color: #ef4444;"></div>
                        </div>
                    </div>
                    <div class="col-1 text-center fw-bold">2</div>
                    <div class="col-1 text-muted text-center">60%</div>
                    <div class="col-2 text-end fw-bold text-success">8,7 tỷ</div>
                </div>

                <!-- Row 5: Cháy Rực -->
                <div class="row align-items-center g-2" style="font-size: 12.5px;">
                    <div class="col-2 fw-semibold text-danger">
                        <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #dc2626;"></span>Cháy Rực
                    </div>
                    <div class="col-6">
                        <div class="progress" style="height: 10px; border-radius: 9999px; background-color: #f1f5f9;">
                            <div class="progress-bar" style="width: 20%; background-color: #dc2626;"></div>
                        </div>
                    </div>
                    <div class="col-1 text-center fw-bold">1</div>
                    <div class="col-1 text-muted text-center">100%</div>
                    <div class="col-2 text-end fw-bold text-success">13,5 tỷ</div>
                </div>
            </div>

            <!-- Footer summary -->
            <div class="pt-3 border-top d-flex align-items-center justify-content-between text-xs text-muted">
                <span>Kỳ vọng = giá trị cơ hội &times; xác suất chốt. <a href="#" class="text-muted text-decoration-underline">Chỉnh xác suất</a></span>
                <span class="fw-bold text-dark fs-6">Tổng kỳ vọng <strong class="text-success fs-5 ms-1">27,05 tỷ</strong></span>
            </div>
        </div>
    </div>

    <!-- Panel 2: Nhịp chạm 7 ngày (Weekly chart) -->
    <div class="col-lg-4">
        <div class="crm-card h-100 p-4 mb-0">
            <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Nhịp chạm 7 ngày</h5>
            <p class="text-muted mb-4" style="font-size: 12.5px;">Cột đậm là tương tác có phản hồi thật</p>

            <!-- Chart Columns -->
            <div class="d-flex align-items-end justify-content-between pt-4 pb-2 px-2" style="height: 160px; border-bottom: 1px solid #e5e7eb;">
                <div class="text-center" style="flex: 1;">
                    <div class="bg-success rounded-top mx-auto" style="width: 18px; height: 75px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 4</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-success rounded-top mx-auto" style="width: 18px; height: 90px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 5</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-success rounded-top mx-auto" style="width: 18px; height: 85px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 6</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-light rounded-top mx-auto" style="width: 18px; height: 10px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 7</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-light rounded-top mx-auto" style="width: 18px; height: 10px;"></div>
                    <span class="d-block text-muted text-xs mt-2">CN</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-light rounded-top mx-auto" style="width: 18px; height: 10px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 2</span>
                </div>
                <div class="text-center" style="flex: 1;">
                    <div class="bg-light rounded-top mx-auto" style="width: 18px; height: 10px;"></div>
                    <span class="d-block text-muted text-xs mt-2">Thứ 3</span>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-3 pt-3 text-xs text-muted">
                <span><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #e5e7eb;"></span>Tổng chạm</span>
                <span><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #10b981;"></span>Có phản hồi thật</span>
            </div>
        </div>
    </div>
</div>

<!-- 🌟 BOTTOM 3 TASK & REMINDER CARDS (Khớp 100% 3 thẻ công việc ảnh mẫu 2) -->
<div class="row g-3">
    <!-- Card 1: Cần làm hôm nay -->
    <div class="col-md-4">
        <div class="crm-card p-3.5 mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="fa-solid fa-phone-volume text-info me-2"></i>Cần làm hôm nay
                </h6>
                <span class="badge bg-light text-secondary border rounded-pill px-2.5">6 việc</span>
            </div>

            <div class="d-flex align-items-center justify-content-between p-2.5 bg-light rounded-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong class="text-dark" style="font-size: 13.5px;">Nguyễn Thanh Tùng</strong>
                        <span class="badge-flame-red">🔥 Cháy Rực</span>
                    </div>
                    <span class="text-muted" style="font-size: 11.5px;">Chốt phương án thanh toán...</span>
                </div>
                <span class="text-muted font-monospace" style="font-size: 11px;">04/08/2026</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Đang bị bỏ đói -->
    <div class="col-md-4">
        <div class="crm-card p-3.5 mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="fa-solid fa-bolt text-danger me-2"></i>Đang bị bỏ đói
                </h6>
                <span class="badge bg-light text-secondary border rounded-pill px-2.5">7 khách</span>
            </div>

            <div class="d-flex align-items-center justify-content-between p-2.5 bg-light rounded-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong class="text-dark" style="font-size: 13.5px;">Bùi Thanh Trúc</strong>
                        <span class="badge-tag-gray">🔥 Tắt Ngấm</span>
                    </div>
                    <span class="text-muted" style="font-size: 11.5px;">Nguồn mức 1 là 21 ngày</span>
                </div>
                <span class="text-danger fw-bold" style="font-size: 11px;">Im 28 ngày</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Đồng hồ 14 ngày -->
    <div class="col-md-4">
        <div class="crm-card p-3.5 mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="fa-regular fa-clock text-warning me-2"></i>Đồng hồ 14 ngày
                </h6>
                <span class="badge bg-light text-secondary border rounded-pill px-2.5">2 quá hạn</span>
            </div>

            <div class="d-flex align-items-center justify-content-between p-2.5 bg-light rounded-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong class="text-dark" style="font-size: 13.5px;">Lê Quốc Bảo</strong>
                        <span class="badge-flame-red">🔥 Lửa Lớn</span>
                    </div>
                    <span class="text-muted" style="font-size: 11.5px;">6,5 tỷ</span>
                </div>
                <span class="text-danger fw-bold" style="font-size: 11px;">Quá 7 ngày</span>
            </div>
        </div>
    </div>
</div>
@endsection
