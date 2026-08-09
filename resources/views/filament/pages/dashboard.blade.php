<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .crm-wrapper-admin {
            background-color: #f1f5f9;
            border-radius: 20px;
            padding: 20px;
            font-family: 'Outfit', system-ui, sans-serif;
            margin-top: -10px;
        }
        .crm-nav-pill-box-admin {
            background: #1e3a8a;
            border-radius: 9999px;
            padding: 6px 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .crm-nav-btn-admin {
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 9999px;
            text-decoration: none;
        }
        .crm-nav-btn-admin.active {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        .crm-nav-btn-white-admin {
            background: #ffffff;
            color: #1e3a8a;
            font-size: 12.5px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 9999px;
            text-decoration: none;
        }

        /* 8 Solid Color Metric Cards */
        .metric-card-admin {
            border-radius: 14px;
            padding: 14px 16px;
            color: #ffffff;
            min-height: 95px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            transition: transform 0.2s ease;
        }
        .metric-card-admin:hover {
            transform: translateY(-2px);
        }
        .metric-purple-admin { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
        .metric-darkblue-admin { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }
        .metric-lightblue-admin { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
        .metric-emerald-admin { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

        .metric-title-admin {
            font-size: 11.5px;
            font-weight: 600;
            opacity: 0.95;
        }
        .metric-value-admin {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1.1;
        }

        /* Panel Cards */
        .crm-panel-card-admin {
            background: #ffffff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
            height: 100%;
        }
        .crm-panel-title-admin {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        /* Filter Controls */
        .crm-filter-label-admin {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 3px;
            display: block;
            text-transform: uppercase;
        }
        .crm-filter-select-admin {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            color: #334155;
            width: 100%;
        }

        .crm-footer-banner-admin {
            background: #3730a3;
            color: #ffffff;
            border-radius: 10px;
            padding: 10px 20px;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            margin-top: 15px;
        }
    </style>

    <div class="crm-wrapper-admin">
        <!-- Top Header Pill Navbar (Coupler.io CRM Style) -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow-sm" style="width: 42px; height: 42px; font-weight: 800; font-size: 20px; background-color: #0284c7 !important;">
                    C
                </div>
                <div>
                    <h3 class="fw-extrabold text-dark mb-0 fs-4" style="color: #0f172a;">CRM dashboard</h3>
                    <span class="text-uppercase text-muted text-xs font-bold" style="letter-spacing: 0.8px;">COUPLER.IO / ECOFARM SYSTEM</span>
                </div>
            </div>

            <div class="crm-nav-pill-box-admin mt-2 mt-md-0">
                <a href="/admin" class="crm-nav-btn-admin active">Overview</a>
                <a href="/admin/customers" class="crm-nav-btn-admin">Agents</a>
                <a href="/admin/orders" class="crm-nav-btn-admin">Deals</a>
                <a href="/admin/bao-cao-doanh-thu" class="crm-nav-btn-white-admin">Setup dashboard</a>
            </div>
        </div>

        <!-- 3-Column Layout Matching Reference Image -->
        <div class="row g-3">
            
            <!-- LEFT COLUMN (55%): 8 Metric Block Cards + 2 Area Charts -->
            <div class="col-lg-7">
                <!-- 8 Metric Solid Color Block Cards (2 Rows x 4 Columns) -->
                <div class="row g-2 mb-3">
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-purple-admin">
                            <span class="metric-title-admin">Total sales</span>
                            <h4 class="metric-value-admin">{{ number_format($revenue / 1000000, 1) }}M</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-darkblue-admin">
                            <span class="metric-title-admin">Win rate</span>
                            <h4 class="metric-value-admin">{{ $totalOrdersCount > 0 ? round(($completedOrdersCount / $totalOrdersCount) * 100, 2) : 0 }}%</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-lightblue-admin">
                            <span class="metric-title-admin">Close rate</span>
                            <h4 class="metric-value-admin">{{ $totalOrdersCount > 0 ? round(($pendingOrdersCount / $totalOrdersCount) * 100, 2) : 0 }}%</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-emerald-admin">
                            <span class="metric-title-admin">Avg days to close</span>
                            <h4 class="metric-value-admin">1.50</h4>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-purple-admin">
                            <span class="metric-title-admin">Pipeline value</span>
                            <h4 class="metric-value-admin">{{ number_format($pendingCodAmount / 1000000, 1) }}M</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-darkblue-admin">
                            <span class="metric-title-admin">Open deals</span>
                            <h4 class="metric-value-admin">{{ $pendingOrdersCount + $processingOrdersCount + $shippingOrdersCount }}</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-lightblue-admin">
                            <span class="metric-title-admin">Weighted value</span>
                            <h4 class="metric-value-admin">{{ number_format($avgOrderValue / 1000, 1) }}K</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="metric-card-admin metric-emerald-admin">
                            <span class="metric-title-admin">Avg open deal age</span>
                            <h4 class="metric-value-admin">{{ $customerCount }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Chart 1: Won deals (last 12 months) -->
                <div class="crm-panel-card-admin mb-3" style="height: 220px;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="crm-panel-title-admin m-0">Won deals (last 12 months)</h6>
                        <span class="text-xs text-muted"><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #0284c7;"></span>Closed value <span class="d-inline-block rounded-circle ms-2 me-1" style="width: 8px; height: 8px; background: #38bdf8;"></span>Won deals</span>
                    </div>
                    <div style="height: 160px; position: relative;">
                        <canvas id="chartWonDealsAdmin"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Deals projection (future 12 months) -->
                <div class="crm-panel-card-admin" style="height: 220px;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="crm-panel-title-admin m-0">Deals projection (future 12 months)</h6>
                        <span class="text-xs text-muted"><span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #0284c7;"></span>Projected value <span class="d-inline-block rounded-circle ms-2 me-1" style="width: 8px; height: 8px; background: #38bdf8;"></span>Deals due</span>
                    </div>
                    <div style="height: 160px; position: relative;">
                        <canvas id="chartDealsProjectionAdmin"></canvas>
                    </div>
                </div>
            </div>

            <!-- MIDDLE COLUMN (27%): 2 Donut Charts Stacked -->
            <div class="col-lg-3">
                <!-- Donut 1: Sales pipeline -->
                <div class="crm-panel-card-admin mb-3" style="height: 320px;">
                    <h6 class="crm-panel-title-admin mb-2">Sales pipeline</h6>
                    <div style="height: 250px; position: relative;" class="d-flex align-items-center justify-content-center">
                        <canvas id="chartSalesPipelineAdmin"></canvas>
                    </div>
                </div>

                <!-- Donut 2: Deal loss reasons -->
                <div class="crm-panel-card-admin" style="height: 320px;">
                    <h6 class="crm-panel-title-admin mb-2">Deal loss reasons</h6>
                    <div style="height: 250px; position: relative;" class="d-flex align-items-center justify-content-center">
                        <canvas id="chartDealLossReasonsAdmin"></canvas>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (18%): Filter Sidebar & Contact Support Card -->
            <div class="col-lg-2">
                <div class="crm-panel-card-admin d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3">
                            <label class="crm-filter-label-admin">Report date</label>
                            <input type="date" class="crm-filter-select-admin mb-1 text-xs" value="{{ date('Y-m-01') }}">
                            <input type="date" class="crm-filter-select-admin text-xs" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-2">
                            <label class="crm-filter-label-admin">Deal Owner</label>
                            <select class="crm-filter-select-admin">
                                <option>All</option>
                                <option>Kỹ sư Nguyễn Văn A</option>
                                <option>Nhân viên Trần B</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="crm-filter-label-admin">Deal Stage</label>
                            <select class="crm-filter-select-admin">
                                <option>All</option>
                                <option>Chờ duyệt</option>
                                <option>Đang đóng gói</option>
                                <option>Đang giao</option>
                                <option>Hoàn thành</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="crm-filter-label-admin">Pipeline</label>
                            <select class="crm-filter-select-admin">
                                <option>All</option>
                                <option>Thuốc trừ sâu & bệnh</option>
                                <option>Phân bón hữu cơ & NPK</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="crm-filter-label-admin">Deal Label</label>
                            <select class="crm-filter-select-admin">
                                <option>All</option>
                                <option>B2C Khách mua lẻ</option>
                                <option>B2B Đại lý lớn</option>
                            </select>
                        </div>
                    </div>

                    <!-- Support Card at bottom -->
                    <div class="p-2.5 bg-light rounded-3 border mt-2">
                        <div class="d-flex align-items-center gap-1.5 mb-1.5">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-bold" style="width: 24px; height: 24px; font-size: 10px;">
                                EC
                            </div>
                            <span class="fw-bold text-dark text-xs">Have questions?</span>
                        </div>
                        <a href="/admin/contacts" class="d-block text-xs text-primary fw-bold text-decoration-none mb-1" style="font-size: 11px;">Dashboard setup guide</a>
                        <a href="tel:0398037435" class="d-block text-xs text-primary fw-bold text-decoration-none" style="font-size: 11px;">Contact support</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Banner -->
        <div class="crm-footer-banner-admin">
            Connect 70+ data sources with Coupler.io & EcoFarm Agricultural CRM System
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart 1: Won deals
            const ctxWon = document.getElementById('chartWonDealsAdmin').getContext('2d');
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

            // Chart 2: Deals projection
            const ctxProj = document.getElementById('chartDealsProjectionAdmin').getContext('2d');
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

            // Chart 3: Sales pipeline
            const ctxPipeline = document.getElementById('chartSalesPipelineAdmin').getContext('2d');
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

            // Chart 4: Deal loss reasons
            const ctxLoss = document.getElementById('chartDealLossReasonsAdmin').getContext('2d');
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
</x-filament-panels::page>
