<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .eco-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .eco-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .dark .eco-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2);
        }

        .eco-banner-card {
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
            border-radius: 24px;
            padding: 22px 28px;
            color: #ffffff;
            box-shadow: 0 14px 35px -6px rgba(4, 120, 87, 0.35);
        }

        .eco-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
        }

        .eco-grid-65-35 {
            display: grid !important;
            grid-template-columns: 1.8fr 1fr !important;
            gap: 20px !important;
            align-items: stretch !important;
            width: 100% !important;
        }

        .eco-stat-card {
            border-radius: 18px;
            padding: 18px 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease;
        }

        .dark .eco-stat-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .eco-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        @media (max-width: 1280px) {
            .eco-grid-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .eco-grid-65-35 {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .eco-grid-4 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="eco-dashboard space-y-6">

        <!-- 🌟 1. EXECUTIVE COMMAND BANNER HEADER -->
        <div class="eco-banner-card flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-xs font-extrabold mb-1.5">
                    <i class="fa-solid fa-wheat-awn text-amber-300"></i>
                    <span>Hệ Thống Quản Lý & Vận Hành Bãi Kho EcoFarm</span>
                </div>
                <h2 class="text-2xl font-black tracking-tight">Trung Tâm Báo Cáo Doanh Số & Kho Bãi</h2>
                <p class="text-xs font-medium text-emerald-100 mt-0.5">Giám sát thời gian thực chuỗi vật tư, bến bãi & giao dịch nông nghiệp Mekong</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="/" class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-house text-emerald-600"></i>
                    <span>Xem trang chủ EcoFarm</span>
                </a>
            </div>
        </div>

        <!-- 🌟 2. TOP 4 SCORECARD METRIC CARDS -->
        <div class="eco-grid-4">
            <!-- Card 1: Revenue -->
            <div class="eco-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tổng Doanh Thu</span>
                    <div class="eco-icon-box bg-emerald-50 text-emerald-600">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-600 flex items-center justify-between">
                        <span>AOV: {{ number_format($avgOrderValue, 0, ',', '.') }}đ</span>
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-extrabold">&uarr; 100%</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Orders -->
            <div class="eco-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sản Lượng Đơn Hàng</span>
                    <div class="eco-icon-box bg-blue-50 text-blue-600">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($ordersCount) }} đơn hàng</div>
                    <div class="mt-2 text-[11px] font-bold text-blue-600 flex items-center justify-between">
                        <span>{{ $completedCount }} hoàn thành · {{ $processingCount }} đang giao</span>
                        <span class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-extrabold">{{ $completionRate }}% chốt</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Inventory Products -->
            <div class="eco-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kho Vật Tư Nông Nghiệp</span>
                    <div class="eco-icon-box bg-amber-50 text-amber-600">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($productsCount) }} mặt hàng</div>
                    <div class="mt-2 text-[11px] font-bold text-amber-600 flex items-center justify-between">
                        <span>Tồn kho an toàn</span>
                        <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-extrabold">{{ count($lowStockProducts) }} sắp hết</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Farmers Base -->
            <div class="eco-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bà Con Nông Dân</span>
                    <div class="eco-icon-box bg-indigo-50 text-indigo-600">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($usersCount) }} nhà vườn</div>
                    <div class="mt-2 text-[11px] font-bold text-indigo-600 flex items-center justify-between">
                        <span>Đồng bằng sông Cửu Long</span>
                        <span class="px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-800 font-extrabold">&uarr; Tương tác tốt</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 3. TOP ROW (Biểu đồ doanh thu 6 tháng & Tỷ lệ trạng thái đơn hàng) -->
        <div class="eco-grid-65-35">
            <!-- Widget 1: Biểu đồ doanh thu hoàn tất (6 tháng qua) -->
            <div class="eco-card">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                            Biểu đồ doanh thu hoàn tất (6 tháng qua)
                        </h3>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 text-xs font-bold border border-slate-200 shrink-0">
                            6 tháng qua v
                        </span>
                    </div>

                    <div style="height: 250px; width: 100%; position: relative;">
                        <canvas id="ecoRevenueLineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Tỷ lệ trạng thái đơn hàng (Tất cả thời gian) -->
            <div class="eco-card">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                                Tỷ lệ trạng thái đơn hàng (Tất cả thời gian)
                            </h3>
                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 text-[11px] font-bold border border-slate-200 shrink-0">
                                Tất cả thời gian v
                            </span>
                        </div>

                        <div style="height: 200px; width: 100%; position: relative; display: flex; align-items: center; justify-content: center;">
                            <canvas id="ecoStatusDoughnutChart"></canvas>
                        </div>
                    </div>

                    <!-- Status Legend matching exact colors -->
                    <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] font-bold text-slate-600 pt-2 border-t border-slate-100 dark:border-slate-800 mt-2">
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-amber-500"></span> Chờ duyệt</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-sky-400"></span> Đóng gói</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span> Đang giao</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-500"></span> Hoàn tất</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-rose-500"></span> Đã hủy</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 4. BOTTOM ROW (Đơn hàng mới nhận gần đây & Tỷ lệ doanh số theo Ngành hàng) -->
        <div class="eco-grid-65-35">
            <!-- Widget 3: Đơn hàng mới nhận gần đây -->
            <div class="eco-card">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                            Đơn hàng mới nhận gần đây
                        </h3>
                        <a href="/admin/orders" class="text-xs font-bold text-emerald-600 hover:underline shrink-0">Quản lý tất cả &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-black uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 text-[10px]">
                                <tr>
                                    <th class="py-2.5 px-3">MÃ ĐƠN v</th>
                                    <th class="py-2.5 px-3">KHÁCH HÀNG</th>
                                    <th class="py-2.5 px-3">TỔNG TIỀN</th>
                                    <th class="py-2.5 px-3 text-center">TRẠNG THÁI</th>
                                    <th class="py-2.5 px-3">THỜI GIAN</th>
                                    <th class="py-2.5 px-3 text-center">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-all">
                                        <td class="py-2 px-3 font-black text-slate-900 dark:text-slate-100">#{{ $ord->id }}</td>
                                        <td class="py-2 px-3 font-bold text-slate-800 dark:text-slate-200">{{ $ord->customer_name }}</td>
                                        <td class="py-2 px-3 font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }} VND</td>
                                        <td class="py-2 px-3 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Hoàn tất</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Đóng gói</span>
                                            @elseif($ord->status === 'pending')
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Chờ duyệt</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-3 text-slate-500 text-[11px] font-semibold">
                                            {{ $ord->created_at ? $ord->created_at->format('H:i d/m/Y') : '12:29 09/08/2026' }}
                                        </td>
                                        <td class="py-2 px-3 text-center">
                                            <a href="/admin/orders/{{ $ord->id }}" class="text-emerald-600 font-extrabold hover:underline inline-flex items-center gap-1 text-[11px]">
                                                <i class="fa-solid fa-eye"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-slate-400">Chưa có đơn hàng phát sinh...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Widget 4: Tỷ lệ doanh số theo Ngành hàng -->
            <div class="eco-card">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100 truncate">
                                Tỷ lệ doanh số theo Ngành hàng
                            </h3>
                            <i class="fa-solid fa-ellipsis text-slate-300"></i>
                        </div>

                        <div style="height: 200px; width: 100%; position: relative; display: flex; align-items: center; justify-content: center;">
                            <canvas id="ecoCategoryPolarChart"></canvas>
                        </div>
                    </div>

                    <!-- Category Color Legend -->
                    <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] font-bold text-slate-600 pt-2 border-t border-slate-100 dark:border-slate-800 mt-2">
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-500"></span> Thuốc Trừ Sâu & Bệnh</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span> Hạt Giống</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-amber-500"></span> Phân Bón Hữu Cơ & NPK</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            // 1. Biểu đồ doanh thu hoàn tất (6 tháng qua) - Line Area Chart
            const ctxRev = document.getElementById('ecoRevenueLineChart').getContext('2d');
            const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 220);
            gradientRev.addColorStop(0, 'rgba(5, 150, 105, 0.28)');
            gradientRev.addColorStop(1, 'rgba(5, 150, 105, 0.02)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: @json($chartRevenueRaw),
                        borderColor: '#059669',
                        borderWidth: 3.5,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#059669',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { top: 25, right: 20, left: 10, bottom: 10 }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, color: '#475569' }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Doanh thu (VND): ' + new Intl.NumberFormat('vi-VN').format(context.raw) + 'đ';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#64748B' } },
                        y: {
                            grace: '15%',
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#64748B',
                                callback: function(val) { return new Intl.NumberFormat('vi-VN').format(val); }
                            }
                        }
                    }
                }
            });

            // 2. Tỷ lệ trạng thái đơn hàng (Tất cả thời gian) - Doughnut Donut Chart
            const ctxDoughnut = document.getElementById('ecoStatusDoughnutChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Chờ duyệt', 'Đóng gói', 'Đang giao', 'Hoàn tất', 'Đã hủy'],
                    datasets: [{
                        data: [
                            {{ max(1, $pendingOrdersCount) }},
                            {{ max(1, $processingOrdersCount) }},
                            {{ max(1, $shippingOrdersCount) }},
                            {{ max(1, $completedCount) }},
                            {{ max(1, $cancelledCount) }}
                        ],
                        backgroundColor: ['#f59e0b', '#38bdf8', '#6366f1', '#10b981', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.3,
                    layout: {
                        padding: { top: 15, bottom: 15, left: 15, right: 15 }
                    },
                    cutout: '65%',
                    plugins: { legend: { display: false } }
                }
            });

            // 4. Tỷ lệ doanh số theo Ngành hàng - Polar Area / Radar Radial Chart
            const ctxPolar = document.getElementById('ecoCategoryPolarChart').getContext('2d');
            new Chart(ctxPolar, {
                type: 'polarArea',
                data: {
                    labels: @json($categorySales->pluck('category_name')),
                    datasets: [{
                        data: @json($categorySales->pluck('total_revenue')),
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.75)',
                            'rgba(99, 102, 241, 0.75)',
                            'rgba(245, 158, 11, 0.75)',
                            'rgba(56, 189, 248, 0.75)',
                            'rgba(244, 114, 182, 0.75)'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.3,
                    layout: {
                        padding: { top: 15, bottom: 15, left: 15, right: 15 }
                    },
                    plugins: { legend: { display: false } },
                    scales: {
                        r: { ticks: { display: false }, grid: { color: 'rgba(0,0,0,0.05)' } }
                    }
                }
            });
        });
    </script>
</x-filament-panels::page>
