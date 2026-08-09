<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .lodgify-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .lodgify-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
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
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .dark .lodgify-stat-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .lodgify-stat-card.active {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; /* Forest Emerald Gradient */
            border-color: #047857 !important;
            color: #ffffff !important;
            box-shadow: 0 10px 25px -4px rgba(5, 150, 105, 0.3) !important;
        }

        .lodgify-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .lodgify-stat-card.active .lodgify-icon-box {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            backdrop-filter: blur(8px);
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

        <!-- 🌟 1. TOP 4 METRIC CARDS (Refined Professional Forest Emerald & Slate Theme) -->
        <div class="lodgify-grid-4">
            <!-- Card 1: Highlighted Forest Emerald Card -->
            <div class="lodgify-stat-card active flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-100">Sản phẩm vật tư</span>
                    <div class="lodgify-icon-box">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black tracking-tight text-white">{{ number_format($productsCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-100 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-white/20 text-white font-extrabold">&uarr; 8.70%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: White Slate Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Đơn hàng bãi kho</span>
                    <div class="lodgify-icon-box bg-blue-50 text-blue-600 dark:bg-blue-950 dark:text-blue-400">
                        <i class="fa-solid fa-cart-flatbed"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($ordersCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-blue-800 dark:text-blue-300 font-extrabold">&uarr; 3.56%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: White Slate Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Đơn hoàn thành</span>
                    <div class="lodgify-icon-box bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($completedCount) }}</div>
                    <div class="mt-2 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold">&uarr; 8.30%</span>
                        <span>so với vụ trước</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: White Slate Card -->
            <div class="lodgify-stat-card flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Doanh thu thực tế</span>
                    <div class="lodgify-icon-box bg-amber-50 text-amber-600 dark:bg-amber-950 dark:text-amber-400">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    <div class="mt-2 text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                        <span class="px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 font-extrabold">&uarr; 100%</span>
                        <span>tăng trưởng</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 2. MIDDLE ROW (3 COLUMNS: Status, Revenue Wave Chart, Performance) -->
        <div class="lodgify-grid-3-mid">
            <!-- Box 1: Warehouse Status -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Trạng thái kho bãi</h3>
                        <i class="fa-solid fa-ellipsis text-slate-400"></i>
                    </div>

                    <!-- Stacked Segment Progress Bar -->
                    <div class="w-full h-3.5 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden flex mb-4">
                        <div class="h-full bg-emerald-500" style="width: 55%;"></div>
                        <div class="h-full bg-indigo-500" style="width: 25%;"></div>
                        <div class="h-full bg-amber-500" style="width: 15%;"></div>
                        <div class="h-full bg-rose-500" style="width: 5%;"></div>
                    </div>

                    <!-- 2x2 Metric Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/40">
                            <div class="text-[11px] font-bold text-emerald-700 dark:text-emerald-300">Sẵn có xuất kho</div>
                            <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ $productsCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/40">
                            <div class="text-[11px] font-bold text-indigo-700 dark:text-indigo-300">Đơn kho bãi</div>
                            <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ $ordersCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-blue-50/80 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/40">
                            <div class="text-[11px] font-bold text-blue-700 dark:text-blue-300">Đã hoàn thành</div>
                            <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ $completedCount }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-rose-50/80 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/40">
                            <div class="text-[11px] font-bold text-rose-700 dark:text-rose-300">Đã hủy</div>
                            <div class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1">{{ $cancelledCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Revenue Wave Chart with Executive Floating Callout Pill -->
            <div class="lodgify-card flex flex-col justify-between relative overflow-hidden">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Doanh thu thực tế</h3>
                            <p class="text-xs text-slate-500">Xu hướng biến động dòng tiền 6 tháng</p>
                        </div>
                        <span class="px-3 py-1 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-sm">6 Tháng v</span>
                    </div>

                    <!-- Executive Floating Callout Pill -->
                    <div class="flex justify-center my-1">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-600 text-white font-extrabold text-xs shadow-md">
                            <i class="fa-solid fa-crown text-amber-300"></i>
                            <span>Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
                        </span>
                    </div>

                    <div class="relative h-48 w-full">
                        <canvas id="lodgifyRevenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Box 3: Performance Rating Widget -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Hiệu suất vận hành</h3>
                        <i class="fa-solid fa-ellipsis text-slate-400"></i>
                    </div>

                    <div class="flex items-baseline gap-2 mb-3">
                        <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400">4.8</span>
                        <span class="text-xs font-bold text-slate-500">/5 Xuất sắc · Vụ Hè Thu 2026</span>
                    </div>

                    <!-- 5 Rating Progress Bars -->
                    <div class="space-y-2.5 text-xs">
                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">
                                <span>Xuất kho khẩn trương</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">4.8</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">
                                <span>Bảo quản vật tư</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">4.7</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: 94%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">
                                <span>Giao hàng tận vườn</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">4.9</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: 98%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">
                                <span>Chất lượng sản phẩm</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">4.8</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">
                                <span>Tỷ lệ hoàn thành</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">4.9</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: 98%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 3. LOWER ROW (3 COLUMNS: Orders Stacked Bar, Category Donut, Timeline Tasks) -->
        <div class="lodgify-grid-3-lower">
            <!-- Box 1: Orders Bar Chart -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Sản lượng đơn hàng</h3>
                            <p class="text-xs text-slate-500">Số lượng đơn hàng hoàn thành & đang xử lý</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 text-xs font-bold">6 Tháng v</span>
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
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Cơ cấu danh mục</h3>
                        <i class="fa-solid fa-ellipsis text-slate-400"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center my-2">
                        <div class="relative flex items-center justify-center h-40">
                            <canvas id="lodgifyCategoryDonut"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-xl font-black text-slate-900 dark:text-slate-100">100%</span>
                                <span class="text-[9px] font-bold text-slate-500">Vật tư</span>
                            </div>
                        </div>

                        <div class="space-y-1.5 text-xs">
                            @forelse($categorySales as $idx => $cat)
                                @php
                                    $colors = ['bg-emerald-500', 'bg-indigo-500', 'bg-sky-400', 'bg-amber-400', 'bg-rose-400'];
                                    $dotColor = $colors[$idx % count($colors)];
                                    $catPct = $totalRevenue > 0 ? round(($cat->total_revenue / $totalRevenue) * 100) : 0;
                                @endphp
                                <div class="flex items-center justify-between text-[11px]">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <span class="w-2 h-2 rounded-full {{ $dotColor }} shrink-0"></span>
                                        <span class="truncate font-semibold text-slate-700 dark:text-slate-300">{{ $cat->category_name }}</span>
                                    </div>
                                    <span class="font-black text-slate-900 dark:text-slate-100 ml-1">{{ max(12, $catPct) }}%</span>
                                </div>
                            @empty
                                <div class="text-slate-400 text-xs">Chưa có dữ liệu...</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 3: Tasks & Schedule Timeline Cards -->
            <div class="lodgify-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Nhiệm vụ & Lịch kho</h3>
                        <button class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold flex items-center justify-center shadow-sm text-xs">+</button>
                    </div>

                    <div class="space-y-2">
                        <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-950 text-xs">
                            <div class="font-bold text-[10px] text-emerald-700 mb-0.5">1:00 PM · Hôm nay</div>
                            <div class="font-extrabold">Giao 50 bao NPK cho Vườn Cam</div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-950 text-xs">
                            <div class="font-bold text-[10px] text-blue-700 mb-0.5">2:30 PM · Hôm nay</div>
                            <div class="font-extrabold">Nhập kho 200 chai Tilt Super</div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-950 text-xs">
                            <div class="font-bold text-[10px] text-amber-700 mb-0.5">4:00 PM · Hôm nay</div>
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
                    <h3 class="text-base font-black text-slate-900 dark:text-slate-100">Danh sách đơn hàng bãi kho mới phát sinh</h3>
                    <p class="text-xs text-slate-500">Theo dõi chi tiết giao dịch từ các nhà vườn</p>
                </div>
                <a href="/admin/orders" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all">Quản lý tất cả đơn hàng &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-black uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 text-[10px]">
                        <tr>
                            <th class="py-3 px-3">MÃ ĐƠN</th>
                            <th class="py-3 px-3">KHÁCH HÀNG</th>
                            <th class="py-3 px-3">ĐỊA CHỈ GIAO HÀNG</th>
                            <th class="py-3 px-3 text-right">TỔNG TIỀN</th>
                            <th class="py-3 px-3 text-center">TRẠNG THÁI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($latestOrders as $ord)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-all">
                                <td class="py-3 px-3 font-black text-slate-900 dark:text-slate-100">#{{ $ord->id }}</td>
                                <td class="py-3 px-3 font-bold text-slate-800 dark:text-slate-200">{{ $ord->customer_name }}</td>
                                <td class="py-3 px-3 max-w-[200px] truncate text-slate-500">{{ $ord->shipping_address }}</td>
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
                                <td colspan="5" class="py-4 text-center text-slate-400">Chưa có đơn hàng phát sinh...</td>
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

            // 1. Revenue Sine-Wave Line Chart
            const ctxRev = document.getElementById('lodgifyRevenueChart').getContext('2d');
            const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 180);
            gradientRev.addColorStop(0, 'rgba(5, 150, 105, 0.25)');
            gradientRev.addColorStop(1, 'rgba(5, 150, 105, 0.0)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: 'Doanh thu (Triệu)',
                        data: @json($chartRevenueData),
                        borderColor: '#059669',
                        borderWidth: 3.5,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#059669',
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
                            backgroundColor: '#059669',
                            borderRadius: 6,
                            barThickness: 16
                        },
                        {
                            label: 'Đang giao',
                            data: [1, 2, 1, 3, 2, 5],
                            backgroundColor: '#6366f1',
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
                        backgroundColor: ['#059669', '#6366f1', '#38bdf8', '#fbbf24', '#f87171'],
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
