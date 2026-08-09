<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhật ký tương tác - CRM Ngọn Lửa EcoFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        /* 🌟 DARK SIDEBAR MATCHING SCREENSHOT EXACTLY */
        .crm-sidebar {
            width: 240px;
            background-color: #111827;
            color: #9ca3af;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .crm-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            margin-bottom: 24px;
            padding-left: 6px;
        }

        .crm-brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
        }

        .crm-brand-title {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
            color: #ffffff;
        }

        .crm-brand-sub {
            font-size: 11px;
            color: #6b7280;
        }

        .crm-nav-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #6b7280;
            text-uppercase;
            margin-top: 18px;
            margin-bottom: 6px;
            padding-left: 10px;
        }

        .crm-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.15s ease;
            margin-bottom: 2px;
        }

        .crm-nav-item:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Active sidebar item with orange neon box border */
        .crm-nav-item.active {
            color: #ffffff;
            background-color: #1f2937;
            border: 1.5px solid #f97316;
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.2);
            font-weight: 600;
        }

        /* 🌟 MAIN RIGHT WORKSPACE */
        .crm-main {
            margin-left: 240px;
            padding: 28px 36px;
        }

        .crm-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .crm-header-title {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 2px;
        }

        .crm-header-subtitle {
            font-size: 13.5px;
            color: #6b7280;
            margin-bottom: 0;
        }

        .crm-week-btn {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 7px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            cursor: pointer;
        }

        /* 🌟 LEFT FILTER CARD */
        .crm-filter-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid #e5e7eb;
        }

        .crm-filter-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
        }

        .crm-label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .crm-search-box {
            position: relative;
            margin-bottom: 16px;
        }

        .crm-search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 13px;
        }

        .crm-search-box input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            padding: 8px 12px 8px 34px;
            font-size: 12.5px;
            color: #111827;
            outline: none;
        }

        .crm-search-box input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.12);
        }

        .crm-date-input {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 6px 10px;
            font-size: 12px;
            color: #374151;
            background-color: #ffffff;
        }

        .crm-pill-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 16px;
        }

        .crm-pill-btn {
            border-radius: 9999px;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            color: #374151;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .crm-pill-btn:hover, .crm-pill-btn.active {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        /* 🌟 RIGHT CARD-ROW FEED ITEMS */
        .crm-log-item {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            border: 1px solid #f3f4f6;
            transition: all 0.15s ease;
        }

        .crm-log-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: #e5e7eb;
        }

        .crm-dot-green {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            margin-right: 8px;
        }

        .crm-log-name {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        /* FLAME BADGES MATCHING SCREENSHOT EXACTLY */
        .badge-chay-ruc {
            background-color: #dc2626;
            color: #ffffff;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-khoi-nhe {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-ben-lua {
            background-color: #ffedd5;
            color: #c2410c;
            border: 1px solid #fed7aa;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-lua-lon {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-tag-gray {
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-tag-outline {
            background-color: #fffbebf5;
            color: #78350f;
            border: 1px solid #fef3c7;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 500;
        }

        .crm-log-subtext {
            font-size: 13.5px;
            color: #4b5563;
            margin-top: 6px;
            padding-left: 16px;
            line-height: 1.5;
        }

        .crm-log-time {
            font-size: 11.5px;
            color: #9ca3af;
        }

        .crm-trash-icon {
            color: #d1d5db;
            cursor: pointer;
            transition: color 0.15s ease;
        }

        .crm-trash-icon:hover {
            color: #ef4444;
        }

        /* Progress bars widget */
        .progress-thin {
            height: 7px;
            border-radius: 9999px;
            background-color: #f3f4f6;
            overflow: hidden;
        }
    </style>
</head>
<body>

    <!-- 🌟 DARK LEFT SIDEBAR -->
    <aside class="crm-sidebar">
        <!-- Brand logo -->
        <div class="crm-brand">
            <div class="crm-brand-icon">
                <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div>
                <div class="crm-brand-title">CRM Ngọn Lửa</div>
                <div class="crm-brand-sub">Quản lý khách hàng EcoFarm</div>
            </div>
        </div>

        <!-- HÔM NAY -->
        <div class="crm-nav-section">HÔM NAY</div>
        <a href="/" class="crm-nav-item">
            <i class="fa-solid fa-border-all" style="width: 18px;"></i>
            <span>Tổng quan</span>
        </a>
        <a href="/admin/bao-cao-doanh-thu" class="crm-nav-item">
            <i class="fa-regular fa-calendar-check" style="width: 18px;"></i>
            <span>Lịch follow-up</span>
        </a>

        <!-- KHÁCH HÀNG -->
        <div class="crm-nav-section">KHÁCH HÀNG</div>
        <a href="/admin/customers" class="crm-nav-item">
            <i class="fa-solid fa-users" style="width: 18px;"></i>
            <span>Danh sách khách</span>
        </a>
        <!-- Active item with orange box outline -->
        <a href="/nhat-ky-tuong-tac" class="crm-nav-item active">
            <i class="fa-solid fa-square-poll-vertical" style="width: 18px;"></i>
            <span>Nhật ký tương tác</span>
        </a>

        <!-- HÀNG & TIỀN -->
        <div class="crm-nav-section">HÀNG & TIỀN</div>
        <a href="/admin/products" class="crm-nav-item">
            <i class="fa-solid fa-boxes-stacked" style="width: 18px;"></i>
            <span>Kho vật tư</span>
        </a>
        <a href="/lich-su-don-hang" class="crm-nav-item">
            <i class="fa-solid fa-handshake" style="width: 18px;"></i>
            <span>Deal đã chốt</span>
        </a>

        <!-- CÔNG CỤ -->
        <div class="crm-nav-section">CÔNG CỤ</div>
        <a href="/cam-nang" class="crm-nav-item">
            <i class="fa-solid fa-book-open" style="width: 18px;"></i>
            <span>Thư viện nội dung</span>
        </a>
        <a href="/admin/bao-cao-doanh-thu" class="crm-nav-item">
            <i class="fa-solid fa-chart-line" style="width: 18px;"></i>
            <span>Báo cáo</span>
        </a>

        <!-- CÀI ĐẶT -->
        <div class="mt-auto pt-3">
            <a href="/admin" class="crm-nav-item">
                <i class="fa-solid fa-gear" style="width: 18px;"></i>
                <span>Cài đặt</span>
            </a>
            <div class="p-2.5 rounded-3 bg-dark text-muted mt-2" style="font-size: 10.5px; border: 1px solid rgba(255,255,255,0.05);">
                <i class="fa-solid fa-shield-halved text-success me-1"></i>Dữ liệu nằm trên máy anh, không gửi đi đâu cả
            </div>
        </div>
    </aside>

    <!-- 🌟 MAIN WORKSPACE -->
    <main class="crm-main">
        <!-- Top Bar Header -->
        <div class="crm-top-bar">
            <div>
                <h1 class="crm-header-title">Nhật ký tương tác</h1>
                <p class="crm-header-subtitle">
                    39 lần chạm khớp bộ lọc &bull; 31 có phản hồi thật
                </p>
            </div>
            <div>
                <button class="crm-week-btn">
                    Tuần này <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 11px;"></i>
                </button>
            </div>
        </div>

        <div class="row g-4">
            <!-- 🌟 LEFT FILTER SIDEBAR CARD -->
            <div class="col-lg-4" style="width: 320px;">
                <div class="crm-filter-card">
                    <h5 class="crm-filter-title">Bộ lọc</h5>

                    <!-- Search box -->
                    <div class="crm-label">Tìm</div>
                    <div class="crm-search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="filterKeyword" placeholder="Tên khách, SĐT, nội dung...">
                    </div>

                    <!-- Date range -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="crm-label">Từ ngày</div>
                            <input type="text" class="crm-date-input" value="dd/mm/yyyy">
                        </div>
                        <div class="col-6">
                            <div class="crm-label">Đến ngày</div>
                            <input type="text" class="crm-date-input" value="dd/mm/yyyy">
                        </div>
                    </div>

                    <!-- Kênh -->
                    <div class="crm-label">Kênh</div>
                    <div class="crm-pill-group">
                        <button type="button" class="crm-pill-btn">Gọi điện</button>
                        <button type="button" class="crm-pill-btn active">Nhắn Zalo</button>
                        <button type="button" class="crm-pill-btn">Gặp mặt</button>
                        <button type="button" class="crm-pill-btn">Zoom</button>
                        <button type="button" class="crm-pill-btn">SMS</button>
                    </div>

                    <!-- Loại nội dung -->
                    <div class="crm-label">Loại nội dung</div>
                    <div class="crm-pill-group">
                        <button type="button" class="crm-pill-btn">Củi dễ cháy</button>
                        <button type="button" class="crm-pill-btn">Củi cháy bền</button>
                        <button type="button" class="crm-pill-btn">Củi ướt</button>
                        <button type="button" class="crm-pill-btn">Dầu</button>
                        <button type="button" class="crm-pill-btn">Khác</button>
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="qualityOnly">
                        <label class="form-check-label text-xs font-medium text-secondary" for="qualityOnly" style="font-size: 12.5px;">
                            Chỉ hiện tương tác chất lượng
                        </label>
                    </div>

                    <!-- Cơ cấu nội dung widget (Matching progress bars in screenshot) -->
                    <div class="pt-3 border-top">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Cơ cấu nội dung</h6>
                        <p class="text-muted mb-3" style="font-size: 11.5px;">Mình đang bỏ loại củi nào vào lửa</p>

                        <!-- Bar 1 -->
                        <div class="mb-2.5">
                            <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                <span class="fw-semibold text-dark">Củi dễ cháy</span>
                                <span class="fw-bold text-dark">56%</span>
                            </div>
                            <div class="progress-thin">
                                <div class="bg-warning" style="width: 56%; height: 100%; background-color: #f97316 !important;"></div>
                            </div>
                        </div>

                        <!-- Bar 2 -->
                        <div class="mb-2.5">
                            <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                <span class="fw-semibold text-dark">Củi cháy bền</span>
                                <span class="fw-bold text-dark">28%</span>
                            </div>
                            <div class="progress-thin">
                                <div class="bg-success" style="width: 28%; height: 100%; background-color: #10b981 !important;"></div>
                            </div>
                        </div>

                        <!-- Bar 3 -->
                        <div>
                            <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                <span class="fw-semibold text-dark">Củi ướt</span>
                                <span class="fw-bold text-dark">8%</span>
                            </div>
                            <div class="progress-thin">
                                <div class="bg-secondary" style="width: 8%; height: 100%; opacity: 0.5;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🌟 RIGHT FEED ITEMS (Khớp 100% từng dòng thẻ trong ảnh mẫu) -->
            <div class="col-lg-8" style="flex: 1;">
                <div class="d-flex flex-column gap-1.5" id="interactionFeed">

                    <!-- Item 1 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Nguyễn Thanh Tùng</span>
                                <span class="badge-chay-ruc"><i class="fa-solid fa-fire me-0.5"></i>Cháy Rực</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi dễ cháy</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">31/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi bảng tính dòng tiền 3 phương án. Anh hỏi ân hạn gốc kéo được bao lâu.
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Hoàng Minh Tuấn</span>
                                <span class="badge-khoi-nhe"><i class="fa-solid fa-fire me-0.5"></i>Khói Nhẹ</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi cháy bền</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">30/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi bài phân tích hạ tầng. Anh thả tim, chưa nhắn lại.
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Phạm Thị Kim Ngân</span>
                                <span class="badge-ben-lua"><i class="fa-solid fa-fire me-0.5"></i>Bén Lửa</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi dễ cháy</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">29/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi 3 căn phù hợp tầm giá. Chị hỏi thêm về phương thức thanh toán.
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Trần Mỹ Hạnh</span>
                                <span class="badge-lua-lon"><i class="fa-solid fa-fire me-0.5"></i>Lửa Lớn</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi cháy bền</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">28/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi so sánh với dự án nghỉ dưỡng Hồ Tràm. Chị xem nhưng chưa trả lời.
                        </div>
                    </div>

                    <!-- Item 5 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Lê Quốc Bảo</span>
                                <span class="badge-lua-lon"><i class="fa-solid fa-fire me-0.5"></i>Lửa Lớn</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi ướt</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">26/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi tin thị trường chung chung, không đúng thứ anh cần.
                        </div>
                    </div>

                    <!-- Item 6 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Nguyễn Thanh Tùng</span>
                                <span class="badge-chay-ruc"><i class="fa-solid fa-fire me-0.5"></i>Cháy Rực</span>
                                <span class="badge-tag-gray">Gọi điện</span>
                                <span class="badge-tag-outline">Dầu</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">25/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Báo căn A1-18.02 chỉ còn 2 căn cùng loại. Anh nói để bàn với vợ cuối tuần.
                        </div>
                    </div>

                    <!-- Item 7 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Hoàng Minh Tuấn</span>
                                <span class="badge-khoi-nhe"><i class="fa-solid fa-fire me-0.5"></i>Khói Nhẹ</span>
                                <span class="badge-tag-gray">Gọi điện</span>
                                <span class="badge-tag-outline">Củi dễ cháy</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">23/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Nghe máy, quan tâm nhưng chưa vội. Nói cứ gửi thông tin dần.
                        </div>
                    </div>

                    <!-- Item 8 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Nguyễn Thanh Tùng</span>
                                <span class="badge-chay-ruc"><i class="fa-solid fa-fire me-0.5"></i>Cháy Rực</span>
                                <span class="badge-tag-gray">Gặp mặt</span>
                                <span class="badge-tag-outline">Củi dễ cháy</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">22/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Đi xem thực địa cùng vợ. Vợ thích view sông, anh quan tâm pháp lý.
                        </div>
                    </div>

                    <!-- Item 9 -->
                    <div class="crm-log-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="crm-dot-green"></span>
                                <span class="crm-log-name">Đặng Hoài Nam</span>
                                <span class="badge-khoi-nhe"><i class="fa-solid fa-fire me-0.5"></i>Khói Nhẹ</span>
                                <span class="badge-tag-gray">Nhắn Zalo</span>
                                <span class="badge-tag-outline">Củi ướt</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="crm-log-time">19/07/2026 15:50</span>
                                <i class="fa-regular fa-trash-can crm-trash-icon"></i>
                            </div>
                        </div>
                        <div class="crm-log-subtext">
                            Gửi bảng giá. Đã xem, không trả lời.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('filterKeyword');
            if (input) {
                input.addEventListener('keyup', function() {
                    const q = this.value.toLowerCase();
                    const items = document.querySelectorAll('.crm-log-item');
                    items.forEach(item => {
                        item.style.display = item.textContent.toLowerCase().includes(q) ? 'block' : 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>
