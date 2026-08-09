<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 1. TOP 4 VIBRANT GRADIENT STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- Card 1: Purple Gradient -->
        <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 backdrop-blur-md">
                        <i class="fa-solid fa-box-archive text-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black tracking-tight">{{ $productsCount }}+</div>
                        <div class="text-xs font-medium text-white/80">Sản phẩm vật tư</div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <i class="fa-solid fa-boxes-stacked" style="font-size: 90px;"></i>
            </div>
        </div>

        <!-- Card 2: Vibrant Blue Gradient -->
        <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 backdrop-blur-md">
                        <i class="fa-solid fa-boxes-packing text-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black tracking-tight">{{ $ordersCount }}+</div>
                        <div class="text-xs font-medium text-white/80">Tổng đơn hàng kho</div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <i class="fa-solid fa-cart-shopping" style="font-size: 90px;"></i>
            </div>
        </div>

        <!-- Card 3: Coral Red/Pink Gradient -->
        <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%);">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 backdrop-blur-md">
                        <i class="fa-solid fa-sack-dollar text-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                        <div class="text-xs font-medium text-white/80">Doanh thu thực tế</div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <i class="fa-solid fa-hand-holding-dollar" style="font-size: 90px;"></i>
            </div>
        </div>

        <!-- Card 4: Warm Gold/Orange Gradient -->
        <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background: linear-gradient(135deg, #ea580c 0%, #fbbf24 100%);">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 backdrop-blur-md">
                        <i class="fa-solid fa-users text-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black tracking-tight">{{ $usersCount }}+</div>
                        <div class="text-xs font-medium text-white/80">Bà con & Đại lý</div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <i class="fa-solid fa-wheat-awn" style="font-size: 90px;"></i>
            </div>
        </div>
    </div>

    <!-- 2. MIDDLE MAIN ANALYTICS GRID (2 COLUMNS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Left 2/3 Panel: Sales Overview & Area Chart -->
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 flex flex-col justify-between">
            <div>
                <!-- Header Controls -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">Tổng quan doanh số</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Theo dõi tăng trưởng doanh thu vật tư nông nghiệp EcoFarm</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-semibold text-gray-500">
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400 font-bold">THÁNG NÀY</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span> Online</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Bãi kho</span>
                    </div>
                </div>

                <!-- Earnings & Chart Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center mb-6">
                    <!-- Stat Sidebar -->
                    <div class="space-y-4">
                        <div>
                            <div class="text-3xl font-black text-gray-900 dark:text-gray-100">
                                {{ number_format($currentMonthRevenue, 0, ',', '.') }}đ
                            </div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">Doanh thu tháng hiện tại</div>
                        </div>

                        <div>
                            <div class="text-2xl font-extrabold text-purple-600 dark:text-purple-400">
                                {{ $currentMonthSales }}
                            </div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">Số đơn hoàn thành tháng này</div>
                        </div>

                        <a href="/admin/stock-report-page" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition-all">
                            <span>Tóm tắt vụ mùa</span>
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>

                    <!-- Area Line Chart Container -->
                    <div class="md:col-span-2 relative h-56 w-full">
                        <canvas id="revenueAreaChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: 4 Metric Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 p-2 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-pink-100 text-pink-600 dark:bg-pink-950 dark:text-pink-400">
                        <i class="fa-solid fa-wallet text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500 uppercase font-semibold">Doanh thu B2C</div>
                        <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ number_format($b2cRevenue, 0, ',', '.') }}đ</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-2 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-950 dark:text-purple-400">
                        <i class="fa-solid fa-building-user text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500 uppercase font-semibold">Doanh thu B2B</div>
                        <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ number_format($b2bRevenue, 0, ',', '.') }}đ</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-2 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                        <i class="fa-solid fa-calculator text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500 uppercase font-semibold">Trung bình đơn</div>
                        <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-2 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600 dark:bg-cyan-950 dark:text-cyan-400">
                        <i class="fa-solid fa-chart-pie text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500 uppercase font-semibold">Tổng doanh số</div>
                        <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1/3 Panel: Analytics Doughnut Ring Chart -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">Phân tích đơn hàng</h3>
                    <i class="fa-solid fa-ellipsis-h text-gray-400"></i>
                </div>

                <!-- Doughnut Chart Container with Centered Percentage -->
                <div class="relative flex items-center justify-center my-4 h-52">
                    <canvas id="orderStatusDoughnutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ $completedPercent }}%</span>
                        <span class="text-[11px] font-semibold text-gray-500">Hoàn thành</span>
                    </div>
                </div>
            </div>

            <!-- Legend Colors at Bottom -->
            <div class="flex items-center justify-center gap-6 pt-4 border-t border-gray-100 dark:border-gray-800 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                    <span class="w-3 h-3 rounded-full bg-purple-600"></span> Hoàn thành ({{ $completedCount }})
                </span>
                <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                    <span class="w-3 h-3 rounded-full bg-amber-400"></span> Đang xử lý ({{ $processingCount }})
                </span>
                <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span> Đã hủy ({{ $cancelledCount }})
                </span>
            </div>
        </div>
    </div>

    <!-- 3. BOTTOM ACTIVITY & ORDERS TABLE GRID (2 COLUMNS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 1/3 Column: Recent Activities Timeline -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-purple-600"></i>
                Hoạt động gần nhất
            </h3>

            <div class="space-y-6">
                @forelse($activities as $act)
                    <div class="flex items-start gap-4">
                        <div class="text-[11px] font-bold text-gray-400 whitespace-nowrap pt-1 w-20">
                            {{ $act['time'] }}
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $act['bg'] }}">
                            <i class="{{ $act['icon'] }} text-sm"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-bold text-gray-900 dark:text-gray-100 truncate">{{ $act['title'] }}</div>
                            <div class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ $act['actor'] }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-xs text-gray-500 py-6">Chưa có nhật ký hoạt động gần đây.</div>
                @endforelse
            </div>
        </div>

        <!-- Right 2/3 Column: Order Status Table -->
        <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden flex flex-col justify-between">
            <div>
                <!-- Table Header Controls -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">Trạng thái đơn hàng gần đây</h3>
                        <p class="text-xs text-gray-500">Theo dõi chi tiết các giao dịch bãi kho mới phát sinh</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/admin/orders" class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-plus"></i>
                            <span>Quản lý đơn</span>
                        </a>
                        <a href="/admin/stock-report-page" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all text-xs">
                            <i class="fa-solid fa-filter"></i>
                        </a>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-bold uppercase tracking-wider border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="p-4">MÃ ĐƠN</th>
                                <th class="p-4">KHÁCH HÀNG</th>
                                <th class="p-4">KHU VỰC</th>
                                <th class="p-4 text-right">TỔNG TIỀN</th>
                                <th class="p-4 text-center">TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($latestOrders as $ord)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-all">
                                    <td class="p-4 font-black text-purple-600 dark:text-purple-400">#{{ $ord->id }}</td>
                                    <td class="p-4 font-bold text-gray-900 dark:text-gray-100">{{ $ord->customer_name }}</td>
                                    <td class="p-4 max-w-[180px] truncate text-gray-500">{{ $ord->shipping_address }}</td>
                                    <td class="p-4 text-right font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }}đ</td>
                                    <td class="p-4 text-center">
                                        @if($ord->status === 'completed')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300">Hoàn thành</span>
                                        @elseif($ord->status === 'shipping')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">Đang giao</span>
                                        @elseif($ord->status === 'processing')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-pink-100 text-pink-700 dark:bg-pink-950 dark:text-pink-300">Đang đóng gói</span>
                                        @elseif($ord->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300">Chờ duyệt</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300">Đã hủy</span>
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

            <!-- Footer Pagination Indicator -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 text-xs font-semibold text-gray-500 flex items-center justify-between">
                <span>Hiển thị {{ min(count($latestOrders), 6) }} đơn hàng mới nhất</span>
                <a href="/admin/orders" class="text-purple-600 hover:underline font-bold">Xem tất cả đơn hàng &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Revenue Area Chart (Left Main Chart)
            const ctxArea = document.getElementById('revenueAreaChart').getContext('2d');
            
            const gradientPurple = ctxArea.createLinearGradient(0, 0, 0, 200);
            gradientPurple.addColorStop(0, 'rgba(139, 92, 246, 0.35)');
            gradientPurple.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

            const gradientOrange = ctxArea.createLinearGradient(0, 0, 0, 200);
            gradientOrange.addColorStop(0, 'rgba(251, 191, 36, 0.35)');
            gradientOrange.addColorStop(1, 'rgba(251, 191, 36, 0.0)');

            new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            label: 'Doanh thu (Triệu VNĐ)',
                            data: @json($chartRevenueData),
                            borderColor: '#8B5CF6',
                            borderWidth: 3,
                            backgroundColor: gradientPurple,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#8B5CF6',
                            pointRadius: 4,
                        },
                        {
                            label: 'Số đơn hàng',
                            data: @json($chartSalesData),
                            borderColor: '#FBBF24',
                            borderWidth: 2,
                            backgroundColor: gradientOrange,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#FBBF24',
                            pointRadius: 3,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // 2. Order Status Doughnut Chart (Right Analytics Ring)
            const ctxDoughnut = document.getElementById('orderStatusDoughnutChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Hoàn thành', 'Đang xử lý', 'Đã hủy'],
                    datasets: [{
                        data: [{{ $completedCount }}, {{ $processingCount }}, {{ $cancelledCount }}],
                        backgroundColor: ['#8B5CF6', '#FBBF24', '#FB7185'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '76%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-filament-panels::page>
