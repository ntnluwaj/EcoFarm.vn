<x-filament-panels::page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 12px -2px rgba(16, 185, 129, 0.03);
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
            background: linear-gradient(135deg, #047857 0%, #059669 35%, #10b981 70%, #f59e0b 100%);
            border-radius: 24px;
            padding: 26px 32px;
            color: #ffffff;
            box-shadow: 0 18px 40px -8px rgba(4, 120, 87, 0.4);
            position: relative;
            overflow: hidden;
        }

        .eco-banner-card::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            pointer-events: none;
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

        /* 🌟 VIBRANT DISTINCT COLOR GRADIENT CARDS */
        .eco-stat-card-emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 22px;
            padding: 22px;
            color: #ffffff;
            box-shadow: 0 14px 30px -5px rgba(5, 150, 105, 0.38);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .eco-stat-card-sky {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            border-radius: 22px;
            padding: 22px;
            color: #ffffff;
            box-shadow: 0 14px 30px -5px rgba(2, 132, 199, 0.38);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .eco-stat-card-amber {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            border-radius: 22px;
            padding: 22px;
            color: #ffffff;
            box-shadow: 0 14px 30px -5px rgba(217, 119, 6, 0.38);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .eco-stat-card-indigo {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border-radius: 22px;
            padding: 22px;
            color: #ffffff;
            box-shadow: 0 14px 30px -5px rgba(79, 70, 229, 0.38);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .eco-stat-card-emerald:hover,
        .eco-stat-card-sky:hover,
        .eco-stat-card-amber:hover,
        .eco-stat-card-indigo:hover {
            transform: translateY(-4px);
        }

        .eco-icon-box-glass {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
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

        <!-- 🌟 1. OFFICIAL DUAL-BRAND SIGNATURE BANNER HEADER -->
        <div class="eco-banner-card flex flex-wrap items-center justify-between gap-4">
            <div class="z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/20 text-xs font-black mb-2 shadow-sm backdrop-blur-sm border border-white/20">
                    <i class="fa-solid fa-wheat-awn text-amber-300"></i>
                    <span>Hệ Thống Quản Lý & Vận Hành Bãi Kho EcoFarm</span>
                </div>
                <h2 class="text-2xl font-black tracking-tight text-white drop-shadow-md">Trung Tâm Báo Cáo Doanh Số & Kho Bãi</h2>
                <p class="text-xs font-semibold text-emerald-50 mt-1">Giám sát thời gian thực chuỗi vật tư, bến bãi & giao dịch nông nghiệp Mekong</p>
            </div>

            <div class="flex items-center gap-3 z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 text-xs font-black text-white shadow-sm backdrop-blur-sm border border-white/20">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Vận Hành Trực Tuyến 24/7</span>
                </div>
            </div>
        </div>

        <!-- 🌟 2. 4 VIBRANT COLOR GRADIENT SCORECARD METRIC CARDS -->
        <div class="eco-grid-4">
            <!-- Card 1: Revenue (Vibrant Eco Emerald) -->
            <div class="eco-stat-card-emerald flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-emerald-100 uppercase tracking-wider">Tổng Doanh Thu</span>
                    <div class="eco-icon-box-glass">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                    <div class="mt-3 text-xs font-bold text-emerald-50 flex items-center justify-between">
                        <span>AOV: {{ number_format($avgOrderValue, 0, ',', '.') }}đ</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/25 text-white font-black backdrop-blur-sm border border-white/20">&uarr; 100% Tốt</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Orders (Vibrant Ocean Blue) -->
            <div class="eco-stat-card-sky flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-sky-100 uppercase tracking-wider">Sản Lượng Đơn Hàng</span>
                    <div class="eco-icon-box-glass">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ number_format($ordersCount) }} đơn hàng</div>
                    <div class="mt-3 text-xs font-bold text-sky-50 flex items-center justify-between">
                        <span>{{ $completedCount }} hoàn thành · {{ $processingCount }} đang giao</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/25 text-white font-black backdrop-blur-sm border border-white/20">{{ $completionRate }}% chốt</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Inventory Products (Vibrant Harvest Amber Gold) -->
            <div class="eco-stat-card-amber flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-amber-100 uppercase tracking-wider">Kho Vật Tư Nông Nghiệp</span>
                    <div class="eco-icon-box-glass">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ number_format($productsCount) }} mặt hàng</div>
                    <div class="mt-3 text-xs font-bold text-amber-50 flex items-center justify-between">
                        <span>Tồn kho an toàn</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/25 text-white font-black backdrop-blur-sm border border-white/20">{{ count($lowStockProducts) }} sắp hết</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Farmers Base (Vibrant Royal Mekong Indigo) -->
            <div class="eco-stat-card-indigo flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-indigo-100 uppercase tracking-wider">Bà Con Nông Dân</span>
                    <div class="eco-icon-box-glass">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ number_format($usersCount) }} nhà vườn</div>
                    <div class="mt-3 text-xs font-bold text-indigo-50 flex items-center justify-between">
                        <span>Đồng bằng sông Cửu Long</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/25 text-white font-black backdrop-blur-sm border border-white/20">&uarr; Tương tác cao</span>
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
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/80 shrink-0 shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                            <span>6 tháng gần nhất</span>
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
                                Tỷ lệ trạng thái đơn hàng
                            </h3>
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 text-[11px] font-extrabold border border-slate-200/60 shrink-0 flex items-center gap-1">
                                <i class="fa-solid fa-clock text-slate-500"></i>
                                <span>Toàn thời gian</span>
                            </span>
                        </div>

                        <div style="height: 190px; width: 100%; position: relative; display: flex; align-items: center; justify-content: center;">
                            <canvas id="ecoStatusDoughnutChart"></canvas>
                        </div>
                    </div>

                    <!-- CHÚ THÍCH MÀU SẮC SIÊU RÕ RÀNG VỚI NỀN PASTEL VÀ CHỮ SẮC NÉT -->
                    <div class="flex flex-wrap items-center justify-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-800 mt-2">
                        <span style="background-color: #fef3c7 !important; color: #b45309 !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #fde68a !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
                            Chờ duyệt
                        </span>
                        <span style="background-color: #e0f2fe !important; color: #0369a1 !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #bae6fd !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #38bdf8; display: inline-block;"></span>
                            Đóng gói
                        </span>
                        <span style="background-color: #e0e7ff !important; color: #4338ca !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #c7d2fe !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #6366f1; display: inline-block;"></span>
                            Đang giao
                        </span>
                        <span style="background-color: #d1fae5 !important; color: #047857 !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #a7f3d0 !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                            Hoàn tất
                        </span>
                        <span style="background-color: #ffe4e6 !important; color: #be123c !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #fecdd3 !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #ef4444; display: inline-block;"></span>
                            Đã hủy
                        </span>
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
                        <a href="/admin/orders" class="text-xs font-extrabold text-emerald-600 hover:text-emerald-700 hover:underline shrink-0">Quản lý tất cả &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-black uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 text-[10px]">
                                <tr>
                                    <th class="py-2.5 px-3">MÃ ĐƠN</th>
                                    <th class="py-2.5 px-3">KHÁCH HÀNG</th>
                                    <th class="py-2.5 px-3">TỔNG TIỀN</th>
                                    <th class="py-2.5 px-3 text-center">TRẠNG THÁI</th>
                                    <th class="py-2.5 px-3">THỜI GIAN</th>
                                    <th class="py-2.5 px-3 text-center">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($latestOrders as $ord)
                                    <tr class="hover:bg-emerald-50/40 dark:hover:bg-slate-800/40 transition-all">
                                        <td class="py-2.5 px-3 font-black text-slate-900 dark:text-slate-100">#ECF{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="py-2.5 px-3 font-bold text-slate-800 dark:text-slate-200">{{ $ord->customer_name }}</td>
                                        <td class="py-2.5 px-3 font-black text-emerald-600 dark:text-emerald-400">{{ number_format($ord->total_amount, 0, ',', '.') }} VND</td>
                                        <td class="py-2.5 px-3 text-center">
                                            @if($ord->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200/50">Hoàn tất</span>
                                            @elseif($ord->status === 'shipping')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-sky-100 text-sky-800 border border-sky-200/50">Đang giao</span>
                                            @elseif($ord->status === 'processing')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200/50">Đóng gói</span>
                                            @elseif($ord->status === 'pending')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200/50">Chờ duyệt</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200/50">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="py-2.5 px-3 text-slate-500 text-[11px] font-semibold">
                                            {{ $ord->created_at ? $ord->created_at->format('H:i d/m/Y') : '12:29 09/08/2026' }}
                                        </td>
                                        <td class="py-2.5 px-3 text-center">
                                            <a href="/admin/orders/{{ $ord->id }}" class="text-emerald-600 font-extrabold hover:text-emerald-700 hover:underline inline-flex items-center gap-1 text-[11px]">
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
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 text-[11px] font-extrabold border border-slate-200/60 shrink-0 flex items-center gap-1">
                                <i class="fa-solid fa-chart-pie text-slate-500"></i>
                                <span>Phân bổ</span>
                            </span>
                        </div>

                        <div style="height: 190px; width: 100%; position: relative; display: flex; align-items: center; justify-content: center;">
                            <canvas id="ecoCategoryPolarChart"></canvas>
                        </div>
                    </div>

                    <!-- CHÚ THÍCH MÀU SẮC SIÊU RÕ RÀNG VỚI NỀN PASTEL VÀ CHỮ SẮC NÉT -->
                    <div class="flex flex-wrap items-center justify-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-800 mt-2">
                        <span style="background-color: #d1fae5 !important; color: #047857 !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #a7f3d0 !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                            Thuốc Trừ Sâu & Bệnh
                        </span>
                        <span style="background-color: #e0e7ff !important; color: #4338ca !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #c7d2fe !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #6366f1; display: inline-block;"></span>
                            Hạt Giống
                        </span>
                        <span style="background-color: #fef3c7 !important; color: #b45309 !important; font-weight: 800 !important; padding: 5px 12px; border-radius: 9999px; font-size: 11px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #fde68a !important;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
                            Phân Bón Hữu Cơ & NPK
                        </span>
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
            gradientRev.addColorStop(0, 'rgba(16, 185, 129, 0.42)');
            gradientRev.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: @json($chartRevenueRaw),
                        borderColor: '#059669',
                        borderWidth: 4,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#047857',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8
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
                            labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' }, color: '#334155' }
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
                        x: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' }, color: '#64748B' } },
                        y: {
                            grace: '15%',
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' },
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
                        borderWidth: 3,
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
                            'rgba(16, 185, 129, 0.85)',
                            'rgba(99, 102, 241, 0.85)',
                            'rgba(245, 158, 11, 0.85)',
                            'rgba(56, 189, 248, 0.85)',
                            'rgba(244, 114, 182, 0.85)'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 3
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
