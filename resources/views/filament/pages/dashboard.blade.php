<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <style>
        .eco-dashboard-wrap {
            padding-top: 4px;
        }

        .eco-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 18px !important;
            width: 100% !important;
        }

        .eco-grid-2-1 {
            display: grid !important;
            grid-template-columns: 2.1fr 1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .eco-grid-1-2 {
            display: grid !important;
            grid-template-columns: 1fr 2.1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .eco-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .dark .eco-card {
            background: #111827;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
        }

        .eco-stat-card {
            border-radius: 20px;
            padding: 22px 20px;
            color: #ffffff;
            box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 108px;
        }

        .eco-icon-circle {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .eco-banner-card {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 24px;
            padding: 24px 30px;
            color: #ffffff;
            box-shadow: 0 12px 30px -5px rgba(16, 185, 129, 0.3);
            margin-bottom: 24px;
        }

        @media (max-width: 1280px) {
            .eco-grid-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 1024px) {
            .eco-grid-2-1,
            .eco-grid-1-2 {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .eco-grid-4 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="eco-dashboard-wrap">
        <!-- 🌟 HEADER HERO COMMAND CENTER BANNER -->
        <div class="eco-banner-card flex flex-wrap items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-xs font-bold mb-2">
                    <i class="fa-solid fa-wheat-awn text-amber-300"></i>
                    <span>Hệ Thống Quản Trị Vật Tư Nông Nghiệp EcoFarm</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">Trung Tâm Vận Hành Kho Bãi & Doanh Số</h2>
                <p class="text-xs sm:text-sm font-medium text-emerald-100 mt-1">Giám sát thời gian thực toàn bộ chuỗi vật tư, kho bãi và tiến độ đơn hàng nông nghiệp</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="/admin/stock-report-page" class="px-4 py-2.5 rounded-xl bg-white text-emerald-800 hover:bg-emerald-50 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-600"></i>
                    <span>Báo cáo bãi kho</span>
                </a>
                <a href="/" class="px-4 py-2.5 rounded-xl bg-emerald-800/60 hover:bg-emerald-800 text-white font-extrabold text-xs backdrop-blur-md shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-house"></i>
                    <span>Xem trang chủ</span>
                </a>
            </div>
        </div>

        <!-- 🌟 TOP 4 EXECUTIVE VIBRANT STAT CARDS (ROW OF 4 SIDE-BY-SIDE) -->
        <div class="eco-grid-4 mb-6">
            <!-- Card 1: Purple Gradient (Revenue) -->
            <div class="eco-stat-card" style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);">
                <div class="eco-icon-circle">
                    <i class="fa-solid fa-sack-dollar text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    <div class="text-xs font-semibold opacity-90">Tổng doanh thu thực tế</div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 90px;"></i>
                </div>
            </div>

            <!-- Card 2: Vibrant Blue Gradient (Orders) -->
            <div class="eco-stat-card" style="background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);">
                <div class="eco-icon-circle">
                    <i class="fa-solid fa-cart-shopping text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight">{{ number_format($ordersCount) }} đơn</div>
                    <div class="text-xs font-semibold opacity-90">{{ $completedCount }} hoàn thành · {{ $processingCount }} đang giao</div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-boxes-packing" style="font-size: 90px;"></i>
                </div>
            </div>

            <!-- Card 3: Emerald Gradient (Inventory Products) -->
            <div class="eco-stat-card" style="background: linear-gradient(135deg, #059669 0%, #34d399 100%);">
                <div class="eco-icon-circle">
                    <i class="fa-solid fa-box-archive text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight">{{ number_format($productsCount) }} mặt hàng</div>
                    <div class="text-xs font-semibold opacity-90">Vật tư nông nghiệp sẵn có</div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-cubes" style="font-size: 90px;"></i>
                </div>
            </div>

            <!-- Card 4: Warm Amber Gradient (Farmers) -->
            <div class="eco-stat-card" style="background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%);">
                <div class="eco-icon-circle">
                    <i class="fa-solid fa-users text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight">{{ number_format($usersCount) }} bà con</div>
                    <div class="text-xs font-semibold opacity-90">Tương tác mua bán</div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-handshake" style="font-size: 90px;"></i>
                </div>
            </div>
        </div>

        <!-- 🌟 MIDDLE SECTION (COMBO CHART & ANALYTICS) -->
        <div class="eco-grid-2-1 mb-6">
            <!-- Left Combo Bar + Line Chart Card -->
            <div class="eco-card p-6 flex flex-col justify-between">
                <div>
                    <!-- Header Controls -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-chart-column text-purple-600"></i>
                                Tăng Trưởng Doanh Số & Xu Hướng Sản Lượng Đơn
                            </h3>
                            <p class="text-xs text-gray-500">Mô hình biểu đồ kết hợp (Cột Doanh Thu + Đường Sản Lượng Đơn Chốt)</p>
                        </div>
                        <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-purple-600"></span> Cột Doanh Thu (Triệu VNĐ)</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Đường Sản Lượng Đơn</span>
                        </div>
                    </div>

                    <!-- Chart Grid -->
                    <div class="relative h-64 w-full mb-6">
                        <canvas id="revenueComboChart"></canvas>
                    </div>
                </div>

                <!-- Bottom 4 Equal Metric Cards -->
                <div class="eco-grid-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-purple-50/60 dark:bg-purple-950/30 border border-purple-100/80 dark:border-purple-900/40">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-600 text-white shadow-sm">
                            <i class="fa-solid fa-wallet text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-purple-700 dark:text-purple-300 font-extrabold uppercase">Doanh Thu Thu Về</div>
                            <div class="text-xs font-black text-gray-900 dark:text-gray-100">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-blue-50/60 dark:bg-blue-950/30 border border-blue-100/80 dark:border-blue-900/40">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                            <i class="fa-solid fa-calculator text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-blue-700 dark:text-blue-300 font-extrabold uppercase">Giá Trị TB Đơn</div>
                            <div class="text-xs font-black text-gray-900 dark:text-gray-100">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-100/80 dark:border-emerald-900/40">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
                            <i class="fa-solid fa-boxes-stacked text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-emerald-700 dark:text-emerald-300 font-extrabold uppercase">Mặt Hàng Vật Tư</div>
                            <div class="text-xs font-black text-gray-900 dark:text-gray-100">{{ $productsCount }} sản phẩm</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-100/80 dark:border-amber-900/40">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-600 text-white shadow-sm">
                            <i class="fa-solid fa-award text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] text-amber-700 dark:text-amber-300 font-extrabold uppercase">Tỷ Lệ Hoàn Thành</div>
                            <div class="text-xs font-black text-gray-900 dark:text-gray-100">{{ $completedPercent }}% thành công</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Analytics Donut & Category Sales Visualizer -->
            <div class="eco-card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-purple-600"></i>
                            Tỷ Lệ Giao Hàng & Danh Mục
                        </h3>
                        <span class="text-xs font-bold text-gray-400">Tong: {{ $totalStatusCount }} don</span>
                    </div>

                    <!-- Centered Ring Chart -->
                    <div class="relative flex items-center justify-center my-3 h-44">
                        <canvas id="orderStatusDoughnutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-3xl font-black text-purple-600 dark:text-purple-400 tracking-tight">{{ $completedPercent }}%</span>
                            <span class="text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Hoàn thành</span>
                        </div>
                    </div>

                    <!-- Category Sales Distribution Progress Bars -->
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 flex items-center justify-between">
                            <span>Top danh mục bán chạy vụ này</span>
                            <i class="fa-solid fa-fire text-amber-500 text-xs"></i>
                        </div>
                        <div class="space-y-2.5">
                            @forelse($categorySales as $cat)
                                @php
                                    $catPct = $totalRevenue > 0 ? round(($cat->total_revenue / $totalRevenue) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">
                                        <span class="truncate max-w-[140px] font-bold text-gray-900 dark:text-gray-100">{{ $cat->category_name }}</span>
                                        <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($cat->total_revenue, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-purple-600 to-indigo-500" style="width: {{ max(12, min(100, $catPct)) }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-[11px] text-gray-400 py-2">Đang thống kê dữ liệu danh mục...</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Status Legends -->
                <div class="grid grid-cols-3 gap-1.5 pt-3 border-t border-gray-100 dark:border-gray-800 text-center">
                    <div class="p-1.5 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-[10px]">
                        <span class="font-bold text-purple-700 dark:text-purple-300">Hoàn thành</span>
                        <div class="font-black text-gray-900 dark:text-gray-100">{{ $completedCount }} đơn ({{ $completedPercent }}%)</div>
                    </div>
                    <div class="p-1.5 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-[10px]">
                        <span class="font-bold text-amber-700 dark:text-amber-300">Đang giao</span>
                        <div class="font-black text-gray-900 dark:text-gray-100">{{ $processingCount }} đơn ({{ $processingPercent }}%)</div>
                    </div>
                    <div class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-[10px]">
                        <span class="font-bold text-rose-700 dark:text-rose-300">Đã hủy</span>
                        <div class="font-black text-gray-900 dark:text-gray-100">{{ $cancelledCount }} đơn ({{ $cancelledPercent }}%)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 BOTTOM SECTION (RECENT ACTIVITIES & ORDERS TABLE) -->
        <div class="eco-grid-1-2">
            <!-- Left 1/3 Recent Activities Timeline -->
            <div class="eco-card p-6">
                <h3 class="text-base font-extrabold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-purple-600"></i>
                    Hoạt động hệ thống mới nhất
                </h3>

                <div class="space-y-6">
                    @forelse($activities as $act)
                        <div class="flex items-start gap-3">
                            <div class="text-[11px] font-bold text-gray-400 whitespace-nowrap pt-1 w-20">
                                {{ $act['time'] }}
                            </div>
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $act['bg'] }}">
                                <i class="{{ $act['icon'] }} text-xs"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-xs font-extrabold text-gray-900 dark:text-gray-100 truncate">{{ $act['title'] }}</div>
                                <div class="text-[11px] text-gray-500 truncate">{{ $act['actor'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-xs text-gray-500 py-6">Chưa có nhật ký hoạt động gần đây.</div>
                    @endforelse
                </div>
            </div>

            <!-- Right 2/3 Order Status Table -->
            <div class="eco-card p-6 flex flex-col justify-between overflow-hidden">
                <div>
                    <!-- Header Controls -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-extrabold text-gray-900 dark:text-gray-100">Đơn hàng kho bãi phát sinh mới</h3>
                            <p class="text-xs text-gray-500">Theo dõi giao dịch trực tiếp từ các nhà vườn</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="/admin/orders" class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-1">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Thêm đơn</span>
                            </a>
                            <a href="/admin/stock-report-page" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 hover:bg-gray-200 transition-all text-xs">
                                <i class="fa-solid fa-filter"></i>
                            </a>
                            <a href="/admin/orders" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 hover:bg-gray-200 transition-all text-xs">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-black uppercase tracking-wider border-b border-gray-100 dark:border-gray-800">
                                <tr>
                                    <th class="p-3">MÃ ĐƠN</th>
                                    <th class="p-3">KHÁCH HÀNG</th>
                                    <th class="p-3">ĐỊA CHỈ GIAO HÀNG</th>
                                    <th class="p-3 text-right">TỔNG TIỀN</th>
                                    <th class="p-3 text-center">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-all">
                                        <td class="p-3 font-black text-gray-900 dark:text-gray-100">#{{ $ord->id }}</td>
                                        <td class="p-3 font-bold text-gray-800 dark:text-gray-200">{{ $ord->customer_name }}</td>
                                        <td class="p-3 max-w-[180px] truncate text-gray-500">{{ $ord->shipping_address }}</td>
                                        <td class="p-3 text-right font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }}đ</td>
                                        <td class="p-3 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-purple-600 text-white shadow-sm">Hoàn thành</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-blue-500 text-white shadow-sm">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-rose-500 text-white shadow-sm">Đang xử lý</span>
                                            @elseif($ord->status === 'pending')
                                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-500 text-white shadow-sm">Chờ duyệt</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-gray-400 text-white shadow-sm">Đã hủy</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-500">Chưa có đơn hàng phát sinh trong hệ thống.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Pagination Row -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 text-xs font-semibold text-gray-500 flex items-center justify-between">
                    <span>Hiển thị 1 đến {{ count($latestOrders) }} đơn hàng mới nhất</span>
                    <a href="/admin/orders" class="text-purple-600 hover:underline font-bold">Xem toàn bộ đơn hàng &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            if (typeof ChartDataLabels !== 'undefined') {
                Chart.register(ChartDataLabels);
            }

            const chartRevenueRaw = @json($chartRevenueRaw);
            const chartRevenueFormatted = @json($chartRevenueFormatted);

            // 1. Combo Bar + Line Chart
            const ctxCombo = document.getElementById('revenueComboChart').getContext('2d');
            
            const gradientBar = ctxCombo.createLinearGradient(0, 0, 0, 240);
            gradientBar.addColorStop(0, '#8B5CF6');
            gradientBar.addColorStop(1, '#C4B5FD');

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
                            borderSkipped: false,
                            barThickness: 28,
                            yAxisID: 'y',
                            datalabels: {
                                align: 'end',
                                anchor: 'end',
                                color: '#7C3AED',
                                font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 },
                                formatter: function(val) { return val > 0 ? val + ' Tr' : ''; }
                            }
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
                            yAxisID: 'y1',
                            datalabels: {
                                align: 'top',
                                anchor: 'start',
                                color: '#D97706',
                                font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 },
                                formatter: function(val) { return val > 0 ? val + ' đơn' : ''; }
                            }
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
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, color: '#64748B' }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#64748B',
                                callback: function(val) { return val + ' Tr'; }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#D97706',
                                callback: function(val) { return val + ' đơn'; }
                            }
                        }
                    }
                }
            });

            // 2. Order Status Doughnut Chart
            const ctxDoughnut = document.getElementById('orderStatusDoughnutChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Hoàn thành', 'Đang giao', 'Đã hủy'],
                    datasets: [{
                        data: [{{ $completedCount }}, {{ $processingCount }}, {{ $cancelledCount }}],
                        backgroundColor: ['#8B5CF6', '#F59E0B', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 6,
                        datalabels: { display: false }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '74%',
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
                                    const val = context.raw || 0;
                                    const total = {{ $totalStatusCount }};
                                    const pct = Math.round((val / total) * 100);
                                    return ' ' + context.label + ': ' + val + ' đơn (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-filament-panels::page>
