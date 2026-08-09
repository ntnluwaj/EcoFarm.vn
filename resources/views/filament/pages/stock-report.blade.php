<x-filament-panels::page>
    <!-- Bộ Lọc Thời Gian -->
    <div class="fi-section rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-6">
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">
                    <i class="fa-regular fa-calendar me-1 text-emerald-600"></i>Từ ngày
                </label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">
                    <i class="fa-regular fa-calendar me-1 text-emerald-600"></i>Đến ngày
                </label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <button type="submit" class="w-full inline-flex justify-center items-center gap-x-2 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm transition-all">
                    <i class="fa-solid fa-filter me-1"></i>
                    <span>Lọc dữ liệu báo cáo</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Thống Kê Tổng Quan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Doanh Thu Thực Tế -->
        <div class="fi-wi-stats-overview-stat relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Doanh thu thực tế</span>
                <div class="rounded-lg bg-emerald-50 dark:bg-emerald-950 p-2.5 text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-sack-dollar text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                {{ number_format($revenue, 0, ',', '.') }}đ
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Từ các đơn hàng hoàn tất</p>
        </div>

        <!-- Tổng Số Đơn Hàng -->
        <div class="fi-wi-stats-overview-stat relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tổng số đơn hàng</span>
                <div class="rounded-lg bg-blue-50 dark:bg-blue-950 p-2.5 text-blue-600 dark:text-blue-400">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-2xl font-bold text-blue-600 dark:text-blue-400">
                {{ $totalOrdersCount }} đơn
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Trong khoảng thời gian chọn</p>
        </div>

        <!-- Giá Trị Trung Bình Đơn -->
        <div class="fi-wi-stats-overview-stat relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Giá trị TB đơn</span>
                <div class="rounded-lg bg-indigo-50 dark:bg-indigo-950 p-2.5 text-indigo-600 dark:text-indigo-400">
                    <i class="fa-solid fa-scale-balanced text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                {{ number_format($avgOrderValue, 0, ',', '.') }}đ
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tính trên đơn hoàn thành</p>
        </div>

        <!-- Tỷ Lệ Hủy Đơn -->
        <div class="fi-wi-stats-overview-stat relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tỷ lệ hủy đơn</span>
                <div class="rounded-lg bg-rose-50 dark:bg-rose-950 p-2.5 text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-ban text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-2xl font-bold text-rose-600 dark:text-rose-400">
                {{ $totalOrdersCount > 0 ? round(($cancelledOrdersCount / $totalOrdersCount) * 100, 1) : 0 }}%
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tổng cộng {{ $cancelledOrdersCount }} đơn hủy</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Bảng Sản Phẩm Bán Chạy -->
        <div class="lg:col-span-2 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-star text-amber-500"></i>
                    Top 5 vật tư bán chạy nhất vụ
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-semibold uppercase border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="p-3">Tên vật tư</th>
                            <th class="p-3">Quy cách</th>
                            <th class="p-3 text-center">Số lượng bán</th>
                            <th class="p-3 text-right">Doanh thu thu về</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($topProducts as $prod)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30">
                                <td class="p-3 font-semibold text-gray-900 dark:text-gray-100">{{ $prod->name }}</td>
                                <td class="p-3">{{ $prod->packaging }} ({{ $prod->unit }})</td>
                                <td class="p-3 text-center font-bold text-gray-800 dark:text-gray-200">{{ number_format($prod->total_qty) }}</td>
                                <td class="p-3 text-right font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($prod->total_revenue, 0, ',', '.') }}đ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Chưa có dữ liệu sản phẩm bán ra trong thời gian lọc.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Trạng Thái Tiến Độ Kho Bãi -->
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-truck-ramp-box text-emerald-600"></i>
                Trạng thái tiến độ kho bãi
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-lg bg-amber-50 dark:bg-amber-950/40 border-l-4 border-amber-500 text-amber-900 dark:text-amber-200">
                    <div>
                        <div class="font-bold text-xs">Chờ duyệt xuất kho</div>
                        <div class="text-[11px] text-amber-700 dark:text-amber-400">Cần bốc xếp khẩn trương</div>
                    </div>
                    <span class="text-lg font-bold">{{ $pendingOrdersCount }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50 dark:bg-blue-950/40 border-l-4 border-blue-500 text-blue-900 dark:text-blue-200">
                    <div>
                        <div class="font-bold text-xs">Đang đóng gói hàng</div>
                        <div class="text-[11px] text-blue-700 dark:text-blue-400">Chuẩn bị hạ tải lên xe</div>
                    </div>
                    <span class="text-lg font-bold">{{ $processingOrdersCount }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 border-l-4 border-indigo-500 text-indigo-900 dark:text-indigo-200">
                    <div>
                        <div class="font-bold text-xs">Đang trung chuyển</div>
                        <div class="text-[11px] text-indigo-700 dark:text-indigo-400">Xe đang chạy tuyến miền Tây</div>
                    </div>
                    <span class="text-lg font-bold">{{ $shippingOrdersCount }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-900 dark:text-emerald-200">
                    <div>
                        <div class="font-bold text-xs">Đã hoàn thành</div>
                        <div class="text-[11px] text-emerald-700 dark:text-emerald-400">Bàn giao & ký phiếu biên nhận</div>
                    </div>
                    <span class="text-lg font-bold">{{ $completedOrdersCount }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-rose-50 dark:bg-rose-950/40 border-l-4 border-rose-500 text-rose-900 dark:text-rose-200">
                    <div>
                        <div class="font-bold text-xs">Đơn bị hủy</div>
                        <div class="text-[11px] text-rose-700 dark:text-rose-400">Sai thông tin / hết kho</div>
                    </div>
                    <span class="text-lg font-bold">{{ $cancelledOrdersCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch Sử Đơn Hàng Gần Nhất -->
    <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-gray-500"></i>
                Lịch sử 10 đơn hàng phát sinh gần nhất
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-400">
                <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-semibold uppercase border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="p-3">Mã đơn</th>
                        <th class="p-3">Khách hàng</th>
                        <th class="p-3">Số điện thoại</th>
                        <th class="p-3">Địa chỉ giao hàng</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3 text-right">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30">
                            <td class="p-3 font-bold text-gray-900 dark:text-gray-100">#{{ $order->id }}</td>
                            <td class="p-3 font-medium">{{ $order->customer_name }}</td>
                            <td class="p-3">{{ $order->customer_phone }}</td>
                            <td class="p-3 max-w-[200px] truncate">{{ $order->shipping_address }}</td>
                            <td class="p-3">
                                @if($order->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Chờ duyệt</span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">Đóng gói</span>
                                @elseif($order->status === 'shipping')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300">Đang giao</span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Hoàn thành</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Đã hủy</span>
                                @endif
                            </td>
                            <td class="p-3 text-right font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Chưa có đơn hàng nào trong khoảng thời gian đã chọn.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
