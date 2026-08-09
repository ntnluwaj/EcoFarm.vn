<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .eco-academic-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .eco-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
        }

        .dark .eco-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2);
        }

        .eco-banner-card {
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
            border-radius: 24px;
            padding: 26px 32px;
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
            grid-template-columns: 2.1fr 1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .eco-grid-45-55 {
            display: grid !important;
            grid-template-columns: 1fr 1.3fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .eco-stat-card {
            border-radius: 18px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dark .eco-stat-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .eco-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.06);
        }

        .eco-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        @media (max-width: 1280px) {
            .eco-grid-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .eco-grid-65-35,
            .eco-grid-45-55 {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .eco-grid-4 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="eco-academic-dashboard space-y-6">

        <!-- 🌟 1. EXECUTIVE COMMAND BANNER HEADER -->
        <div class="eco-banner-card flex flex-wrap items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-xs font-extrabold mb-2">
                    <i class="fa-solid fa-wheat-awn text-amber-300"></i>
                    <span>Hệ Thống Quản Lý & Vận Hành Bãi Kho EcoFarm</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">Trung Tâm Báo Cáo Hiệu Suất & Doanh Số</h2>
                <p class="text-xs sm:text-sm font-medium text-emerald-100 mt-1">Giám sát thời gian thực toàn bộ chuỗi vật tư, kho bãi và tiến độ đơn hàng nông nghiệp Mekong</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="/admin/stocks" class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-emerald-600"></i>
                    <span>Quản lý kho bãi</span>
                </a>
                <a href="/" class="px-4 py-2.5 rounded-xl bg-emerald-900/60 hover:bg-emerald-900 text-white font-extrabold text-xs backdrop-blur-md shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-house"></i>
                    <span>Xem trang chủ</span>
                </a>
            </div>
        </div>

        <!-- 🌟 2. BALANCED SCORECARD METRIC CARDS (ROW OF 4 EQUAL CARDS) -->
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

        <!-- 🌟 3. MIDDLE SECTION (COMBO CHART & FULFILLMENT PIPELINE) -->
        <div class="eco-grid-65-35">
            <!-- Left 65%: Combo Mixed Bar + Line Chart (Revenue & Order Trend) -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <!-- Header -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 flex items-center gap-2">
                                <i class="fa-solid fa-chart-column text-emerald-600"></i>
                                Biến Động Doanh Thu & Xu Hướng Sản Lượng Đơn Chốt
                            </h3>
                            <p class="text-xs text-slate-500">Mô hình biểu đồ kết hợp (Cột Doanh Thu + Đường Xu Hướng Đơn)</p>
                        </div>
                        <div class="flex items-center gap-4 text-xs font-bold text-slate-500">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-600"></span> Cột Doanh Thu (Triệu VNĐ)</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Đường Sản Lượng Đơn</span>
                        </div>
                    </div>

                    <!-- Canvas -->
                    <div class="relative h-64 w-full mb-6">
                        <canvas id="ecoAcademicComboChart"></canvas>
                    </div>
                </div>

                <!-- Bottom 4 Sub-metrics Row -->
                <div class="eco-grid-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Ví Doanh Thu</div>
                        <div class="text-xs font-black text-emerald-600 mt-0.5">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Giá Trị TB Đơn</div>
                        <div class="text-xs font-black text-slate-900 dark:text-slate-100 mt-0.5">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</div>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Đơn Đang Giao</div>
                        <div class="text-xs font-black text-blue-600 mt-0.5">{{ $processingCount }} đơn</div>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Đơn Đã Hủy</div>
                        <div class="text-xs font-black text-rose-600 mt-0.5">{{ $cancelledCount }} đơn</div>
                    </div>
                </div>
            </div>

            <!-- Right 35%: Logistics Fulfillment Pipeline & Category Mix -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-truck-ramp-box text-emerald-600"></i>
                            Chu Chuỗi Tiến Độ Kho Bãi
                        </h3>
                        <span class="text-xs font-bold text-slate-400">Tổng: {{ $totalStatusCount }} đơn</span>
                    </div>

                    <!-- Funnel Status Pipeline Bars -->
                    <div class="space-y-3 mb-6">
                        <div class="p-2.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <span class="text-xs font-bold text-amber-900 dark:text-amber-200">Chờ duyệt xuất kho</span>
                            </div>
                            <span class="text-xs font-black text-amber-700 dark:text-amber-300">{{ $pendingOrdersCount }} đơn</span>
                        </div>

                        <div class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                <span class="text-xs font-bold text-blue-900 dark:text-blue-200">Đang đóng gói & trung chuyển</span>
                            </div>
                            <span class="text-xs font-black text-blue-700 dark:text-blue-300">{{ $processingOrdersCount + $shippingOrdersCount }} đơn</span>
                        </div>

                        <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">Đã hoàn thành & ký biên nhận</span>
                            </div>
                            <span class="text-xs font-black text-emerald-700 dark:text-emerald-300">{{ $completedCount }} đơn</span>
                        </div>

                        <div class="p-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                <span class="text-xs font-bold text-rose-900 dark:text-rose-200">Đơn hàng bị hủy</span>
                            </div>
                            <span class="text-xs font-black text-rose-700 dark:text-rose-300">{{ $cancelledCount }} đơn</span>
                        </div>
                    </div>

                    <!-- Category Sales Breakdown Bars -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-3 flex items-center justify-between">
                            <span>Top Danh Mục Bán Chạy Vụ Này</span>
                            <i class="fa-solid fa-fire text-amber-500"></i>
                        </div>

                        <div class="space-y-2.5">
                            @forelse($categorySales as $cat)
                                @php
                                    $catPct = $totalRevenue > 0 ? round(($cat->total_revenue / $totalRevenue) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">
                                        <span class="truncate max-w-[150px] text-slate-900 dark:text-slate-100">{{ $cat->category_name }}</span>
                                        <span class="text-emerald-600 font-black">{{ number_format($cat->total_revenue, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400" style="width: {{ max(10, min(100, $catPct)) }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-xs text-slate-400 py-2">Đang cập nhật danh mục...</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 4. LOWER SECTION: LOW STOCK WARNINGS & RECENT ORDERS TABLE (45% + 55%) -->
        <div class="eco-grid-45-55">
            <!-- Left 45%: Low Stock Warnings & Inventory Status -->
            <div class="eco-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                            Cảnh Báo Tồn Kho & Nhập Hàng
                        </h3>
                        <a href="/admin/stocks" class="text-xs font-bold text-emerald-600 hover:underline">Xem kho bãi &rarr;</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($lowStockProducts as $prod)
                            <div class="p-3 rounded-xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200/70 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-800 shrink-0 flex items-center justify-center font-bold text-xs">
                                        <i class="fa-solid fa-box text-sm"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="text-xs font-extrabold text-slate-900 dark:text-slate-100 truncate">{{ $prod->name }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $prod->category->name ?? 'Vật tư' }} · {{ $prod->packaging ?? $prod->unit }}</div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-200 text-amber-900">Tồn: {{ $prod->stock }} {{ $prod->unit }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-bold text-center">
                                <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i>
                                Tồn kho tất cả mặt hàng đang ở mức an toàn
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right 55%: Recent Orders Table -->
            <div class="eco-card flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Đơn hàng phát sinh mới nhất</h3>
                            <p class="text-xs text-slate-500">Lịch sử giao dịch bãi kho mới phát sinh</p>
                        </div>
                        <a href="/admin/orders" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all">Quản lý đơn hàng &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-black uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 text-[10px]">
                                <tr>
                                    <th class="py-2.5 px-3">MÃ ĐƠN</th>
                                    <th class="py-2.5 px-3">KHÁCH HÀNG</th>
                                    <th class="py-2.5 px-3">ĐỊA CHỈ GIAO HÀNG</th>
                                    <th class="py-2.5 px-3 text-right">TỔNG TIỀN</th>
                                    <th class="py-2.5 px-3 text-center">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-all">
                                        <td class="py-2.5 px-3 font-black text-slate-900 dark:text-slate-100">#{{ $ord->id }}</td>
                                        <td class="py-2.5 px-3 font-bold text-slate-800 dark:text-slate-200">{{ $ord->customer_name }}</td>
                                        <td class="py-2.5 px-3 max-w-[180px] truncate text-slate-500">{{ $ord->shipping_address }}</td>
                                        <td class="py-2.5 px-3 text-right font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }}đ</td>
                                        <td class="py-2.5 px-3 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Hoàn thành</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Đang xử lý</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Đã hủy</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-slate-400">Chưa có đơn hàng phát sinh...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            const chartRevenueRaw = @json($chartRevenueRaw);
            const chartRevenueFormatted = @json($chartRevenueFormatted);

            // 1. Academic Combo Mixed Chart
            const ctxCombo = document.getElementById('ecoAcademicComboChart').getContext('2d');
            const gradientBar = ctxCombo.createLinearGradient(0, 0, 0, 240);
            gradientBar.addColorStop(0, '#059669');
            gradientBar.addColorStop(1, '#6ee7b7');

            new Chart(ctxCombo, {
                type: 'bar',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Doanh thu (Triệu VNĐ)',
                            data: @json($chartRevenueData),
                            backgroundColor: gradientBar,
                            borderRadius: 8,
                            barThickness: 26,
                            yAxisID: 'y'
                        },
                        {
                            type: 'line',
                            label: 'Số đơn chốt',
                            data: @json($chartSalesData),
                            borderColor: '#F59E0B',
                            borderWidth: 3.5,
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: '#F59E0B',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.92)',
                            titleFont: { family: 'Plus Jakarta Sans', size: 13, weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    const index = context.dataIndex;
                                    if (context.datasetIndex === 0) {
                                        return ' Doanh thu cột: ' + chartRevenueFormatted[index] + ' (' + context.raw + ' Triệu)';
                                    } else {
                                        return ' Đường sản lượng: ' + context.raw + ' đơn hoàn thành';
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, color: '#64748B' } },
                        y: {
                            type: 'linear', display: true, position: 'left',
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#64748B', callback: function(val) { return val + ' Tr'; } }
                        },
                        y1: {
                            type: 'linear', display: true, position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#D97706', callback: function(val) { return val + ' đơn'; } }
                        }
                    }
                }
            });
        });
    </script>
</x-filament-panels::page>
