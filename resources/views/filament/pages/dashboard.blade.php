<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .lodgify-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f6f8f6;
            color: #1e293b;
        }

        .lodgify-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid #eef2ed;
        }

        .dark .lodgify-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2);
        }

        .lodgify-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
        }

        .lodgify-grid-3-mid {
            display: grid !important;
            grid-template-columns: 1fr 1.3fr 1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .lodgify-grid-3-lower {
            display: grid !important;
            grid-template-columns: 1.2fr 1fr 1fr !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .lodgify-stat-card {
            border-radius: 18px;
            padding: 18px 20px;
            background: #ffffff;
            border: 1px solid #eef2ed;
            transition: all 0.2s ease;
        }

        .dark .lodgify-stat-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .lodgify-stat-card.active {
            background: #d1fae5 !important; /* Lodgify Mint Accent */
            border-color: #a7f3d0 !important;
            color: #064e3b !important;
        }

        .lodgify-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #e6f4ea;
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .lodgify-stat-card.active .lodgify-icon-box {
            background: #ffffff;
            color: #059669;
        }

        @media (max-width: 1280px) {
            .lodgify-grid-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .lodgify-grid-3-mid,
            .lodgify-grid-3-lower {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .lodgify-grid-4 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="lodgify-dashboard space-y-6">

        <!-- 🌟 1. TOP 4 METRIC CARDS (Row of 4 equal cards matching Lodgify header) -->
        <div class="lodgify-grid-4">
            <!-- Card 1: Highlighted Active Mint Green Card -->
            <div class="lodgify-stat-card active flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold opacity-80 uppercase tracking-wider">Sản phẩm vật tư</span>
                    <div class="lodgify-icon-box">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black tracking-tight">{{ number_format($productsCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold opacity-80 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-black/10 text-emerald-900 font-extrabold">&uarr; 8.70%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: White Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Đơn hàng bãi kho</span>
                    <div class="lodgify-icon-box">
                        <i class="fa-solid fa-cart-flatbed"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($ordersCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold">&uarr; 3.56%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: White Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Đơn hoàn thành</span>
                    <div class="lodgify-icon-box">
                        <i class="fa-solid fa-[#059669] fa-circle-check"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($completedCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold">&uarr; 8.30%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: White Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Doanh thu thực tế</span>
                    <div class="lodgify-icon-box">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold">&uarr; 100%</span>
                        <span>tăng trưởng</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 2. MIDDLE ROW (3 COLUMNS: Room Availability, Revenue Wave Chart, Overall Rating) -->
        <div class="lodgify-grid-3-mid">
            <!-- Box 1: Warehouse Status (Room Availability style) -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Trạng thái kho bãi</h3>
                        <i class="fa-solid fa-ellipsis text-gray-300"></i>
                    </div>

                    <!-- Stacked Segment Progress Bar -->
                    <div class="w-full h-4 rounded-xl bg-gray-100 dark:bg-gray-800 overflow-hidden flex mb-4">
                        <div class="h-full bg-emerald-400" style="width: 55%;"></div>
                        <div class="h-full bg-lime-300" style="width: 25%;"></div>
                        <div class="h-full bg-sky-300" style="width: 15%;"></div>
                        <div class="h-full bg-rose-400" style="width: 5%;"></div>
                    </div>

                    <!-- 2x2 Metric Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/40">
                            <div class="text-[11px] font-semibold text-emerald-700 dark:text-emerald-300">Sẵn có xuất kho</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-1">{{ $productsCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-lime-50/70 dark:bg-lime-950/40 border border-lime-100 dark:border-lime-900/40">
                            <div class="text-[11px] font-semibold text-lime-800 dark:text-lime-300">Đơn kho bãi</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-1">{{ $ordersCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-sky-50/70 dark:bg-sky-950/40 border border-sky-100 dark:border-sky-900/40">
                            <div class="text-[11px] font-semibold text-sky-700 dark:text-sky-300">Đã hoàn thành</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-1">{{ $completedCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-rose-50/70 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/40">
                            <div class="text-[11px] font-semibold text-rose-700 dark:text-rose-300">Đã hủy</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-gray-100 mt-1">{{ $cancelledCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Revenue Wave Chart with Floating Peak Callout Pill -->
            <div class="lodgify-card flex flex-col justify-between relative overflow-hidden">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Doanh thu thực tế</h3>
                            <p class="text-xs text-gray-400">Xu hướng biến động dòng tiền 6 tháng</p>
                        </div>
                        <span class="px-3 py-1 rounded-xl bg-lime-300 text-lime-950 text-xs font-bold shadow-sm">6 Tháng v</span>
                    </div>

                    <!-- Floating Peak Revenue Badge Callout Pill -->
                    <div class="flex justify-center my-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs border border-emerald-300 shadow-sm">
                            <i class="fa-solid fa-crown text-amber-500"></i>
                            <span>Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
                        </span>
                    </div>

                    <div class="relative h-48 w-full">
                        <canvas id="lodgifyRevenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Box 3: Performance & Overall Rating Widget -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Hiệu suất vận hành</h3>
                        <i class="fa-solid fa-ellipsis text-gray-300"></i>
                    </div>

                    <div class="flex items-baseline gap-2 mb-3">
                        <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400">4.8</span>
                        <span class="text-xs font-bold text-gray-400">/5 Xuất sắc · Vụ Hè Thu 2026</span>
                    </div>

                    <!-- 5 Rating Progress Bars -->
                    <div class="space-y-2.5 text-xs">
                        <div>
                            <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-0.5">
                                <span>Xuất kho khẩn trương</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">4.8</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-full rounded-full bg-lime-400" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-0.5">
                                <span>Bảo quản vật tư</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">4.7</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-full rounded-full bg-lime-400" style="width: 94%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-0.5">
                                <span>Giao hàng tận vườn</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">4.9</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-full rounded-full bg-lime-400" style="width: 98%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-0.5">
                                <span>Chất lượng sản phẩm</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">4.8</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-full rounded-full bg-lime-400" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-0.5">
                                <span>Tỷ lệ hoàn thành</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">4.9</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-full rounded-full bg-lime-400" style="width: 98%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 3. LOWER ROW (3 COLUMNS: Orders Stacked Bar, Category Donut, Timeline Tasks) -->
        <div class="lodgify-grid-3-lower">
            <!-- Box 1: Stacked Bar Chart (Sản lượng đơn hàng) -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Sản lượng đơn hàng</h3>
                            <p class="text-xs text-gray-400">Số lượng đơn hàng hoàn thành & đang xử lý</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 text-xs font-bold">6 Tháng v</span>
                    </div>

                    <div class="relative h-48 w-full">
                        <canvas id="lodgifyOrdersBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Box 2: Category Distribution Ring Chart -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Cơ cấu danh mục</h3>
                        <i class="fa-solid fa-ellipsis text-gray-300"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center my-2">
                        <div class="relative flex items-center justify-center h-40">
                            <canvas id="lodgifyCategoryDonut"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-xl font-black text-gray-900 dark:text-gray-100">100%</span>
                                <span class="text-[9px] font-bold text-gray-400">Vật tư</span>
                            </div>
                        </div>

                        <div class="space-y-1.5 text-xs">
                            @forelse($categorySales as $idx => $cat)
                                @php
                                    $colors = ['bg-emerald-400', 'bg-lime-300', 'bg-sky-300', 'bg-amber-300', 'bg-rose-300'];
                                    $dotColor = $colors[$idx % count($colors)];
                                    $catPct = $totalRevenue > 0 ? round(($cat->total_revenue / $totalRevenue) * 100) : 0;
                                @endphp
                                <div class="flex items-center justify-between text-[11px]">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <span class="w-2 h-2 rounded-full {{ $dotColor }} shrink-0"></span>
                                        <span class="truncate font-semibold text-gray-700 dark:text-gray-300">{{ $cat->category_name }}</span>
                                    </div>
                                    <span class="font-extrabold text-gray-900 dark:text-gray-100 ml-1">{{ max(12, $catPct) }}%</span>
                                </div>
                            @empty
                                <div class="text-gray-400 text-xs">Chưa có dữ liệu...</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 3: Tasks & Schedule Timeline Cards -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Nhiệm vụ & Lịch kho</h3>
                        <button class="w-6 h-6 rounded-lg bg-lime-300 text-lime-950 font-bold flex items-center justify-center shadow-sm text-xs">+</button>
                    </div>

                    <div class="space-y-2">
                        <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-950 text-xs">
                            <div class="font-bold text-[10px] text-emerald-600 mb-0.5">1:00 PM · Hôm nay</div>
                            <div class="font-extrabold">Giao 50 bao NPK cho Vườn Cam</div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-lime-200 border border-lime-300 text-lime-950 text-xs">
                            <div class="font-bold text-[10px] text-lime-800 mb-0.5">2:30 PM · Hôm nay</div>
                            <div class="font-extrabold">Nhập kho 200 chai Tilt Super</div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-950 text-xs">
                            <div class="font-bold text-[10px] text-emerald-600 mb-0.5">4:00 PM · Hôm nay</div>
                            <div class="font-extrabold">Bà con Hai Lúa nhận hàng bãi kho</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 4. BOTTOM ORDERS TABLE CARD -->
        <div class="lodgify-card">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Danh sách đơn hàng bãi kho mới phát sinh</h3>
                    <p class="text-xs text-gray-400">Theo dõi chi tiết giao dịch từ các nhà vườn</p>
                </div>
                <a href="/admin/orders" class="px-4 py-2 rounded-xl bg-lime-300 hover:bg-lime-400 text-lime-950 font-bold text-xs shadow-sm transition-all">Quản lý tất cả đơn hàng &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-black uppercase tracking-wider border-b border-gray-100 dark:border-gray-800 text-[10px]">
                        <tr>
                            <th class="py-3 px-3">MÃ ĐƠN</th>
                            <th class="py-3 px-3">KHÁCH HÀNG</th>
                            <th class="py-3 px-3">ĐỊA CHỈ GIAO HÀNG</th>
                            <th class="py-3 px-3 text-right">TỔNG TIỀN</th>
                            <th class="py-3 px-3 text-center">TRẠNG THÁI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($latestOrders as $ord)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/40 transition-all">
                                <td class="py-3 px-3 font-black text-gray-900 dark:text-gray-100">#{{ $ord->id }}</td>
                                <td class="py-3 px-3 font-bold text-gray-800 dark:text-gray-200">{{ $ord->customer_name }}</td>
                                <td class="py-3 px-3 max-w-[200px] truncate text-gray-500">{{ $ord->shipping_address }}</td>
                                <td class="py-3 px-3 text-right font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }}đ</td>
                                <td class="py-3 px-3 text-center">
                                    @if($ord->status === 'completed')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Hoàn thành</span>
                                    @elseif($ord->status === 'shipping')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">Đang giao</span>
                                    @elseif($ord->status === 'processing')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Đang xử lý</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-400">Chưa có đơn hàng phát sinh...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            // 1. Revenue Sine-Wave Line Chart (Lodgify Middle Chart)
            const ctxRev = document.getElementById('lodgifyRevenueChart').getContext('2d');
            const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 180);
            gradientRev.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
            gradientRev.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: 'Doanh thu (Triệu)',
                        data: @json($chartRevenueData),
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 3,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                        y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 } } }
                    }
                }
            });

            // 2. Orders Stacked Column Bar Chart
            const ctxOrders = document.getElementById('lodgifyOrdersBarChart').getContext('2d');
            new Chart(ctxOrders, {
                type: 'bar',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            label: 'Hoàn thành',
                            data: @json($chartSalesData),
                            backgroundColor: '#34d399',
                            borderRadius: 6,
                            barThickness: 16
                        },
                        {
                            label: 'Đang giao',
                            data: [1, 2, 1, 3, 2, 5],
                            backgroundColor: '#bef264',
                            borderRadius: 6,
                            barThickness: 16
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                        y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 } } }
                    }
                }
            });

            // 3. Category Donut Ring Chart
            const ctxDonut = document.getElementById('lodgifyCategoryDonut').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: @json($categorySales->pluck('category_name')),
                    datasets: [{
                        data: @json($categorySales->pluck('total_qty')),
                        backgroundColor: ['#34d399', '#bef264', '#7dd3fc', '#fcd34d', '#fca5a5'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '76%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-filament-panels::page>
