<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .hirezy-dashboard {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .hirezy-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .dark .hirezy-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2);
        }

        .hirezy-top-kpi-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 16px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .dark .hirezy-top-kpi-container {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.08);
        }

        .hirezy-kpi-item {
            border-radius: 16px;
            padding: 18px 20px;
            background: #f8fafc;
            border: 1px solid rgba(241, 245, 249, 1);
            transition: all 0.2s ease;
        }

        .dark .hirezy-kpi-item {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .hirezy-kpi-item.active {
            background: #bef264 !important; /* Hirezy Lime Accent */
            border-color: #a3e635 !important;
            color: #0f172a !important;
        }

        .hirezy-grid-3 {
            display: grid !important;
            grid-template-columns: 1.3fr 1fr 1fr !important;
            gap: 20px !important;
        }

        .hirezy-grid-2-main {
            display: grid !important;
            grid-template-columns: 2.1fr 1fr !important;
            gap: 20px !important;
        }

        .hirezy-grid-2-col {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 14px !important;
        }

        @media (max-width: 1280px) {
            .hirezy-top-kpi-container {
                grid-template-columns: repeat(2, 1fr);
            }
            .hirezy-grid-3 {
                grid-template-columns: 1fr !important;
            }
            .hirezy-grid-2-main {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            .hirezy-grid-2-col {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .hirezy-top-kpi-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="hirezy-dashboard space-y-6">

        <!-- 🌟 1. TOP 4 METRIC CARDS ROW (Hirezy Header Bar) -->
        <div class="hirezy-top-kpi-container">
            <!-- Card 1: Active Highlight Lime Green Card -->
            <div class="hirezy-kpi-item active flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold opacity-80 uppercase tracking-wider">Sản phẩm vật tư</span>
                    <i class="fa-solid fa-ellipsis text-slate-700"></i>
                </div>
                <div class="flex items-baseline justify-between mt-3">
                    <span class="text-3xl font-black tracking-tight">{{ number_format($productsCount) }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-black/10 text-black">
                        <i class="fa-solid fa-arrow-up text-[9px] mr-1"></i>+12.6%
                    </span>
                </div>
            </div>

            <!-- Card 2: White Card -->
            <div class="hirezy-kpi-item flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Đơn hàng bãi kho</span>
                    <i class="fa-solid fa-ellipsis text-gray-300"></i>
                </div>
                <div class="flex items-baseline justify-between mt-3">
                    <span class="text-3xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($ordersCount) }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300">
                        <i class="fa-solid fa-arrow-down text-[9px] mr-1"></i>-1.9%
                    </span>
                </div>
            </div>

            <!-- Card 3: White Card -->
            <div class="hirezy-kpi-item flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Đơn hoàn thành</span>
                    <i class="fa-solid fa-ellipsis text-gray-300"></i>
                </div>
                <div class="flex items-baseline justify-between mt-3">
                    <span class="text-3xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($completedCount) }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                        <i class="fa-solid fa-arrow-up text-[9px] mr-1"></i>+8.3%
                    </span>
                </div>
            </div>

            <!-- Card 4: White Card -->
            <div class="hirezy-kpi-item flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Doanh thu thực tế</span>
                    <i class="fa-solid fa-ellipsis text-gray-300"></i>
                </div>
                <div class="flex items-baseline justify-between mt-3">
                    <span class="text-2xl font-black text-gray-900 dark:text-gray-100 tracking-tight">{{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-lime-100 text-lime-800 dark:bg-lime-950 dark:text-lime-300">
                        <i class="fa-solid fa-arrow-up text-[9px] mr-1"></i>+100%
                    </span>
                </div>
            </div>
        </div>

        <!-- 🌟 2. MIDDLE ROW (3 COLUMNS: Bar Chart, Donut Chart, Status Arc Widget) -->
        <div class="hirezy-grid-3">
            <!-- Box 1: Dual Column Bar Chart (Doanh số theo tháng) -->
            <div class="hirezy-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Doanh số theo tháng</h3>
                            <div class="flex items-center gap-3 text-[11px] font-semibold text-gray-400 mt-0.5">
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span> Doanh thu (Triệu VNĐ)</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-lime-400"></span> Đơn chốt</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs font-bold">Vụ Hè Thu v</span>
                    </div>

                    <div class="relative h-56 w-full">
                        <canvas id="hirezyBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Box 2: Donut Ring Chart (Phân bổ theo danh mục) -->
            <div class="hirezy-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Phân bổ theo danh mục</h3>
                        <span class="px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs font-bold">Hôm nay v</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center my-2">
                        <div class="relative flex items-center justify-center h-44">
                            <canvas id="hirezyCategoryDonut"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-2xl font-black text-gray-900 dark:text-gray-100">{{ $productsCount }}</span>
                                <span class="text-[10px] font-bold text-gray-400">Sản phẩm vật tư</span>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            @forelse($categorySales as $idx => $cat)
                                @php
                                    $colors = ['bg-indigo-500', 'bg-lime-400', 'bg-amber-400', 'bg-sky-400', 'bg-pink-400', 'bg-emerald-400'];
                                    $dotColor = $colors[$idx % count($colors)];
                                @endphp
                                <div class="flex items-center justify-between p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <div class="flex items-center gap-2 truncate">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }} shrink-0"></span>
                                        <span class="truncate font-semibold text-gray-700 dark:text-gray-300 text-[11px]">{{ $cat->category_name }}</span>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-gray-100 text-[11px] ml-2">{{ $cat->total_qty }} sp</span>
                                </div>
                            @empty
                                <div class="text-gray-400 text-xs py-2">Đang thống kê danh mục...</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 3: Gauge Arc Widget (Trạng thái xuất kho & vận chuyển) -->
            <div class="hirezy-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Trạng thái xuất kho</h3>
                        <i class="fa-solid fa-ellipsis text-gray-300"></i>
                    </div>

                    <div class="relative flex items-center justify-center my-2 h-44">
                        <canvas id="hirezyStatusGauge"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-3xl font-black text-gray-900 dark:text-gray-100">100%</span>
                            <span class="text-[10px] font-bold text-gray-400">Đơn hàng kho</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-gray-100 dark:border-gray-800 text-[11px] font-semibold">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-sm bg-lime-400"></span>
                        <span class="text-gray-600 dark:text-gray-400">Hoàn thành:</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 ml-auto">{{ $completedCount }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Đang giao:</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 ml-auto">{{ $processingCount }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-sm bg-amber-400"></span>
                        <span class="text-gray-600 dark:text-gray-400">Chờ duyệt:</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 ml-auto">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-sm bg-rose-400"></span>
                        <span class="text-gray-600 dark:text-gray-400">Đã hủy:</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 ml-auto">{{ $cancelledCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌟 3. LOWER SECTION (COMPACT NON-STRETCHED LAYOUT: Left 65% + Right 35%) -->
        <div class="hirezy-grid-2-main">
            <!-- LEFT PANEL 65%: Top Products Grid + Applicants List Table -->
            <div class="space-y-6">
                <!-- Section 1: Top 4 Products Compact 2x2 Grid -->
                <div class="hirezy-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Sản phẩm vật tư bán chạy</h3>
                            <p class="text-xs text-gray-400">Top các sản phẩm phát sinh đơn hàng nhiều nhất</p>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-gray-500">Sắp xếp: <strong class="text-gray-900 dark:text-gray-100">Phổ biến v</strong></span>
                            <a href="/admin/products" class="text-lime-700 dark:text-lime-400 font-bold hover:underline">Xem tất cả</a>
                        </div>
                    </div>

                    <!-- Compact 2x2 Grid -->
                    <div class="hirezy-grid-2-col">
                        @forelse($topProducts as $prod)
                            <div class="p-3.5 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40 hover:border-lime-400 transition-all flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-lime-200 text-lime-900 font-black text-sm shadow-sm">
                                        @if($prod->image)
                                            <img src="{{ $prod->primary_image_url }}" class="w-full h-full object-cover rounded-xl" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <i class="fa-solid fa-leaf hidden text-sm"></i>
                                        @else
                                            <i class="fa-solid fa-leaf text-sm"></i>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="font-extrabold text-xs text-gray-900 dark:text-gray-100 truncate mb-0.5">{{ $prod->name }}</h4>
                                        <div class="flex items-center gap-1.5 text-[10px]">
                                            <span class="px-1.5 py-0.5 rounded bg-lime-100 text-lime-800 font-bold truncate">{{ $prod->category->name ?? 'Vật tư' }}</span>
                                            <span class="text-gray-400 truncate">{{ $prod->packaging ?? $prod->unit }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <div class="font-black text-xs text-emerald-600 dark:text-emerald-400">{{ number_format($prod->price, 0, ',', '.') }}đ</div>
                                    <div class="text-[10px] text-gray-400 font-semibold">85+ đã bán</div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center text-xs text-gray-400 py-4">Chưa có dữ liệu sản phẩm...</div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 2: Applicants List Table (Danh sách đơn hàng bãi kho) -->
                <div class="hirezy-card">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100">Danh sách đơn hàng bãi kho</h3>
                            <p class="text-xs text-gray-400">Theo dõi các phiếu giao dịch xuất kho mới nhất</p>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-gray-500">Lọc theo: <strong class="text-gray-900 dark:text-gray-100">Mới nhất v</strong></span>
                        </div>
                    </div>

                    <!-- Filter Pill Tabs -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-3 mb-2 text-xs font-bold border-b border-gray-100 dark:border-gray-800">
                        <span class="px-3 py-1.5 rounded-lg bg-lime-300 text-lime-950 shadow-sm cursor-pointer">Tất cả đơn</span>
                        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 cursor-pointer">Chờ duyệt</span>
                        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 cursor-pointer">Đang giao</span>
                        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 cursor-pointer">Hoàn thành</span>
                        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 cursor-pointer">Đã hủy</span>
                    </div>

                    <!-- Compact Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                            <thead class="text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100 dark:border-gray-800 text-[10px]">
                                <tr>
                                    <th class="py-2.5 px-2">MÃ ĐƠN</th>
                                    <th class="py-2.5 px-2">KHÁCH HÀNG</th>
                                    <th class="py-2.5 px-2">ĐỊA CHỈ GIAO HÀNG</th>
                                    <th class="py-2.5 px-2 text-right">TỔNG TIỀN</th>
                                    <th class="py-2.5 px-2 text-center">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/40 transition-all">
                                        <td class="py-2.5 px-2 font-black text-gray-900 dark:text-gray-100">#{{ $ord->id }}</td>
                                        <td class="py-2.5 px-2 font-bold text-gray-800 dark:text-gray-200">{{ $ord->customer_name }}</td>
                                        <td class="py-2.5 px-2 max-w-[180px] truncate text-gray-500">{{ $ord->shipping_address }}</td>
                                        <td class="py-2.5 px-2 text-right font-black text-gray-900 dark:text-gray-100">{{ number_format($ord->total_amount, 0, ',', '.') }}đ</td>
                                        <td class="py-2.5 px-2 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-lime-300 text-lime-950">Hoàn thành</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-200 text-sky-900">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900">Đang xử lý</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-200 text-rose-900">Đã hủy</span>
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

            <!-- RIGHT PANEL 35%: Combined Compact Task/Schedule Widget + Activity Log -->
            <div class="space-y-6">
                <!-- Widget 1: Tasks & Schedule Combined -->
                <div class="hirezy-card space-y-5">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-black text-gray-900 dark:text-gray-100">Nhiệm vụ kho bãi & vận chuyển</h3>
                            <button class="w-6 h-6 rounded-lg bg-lime-300 text-lime-950 font-bold flex items-center justify-center shadow-sm text-xs">+</button>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-800/40 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-lime-200 text-lime-900 font-extrabold text-[10px] flex items-center justify-center">80%</span>
                                    <span class="font-bold text-gray-900 dark:text-gray-100 text-[11px]">Bốc xếp ST25 tại Kho Bãi 1</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-800/40 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-indigo-200 text-indigo-900 font-extrabold text-[10px] flex items-center justify-center">60%</span>
                                    <span class="font-bold text-gray-900 dark:text-gray-100 text-[11px]">Điều xe vận chuyển An Giang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-black text-gray-900 dark:text-gray-100">Lịch xuất kho hôm nay</h3>
                            <span class="text-[10px] font-bold text-gray-400">Today v</span>
                        </div>
                        <div class="space-y-2">
                            <div class="p-2.5 rounded-lg bg-lime-300 text-lime-950 flex items-center justify-between text-xs">
                                <span class="font-black text-[11px]">1:00 PM</span>
                                <span class="font-extrabold text-[11px] truncate">Giao 50 bao NPK cho Vườn Cam</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-amber-100 text-amber-950 flex items-center justify-between text-xs">
                                <span class="font-black text-[11px]">2:30 PM</span>
                                <span class="font-extrabold text-[11px] truncate">Nhập kho 200 chai Tilt Super</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget 2: Recent Activity (Nhật ký hoạt động) -->
                <div class="hirezy-card">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-black text-gray-900 dark:text-gray-100">Nhật ký hoạt động hệ thống</h3>
                        <i class="fa-solid fa-ellipsis text-gray-300 text-xs"></i>
                    </div>

                    <div class="space-y-3">
                        @forelse($activities as $act)
                            <div class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-lime-300 text-lime-950 shrink-0 flex items-center justify-center font-bold text-xs">
                                    <i class="{{ $act['icon'] }}"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-xs font-bold text-gray-900 dark:text-gray-100 truncate">{{ $act['title'] }}</div>
                                    <div class="text-[10px] text-gray-400 truncate">{{ $act['actor'] }} · {{ $act['time'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-xs text-gray-400 text-center py-2">Chưa có nhật ký...</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            // 1. Dual Column Bar Chart
            const ctxBar = document.getElementById('hirezyBarChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            label: 'Doanh thu (Triệu)',
                            data: @json($chartRevenueData),
                            backgroundColor: '#818cf8',
                            borderRadius: 6,
                            barThickness: 16
                        },
                        {
                            label: 'Đơn chốt',
                            data: @json($chartSalesData),
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

            // 2. Category Donut Ring Chart
            const ctxDonut = document.getElementById('hirezyCategoryDonut').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: @json($categorySales->pluck('category_name')),
                    datasets: [{
                        data: @json($categorySales->pluck('total_qty')),
                        backgroundColor: ['#818cf8', '#bef264', '#fbbf24', '#38bdf8', '#f472b6', '#34d399'],
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

            // 3. Status Arc Gauge
            const ctxGauge = document.getElementById('hirezyStatusGauge').getContext('2d');
            new Chart(ctxGauge, {
                type: 'doughnut',
                data: {
                    labels: ['Hoàn thành', 'Đang giao', 'Đã hủy'],
                    datasets: [{
                        data: [{{ $completedCount }}, {{ $processingCount }}, {{ $cancelledCount }}],
                        backgroundColor: ['#bef264', '#818cf8', '#f87171'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '78%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-filament-panels::page>
