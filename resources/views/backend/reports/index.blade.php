@extends('frontend.layouts.master')

@section('title', 'CRM Dashboard - EcoFarm System')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<style>
    .crm-wrapper {
        background-color: #e2eafd;
        min-height: 95vh;
        padding: 24px;
        font-family: 'Outfit', sans-serif;
    }
    .crm-header-card {
        background: transparent;
        margin-bottom: 20px;
    }
    .crm-nav-pill-box {
        background: #1e3a8a;
        border-radius: 9999px;
        padding: 6px 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .crm-nav-btn {
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 9999px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .crm-nav-btn.active {
        background: #3b82f6;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    .crm-nav-btn-white {
        background: #ffffff;
        color: #1e3a8a;
        font-size: 13px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 9999px;
        text-decoration: none;
    }

    /* 8 Vibrant Metric Solid Block Cards */
    .metric-card {
        border-radius: 16px;
        padding: 16px 20px;
        color: #ffffff;
        min-height: 105px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        transition: transform 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
    }
    .metric-purple { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .metric-darkblue { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }
    .metric-lightblue { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
    .metric-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

    .metric-title {
        font-size: 12px;
        font-weight: 500;
        opacity: 0.9;
        text-transform: capitalize;
    }
    .metric-value {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        line-height: 1.1;
    }

    /* White Panel Cards */
    .crm-panel-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        height: 100%;
    }
    .crm-panel-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }

    /* Filter Column Inputs */
    .crm-filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
        display: block;
    }
    .crm-filter-select {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 13px;
        color: #334155;
        width: 100%;
    }

    /* Bottom Banner */
    .crm-footer-banner {
        background: #3730a3;
        color: #ffffff;
        border-radius: 12px;
        padding: 12px 24px;
        text-center: center;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>

<div class="crm-wrapper">
    <!-- Header Top Row (Matching Reference Image) -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between crm-header-card">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow-sm" style="width: 46px; height: 46px; font-weight: 800; font-size: 22px; background-color: #0284c7 !important;">
                C
            </div>
            <div>
                <h3 class="fw-extrabold text-dark mb-0 fs-4" style="color: #0f172a;">CRM dashboard</h3>
                <span class="text-uppercase text-muted text-xs fw-bold" style="letter-spacing: 1px;">COUPLER.IO / ECOFARM.VN</span>
            </div>
        </div>

        <div class="crm-nav-pill-box mt-3 mt-md-0">
            <a href="{{ route('admin.reports') }}" class="crm-nav-btn active">Overview</a>
            <a href="/admin/customers" class="crm-nav-btn">Agents</a>
            <a href="/admin/orders" class="crm-nav-btn">Deals</a>
            <a href="/admin" class="crm-nav-btn-white">Setup dashboard</a>
        </div>
    </div>

    <!-- Main Grid Layout (Matching Reference Image Exact Grid) -->
    <div class="row g-3 mb-4">
        
        <!-- LEFT COLUMN (55% width): 8 Metric Cards Grid + 2 Area Charts -->
        <div class="col-lg-7">
            <!-- 8 Solid Color Metric Cards (2 Rows x 4 Columns) -->
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-purple">
                        <span class="metric-title">Total sales</span>
                        <h4 class="metric-value">{{ number_format($revenue / 1000000, 1) }}M</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-darkblue">
                        <span class="metric-title">Win rate</span>
                        <h4 class="metric-value">{{ $totalOrdersCount > 0 ? round(($completedOrdersCount / $totalOrdersCount) * 100, 2) : 0 }}%</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-lightblue">
                        <span class="metric-title">Close rate</span>
                        <h4 class="metric-value">{{ $totalOrdersCount > 0 ? round(($pendingOrdersCount / $totalOrdersCount) * 100, 2) : 0 }}%</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-emerald">
                        <span class="metric-title">Avg days to close</span>
                        <h4 class="metric-value">1.50</h4>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="metric-card metric-purple">
                        <span class="metric-title">Pipeline value</span>
                        <h4 class="metric-value">{{ number_format($pendingCodAmount / 1000000, 1) }}M</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-darkblue">
                        <span class="metric-title">Open deals</span>
                        <h4 class="metric-value">{{ $pendingOrdersCount + $processingOrdersCount + $shippingOrdersCount }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-lightblue">
                        <span class="metric-title">Weighted value</span>
                        <h4 class="metric-value">{{ number_format($avgOrderValue / 1000, 1) }}K</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="metric-card metric-emerald">
                        <span class="metric-title">Avg open deal age</span>
                        <h4 class="metric-value">{{ $customerCount }}</h4>
                    </div>
                </div>
            </div>

            <!-- Chart 1: Won deals (last 12 months) -->
            <div class="crm-panel-card mb-3" style="height: 230px;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="crm-panel-title m-0">Won deals (last 12 months)</h6>
                    <span class="text-xs text-muted"><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #0284c7;"></span>Closed value <span class="d-inline-block rounded-circle ms-2 me-1" style="width: 8px; height: 8px; background: #38bdf8;"></span>Won deals</span>
                </div>
                <div style="height: 170px; position: relative;">
                    <canvas id="chartWonDeals"></canvas>
                </div>
            </div>

            <!-- Chart 2: Deals projection (future 12 months) -->
            <div class="crm-panel-card" style="height: 230px;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="crm-panel-title m-0">Deals projection (future 12 months)</h6>
                    <span class="text-xs text-muted"><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #0284c7;"></span>Projected value <span class="d-inline-block rounded-circle ms-2 me-1" style="width: 8px; height: 8px; background: #38bdf8;"></span>Deals due</span>
                </div>
                <div style="height: 170px; position: relative;">
                    <canvas id="chartDealsProjection"></canvas>
                </div>
            </div>
        </div>

        <!-- MIDDLE COLUMN (27% width): 2 Donut Charts Stacked -->
        <div class="col-lg-3">
            <!-- Donut 1: Sales pipeline -->
            <div class="crm-panel-card mb-3" style="height: 335px;">
                <h6 class="crm-panel-title mb-2">Sales pipeline</h6>
                <div style="height: 260px; position: relative;" class="d-flex align-items-center justify-content-center">
                    <canvas id="chartSalesPipeline"></canvas>
                </div>
            </div>

            <!-- Donut 2: Deal loss reasons -->
            <div class="crm-panel-card" style="height: 335px;">
                <h6 class="crm-panel-title mb-2">Deal loss reasons</h6>
                <div style="height: 260px; position: relative;" class="d-flex align-items-center justify-content-center">
                    <canvas id="chartDealLossReasons"></canvas>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN (18% width): Filter Sidebar & Contact Card -->
        <div class="col-lg-2">
            <div class="crm-panel-card d-flex flex-column justify-content-between">
                <div>
                    <!-- Date Picker Filter -->
                    <form method="GET" action="{{ route('admin.reports') }}">
                        <div class="mb-3">
                            <label class="crm-filter-label">Report date</label>
                            <input type="date" name="start_date" class="crm-filter-select mb-1 text-xs" value="{{ $startDate->format('Y-m-d') }}">
                            <input type="date" name="end_date" class="crm-filter-select text-xs" value="{{ $endDate->format('Y-m-d') }}">
                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 mt-2 fw-bold text-xs" style="background-color: #0284c7; border: none;">Lọc ngày</button>
                        </div>
                    </form>

                    <!-- Filter Dropdowns (Matching Image UI) -->
                    <div class="mb-2.5">
                        <label class="crm-filter-label">Deal Owner</label>
                        <select class="crm-filter-select">
                            <option>All</option>
                            <option>Kỹ sư Nguyễn Văn A</option>
                            <option>Nhân viên Trần B</option>
                        </select>
                    </div>

                    <div class="mb-2.5">
                        <label class="crm-filter-label">Deal Stage</label>
                        <select class="crm-filter-select">
                            <option>All</option>
                            <option>Chờ duyệt</option>
                            <option>Đang đóng gói</option>
                            <option>Đang giao</option>
                            <option>Hoàn thành</option>
                        </select>
                    </div>

                    <div class="mb-2.5">
                        <label class="crm-filter-label">Pipeline</label>
                        <select class="crm-filter-select">
                            <option>All</option>
                            <option>Thuốc trừ sâu & bệnh</option>
                            <option>Phân bón hữu cơ & NPK</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="crm-filter-label">Deal Label</label>
                        <select class="crm-filter-select">
                            <option>All</option>
                            <option>B2C Khách mua lẻ</option>
                            <option>B2B Đại lý lớn</option>
                        </select>
                    </div>
                </div>

                <!-- Support Box at bottom of filter panel -->
                <div class="p-3 bg-light rounded-4 border mt-2">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-bold" style="width: 28px; height: 28px; font-size: 11px;">
                            EC
                        </div>
                        <span class="fw-bold text-dark text-xs">Have questions?</span>
                    </div>
                    <a href="/admin/contacts" class="d-block text-xs text-primary fw-bold text-decoration-none mb-1">Dashboard setup guide</a>
                    <a href="tel:0398037435" class="d-block text-xs text-primary fw-bold text-decoration-none">Contact support</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Sticky Banner (Matching Reference Image Footer) -->
    <div class="crm-footer-banner">
        Connect 70+ data sources with Coupler.io & EcoFarm Agricultural CRM System
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Won deals (last 12 months)
        const ctxWon = document.getElementById('chartWonDeals').getContext('2d');
        new Chart(ctxWon, {
            type: 'line',
            data: {
                labels: ['May 2024', 'Jul 2024', 'Sep 2024', 'Nov 2024', 'Jan 2025', 'Mar 2025', 'May 2025'],
                datasets: [
                    {
                        label: 'Closed value',
                        data: [100, 250, 900, 200, 800, 100, 600],
                        borderColor: '#0284c7',
                        borderWidth: 2.5,
                        fill: false,
                        tension: 0.3,
                        pointRadius: 2
                    },
                    {
                        label: 'Won deals',
                        data: [200, 500, 150, 450, 700, 400, 400],
                        borderColor: '#38bdf8',
                        borderWidth: 2.5,
                        fill: false,
                        tension: 0.3,
                        pointRadius: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 2: Deals projection (future 12 months)
        const ctxProj = document.getElementById('chartDealsProjection').getContext('2d');
        new Chart(ctxProj, {
            type: 'line',
            data: {
                labels: ['May 2025', 'Jul 2025', 'Sep 2025', 'Nov 2025', 'Jan 2026', 'Mar 2026', 'May 2026'],
                datasets: [
                    {
                        label: 'Projected value',
                        data: [1000, 3000, 2500, 4000, 2000, 2500, 2000],
                        borderColor: '#0284c7',
                        borderWidth: 2.5,
                        fill: false,
                        tension: 0.3,
                        pointRadius: 2
                    },
                    {
                        label: 'Deals due',
                        data: [800, 2500, 2000, 2500, 2200, 2400, 1800],
                        borderColor: '#38bdf8',
                        borderWidth: 2.5,
                        fill: false,
                        tension: 0.3,
                        pointRadius: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 3: Donut Sales Pipeline
        const ctxPipeline = document.getElementById('chartSalesPipeline').getContext('2d');
        new Chart(ctxPipeline, {
            type: 'doughnut',
            data: {
                labels: ['Lead In 26.85%', 'Closed Lost 21.32%', 'Contact Made 18.46%', 'Interview 14.85%', 'Proposal 9.84%', 'Negotiation 5.06%'],
                datasets: [{
                    data: [26.85, 21.32, 18.46, 14.85, 9.84, 5.06],
                    backgroundColor: ['#0284c7', '#38bdf8', '#6366f1', '#a855f7', '#f43f5e', '#10b981'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });

        // Chart 4: Donut Deal Loss Reasons
        const ctxLoss = document.getElementById('chartDealLossReasons').getContext('2d');
        new Chart(ctxLoss, {
            type: 'doughnut',
            data: {
                labels: ['Feature limitations 32.97%', 'Budget constraints 21.1%', 'Price too high 18.46%', 'Better alternative 14.07%', 'Lack of urgency 13.41%'],
                datasets: [{
                    data: [32.97, 21.1, 18.46, 14.07, 13.41],
                    backgroundColor: ['#0284c7', '#38bdf8', '#6366f1', '#64748b', '#f43f5e'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection
