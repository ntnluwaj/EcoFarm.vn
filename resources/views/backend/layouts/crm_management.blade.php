<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ Thống Quản Lý EcoFarm CRM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Ẩn thanh cuộn trình duyệt */
        * {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        *::-webkit-scrollbar {
            display: none !important;
        }

        /* 🌟 DARK LEFT SIDEBAR MATCHING SCREENSHOT EXACTLY */
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
        }

        .crm-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            margin-bottom: 24px;
            padding-left: 6px;
            text-decoration: none;
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
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.4);
        }

        .crm-brand-title {
            font-size: 14.5px;
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
        }

        .crm-brand-sub {
            font-size: 10.5px;
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
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.25);
            font-weight: 600;
        }

        /* 🌟 MAIN RIGHT WORKSPACE */
        .crm-main {
            margin-left: 240px;
            padding: 28px 36px;
            min-height: 100vh;
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

        /* Modern White Card */
        .crm-card {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Badges */
        .badge-flame-red {
            background-color: #dc2626;
            color: #ffffff;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-flame-yellow {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-flame-orange {
            background-color: #ffedd5;
            color: #c2410c;
            border: 1px solid #fed7aa;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .badge-status-green {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-tag-blue {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-tag-gray {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- 🌟 DARK LEFT SIDEBAR NAVIGATION -->
    <aside class="crm-sidebar">
        <!-- Brand logo -->
        <a href="{{ route('admin.crm.dashboard') }}" class="crm-brand">
            <div class="crm-brand-icon">
                <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div>
                <div class="crm-brand-title">CRM Ngọn Lửa</div>
                <div class="crm-brand-sub">Quản lý B2B EcoFarm</div>
            </div>
        </a>

        <!-- HÔM NAY -->
        <div class="crm-nav-section">HÔM NAY</div>
        <a href="{{ route('admin.crm.dashboard') }}" class="crm-nav-item {{ request()->routeIs('admin.crm.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-border-all" style="width: 18px;"></i>
            <span>Tổng quan</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="crm-nav-item">
            <i class="fa-regular fa-calendar-check" style="width: 18px;"></i>
            <span>Lịch follow-up</span>
        </a>

        <!-- KHÁCH HÀNG -->
        <div class="crm-nav-section">KHÁCH HÀNG</div>
        <a href="{{ route('admin.crm.customers') }}" class="crm-nav-item {{ request()->routeIs('admin.crm.customers') ? 'active' : '' }}">
            <i class="fa-solid fa-users" style="width: 18px;"></i>
            <span>Danh sách khách</span>
        </a>

        <!-- HÀNG & TIỀN -->
        <div class="crm-nav-section">HÀNG & TIỀN</div>
        <a href="/admin/products" class="crm-nav-item">
            <i class="fa-solid fa-boxes-stacked" style="width: 18px;"></i>
            <span>Kho vật tư</span>
        </a>
        <a href="{{ route('admin.crm.deals') }}" class="crm-nav-item {{ request()->routeIs('admin.crm.deals') ? 'active' : '' }}">
            <i class="fa-solid fa-handshake" style="width: 18px;"></i>
            <span>Deal đã chốt</span>
        </a>

        <!-- CÔNG CỤ -->
        <div class="crm-nav-section">CÔNG CỤ</div>
        <a href="/cam-nang" class="crm-nav-item">
            <i class="fa-solid fa-book-open" style="width: 18px;"></i>
            <span>Thư viện nội dung</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="crm-nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line" style="width: 18px;"></i>
            <span>Báo cáo</span>
        </a>

        <!-- CÀI ĐẶT -->
        <div class="mt-auto pt-3">
            <a href="/" class="crm-nav-item mb-1 text-success">
                <i class="fa-solid fa-house" style="width: 18px;"></i>
                <span>Về trang chủ Web</span>
            </a>
            <a href="/admin" class="crm-nav-item">
                <i class="fa-solid fa-gear" style="width: 18px;"></i>
                <span>Filament Admin</span>
            </a>
            <div class="p-2.5 rounded-3 bg-dark text-muted mt-2" style="font-size: 10.5px; border: 1px solid rgba(255,255,255,0.05);">
                <i class="fa-solid fa-shield-halved text-success me-1"></i>Dữ liệu nằm trên máy anh, không gửi đi đâu cả
            </div>
        </div>
    </aside>

    <!-- 🌟 MAIN WORKSPACE CONTENT -->
    <main class="crm-main">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
