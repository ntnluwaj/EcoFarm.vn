<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .eco-custom-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .eco-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
        }

        .dark .eco-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
        }

        .eco-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
        }

        .eco-grid-2-main {
            display: grid !important;
            grid-template-columns: 1.8fr 1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .eco-stat-card {
            border-radius: 14px;
            padding: 16px 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dark .eco-stat-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .eco-select-dropdown {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
        }

        @media (max-width: 1280px) {
            .eco-grid-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .eco-grid-2-main {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .eco-grid-4 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="eco-custom-dashboard space-y-6">

        <!-- 🌟 1. TOP SUMMARY METRIC CARDS (4 EQUAL CARDS) -->
        <div class="eco-grid-4">
            <!-- Card 1: Total Products -->
            <div class="eco-stat-card">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Sản Phẩm Vật Tư</div>
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ number_format($productsCount) }} mặt hàng</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>

            <!-- Card 2: Total Orders -->
            <div class="eco-stat-card">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Tổng Đơn Hàng</div>
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ number_format($ordersCount) }} đơn</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>

            <!-- Card 3: Completed Orders -->
            <div class="eco-stat-card">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Đơn Hoàn Tất</div>
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ number_format($completedCount) }} đơn</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <!-- Card 4: Total Revenue -->
            <div class="eco-stat-card">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Tổng Doanh Thu</div>
                    <div class="text-xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($totalRevenue, 0, ',', '.') }} VND</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>

        <!-- 🌟 2. TOP ROW (LEFT 65%: Biểu đồ doanh thu hoàn tất | RIGHT 35%: Tỷ lệ trạng thái đơn hàng) -->
        <div class="eco-grid-2-main">
            <!-- Box 1: Biểu đồ doanh thu hoàn tất (6 tháng qua) -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Biểu đồ doanh thu hoàn tất (6 tháng qua)</h3>
                        <select class="eco-select-dropdown">
                            <option>6 tháng qua</option>
                            <option>3 tháng qua</option>
                            <option>Năm nay</option>
                        </select>
                    </div>

                    <div class="relative h-64 w-full">
                        <canvas id="ecoRevenueLineChart"></canvas>
                    </div>
                </div>

                <!-- Custom Legend Below Chart -->
                <div class="flex items-center justify-center gap-2 text-xs font-bold text-slate-600 mt-3">
                    <span class="w-3 h-3 rounded-xs bg-emerald-600"></span>
                    <span>Doanh thu (VND)</span>
                </div>
            </div>

            <!-- Box 2: Tỷ lệ trạng thái đơn hàng (Tất cả thời gian) -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Tỷ lệ trạng thái đơn hàng (Tất cả thời gian)</h3>
                        <select class="eco-select-dropdown">
                            <option>Tất cả thời gian</option>
                            <option>Tháng này</option>
                            <option>Tuần này</option>
                        </select>
                    </div>

                    <div class="relative flex items-center justify-center h-56 my-2">
                        <canvas id="ecoOrderStatusDonut"></canvas>
                    </div>
                </div>

                <!-- Sub-legend below donut ring chart -->
                <div class="flex flex-wrap items-center justify-center gap-3 text-[11px] font-bold text-slate-600 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-amber-500"></span> Chờ duyệt</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-cyan-500"></span> Đóng gói</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-blue-500"></span> Đang giao</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-emerald-500"></span> Hoàn tất</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-rose-500"></span> Đã hủy</span>
                </div>
            </div>
        </div>

        <!-- 🌟 3. BOTTOM ROW (LEFT 65%: Đơn hàng mới nhận gần đây | RIGHT 35%: Tỷ lệ doanh số theo Ngành hàng) -->
        <div class="eco-grid-2-main">
            <!-- Box 3: Đơn hàng mới nhận gần đây (Recent Orders Table) -->
            <div class="eco-card flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Đơn hàng mới nhận gần đây</h3>
                        <a href="/admin/orders" class="text-xs font-bold text-emerald-600 hover:underline">Xem tất cả &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-black border-b border-slate-100 dark:border-slate-800 text-[11px]">
                                <tr>
                                    <th class="py-3 px-3">Mã đơn <i class="fa-solid fa-chevron-down text-[9px] text-slate-400"></i></th>
                                    <th class="py-3 px-3">Khách hàng</th>
                                    <th class="py-3 px-3">Tổng tiền</th>
                                    <th class="py-3 px-3 text-center">Trạng thái</th>
                                    <th class="py-3 px-3">Thời gian</th>
                                    <th class="py-3 px-3 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-all">
                                        <td class="py-3 px-3 font-bold text-slate-900 dark:text-slate-100">#{{ $ord->id }}</td>
                                        <td class="py-3 px-3 font-bold text-slate-800 dark:text-slate-200">{{ $ord->customer_name }}</td>
                                        <td class="py-3 px-3 font-extrabold text-slate-900 dark:text-slate-100">{{ number_format($ord->total_amount, 0, ',', '.') }} VND</td>
                                        <td class="py-3 px-3 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Hoàn tất</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300">Đóng gói</span>
                                            @elseif($ord->status === 'pending')
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Chờ duyệt</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-500 font-medium text-[11px]">{{ $ord->created_at ? $ord->created_at->format('H:i d/m/Y') : 'Vừa xong' }}</td>
                                        <td class="py-3 px-3 text-center">
                                            <a href="/admin/orders/{{ $ord->id }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md border border-emerald-600 text-emerald-600 hover:bg-emerald-50 font-bold text-[11px] transition-all">
                                                <i class="fa-regular fa-eye"></i> Chi tiết
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

            <!-- Box 4: Tỷ lệ doanh số theo Ngành hàng (Polar Area / Donut Chart) -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Tỷ lệ doanh số theo Ngành hàng</h3>
                        <i class="fa-solid fa-ellipsis text-slate-400"></i>
                    </div>

                    <div class="relative flex items-center justify-center h-56 my-2">
                        <canvas id="ecoCategoryPolarChart"></canvas>
                    </div>
                </div>

                <!-- Sub-legend below chart -->
                <div class="flex flex-wrap items-center justify-center gap-3 text-[11px] font-bold text-slate-600 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-emerald-500"></span> Thuốc Trừ Sâu & Bệnh</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-blue-500"></span> Hạt Giống</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-xs bg-amber-500"></span> Phân Bón Hữu Cơ & NPK</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            const chartMonthsFull = @json($chartMonths).map(m => m.replace('Thg ', 'Tháng '));
            const chartRevenueRaw = @json($chartRevenueRaw);
            const chartRevenueFormatted = @json($chartRevenueFormatted);

            // 1. Line Chart: Biểu đồ doanh thu hoàn tất (6 tháng qua)
            const ctxRev = document.getElementById('ecoRevenueLineChart').getContext('2d');
            const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 220);
            gradientRev.addColorStop(0, 'rgba(22, 163, 74, 0.2)');
            gradientRev.addColorStop(1, 'rgba(22, 163, 74, 0.01)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: chartMonthsFull,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: chartRevenueRaw,
                        borderColor: '#15803d',
                        borderWidth: 2.5,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.2,
                        pointBackgroundColor: '#15803d',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ' Doanh thu: ' + (chartRevenueFormatted[ctx.dataIndex] || (ctx.raw.toLocaleString('vi-VN') + ' VND'));
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' } },
                        y: {
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#64748b',
                                callback: function(val) { return val.toLocaleString('vi-VN'); }
                            }
                        }
                    }
                }
            });

            // 2. Doughnut Ring Chart: Tỷ lệ trạng thái đơn hàng (Tất cả thời gian)
            const ctxStatus = document.getElementById('ecoOrderStatusDonut').getContext('2d');
            new Chart(ctxStatus, {
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
                        backgroundColor: ['#eab308', '#06b6d4', '#3b82f6', '#22c55e', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: { display: false } }
                }
            });

            // 3. Polar Area / Donut Chart: Tỷ lệ doanh số theo Ngành hàng
            const ctxCategory = document.getElementById('ecoCategoryPolarChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'polarArea',
                data: {
                    labels: @json($categorySales->pluck('category_name')),
                    datasets: [{
                        data: @json($categorySales->pluck('total_revenue')),
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.85)',
                            'rgba(59, 130, 246, 0.85)',
                            'rgba(245, 158, 11, 0.85)',
                            'rgba(168, 85, 247, 0.85)',
                            'rgba(20, 184, 166, 0.85)'
                        ],
                        borderWidth: 1.5,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { r: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { display: false } } }
                }
            });
        });
    </script>
</x-filament-panels::page>
