@extends('frontend.layouts.master')

@section('title', 'Báo Cáo Doanh Thu & Bảng Quản Lý Bãi Kho EcoFarm')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-chart-line text-success me-2"></i>BÁO CÁO DOANH THU & KHO VẬN NỘI BỘ
            </h3>
            <p class="text-secondary small mb-0">Theo dõi dòng tiền bán lẻ B2C, hiệu suất giao nhận và cơ cấu phân bổ vận đơn EcoFarm</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-status-green">
                <span class="status-dot-pulse dot-green"></span>Cơ sở Cần Thơ & ĐBSCL
            </span>
            <a href="/admin" class="btn btn-outline-success btn-sm fw-bold px-3 py-2 rounded-pill">
                <i class="fa-solid fa-gauge me-1"></i>Vào Filament Admin
            </a>
        </div>
    </div>

    <!-- Date Filter Card -->
    <form method="GET" action="{{ route('admin.reports') }}" class="crm-table-card-wrapper p-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary text-xs"><i class="fa-regular fa-calendar me-1 text-success"></i>Từ ngày</label>
                <input type="date" name="start_date" class="form-control rounded-3 text-xs" value="{{ $startDate->format('Y-m-d') }}" style="font-size: 13px;">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary text-xs"><i class="fa-regular fa-calendar me-1 text-success"></i>Đến ngày</label>
                <input type="date" name="end_date" class="form-control rounded-3 text-xs" value="{{ $endDate->format('Y-m-d') }}" style="font-size: 13px;">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2 text-xs shadow-xs" style="background-color: #2e7d32; border: none; height: 38px;">
                    <i class="fa-solid fa-filter me-2"></i>Lọc dữ liệu báo cáo
                </button>
            </div>
        </div>
    </form>

    <!-- Top Metric Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="crm-table-card-wrapper p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Doanh thu thực tế</span>
                    <div class="p-2 bg-success-subtle text-success rounded-circle"><i class="fa-solid fa-sack-dollar fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-success mb-1">{{ number_format($revenue, 0, ',', '.') }}đ</h3>
                <p class="text-muted text-xs mb-0">Từ các đơn hàng hoàn tất</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="crm-table-card-wrapper p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Tổng số đơn hàng</span>
                    <div class="p-2 bg-primary-subtle text-primary rounded-circle"><i class="fa-solid fa-boxes-stacked fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-primary mb-1">{{ $totalOrdersCount }} đơn</h3>
                <p class="text-muted text-xs mb-0">Chốt trong khoảng thời gian lọc</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="crm-table-card-wrapper p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Giá trị TB đơn</span>
                    <div class="p-2 bg-info-subtle text-info rounded-circle"><i class="fa-solid fa-scale-balanced fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-info mb-1">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</h3>
                <p class="text-muted text-xs mb-0">Tính trên đơn hoàn thành</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="crm-table-card-wrapper p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Tỷ lệ hủy đơn</span>
                    <div class="p-2 bg-danger-subtle text-danger rounded-circle"><i class="fa-solid fa-ban fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-danger mb-1">
                    {{ $totalOrdersCount > 0 ? round(($cancelledOrdersCount / $totalOrdersCount) * 100, 1) : 0 }}%
                </h3>
                <p class="text-muted text-xs mb-0">Tổng cộng {{ $cancelledOrdersCount }} đơn bị hủy</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <!-- Payment Methods Card -->
            <div class="crm-table-card-wrapper p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-wallet text-success me-2"></i>Phương thức thanh toán & Dòng tiền</h6>
                <div class="d-flex flex-column gap-2">
                    @forelse($paymentMethodStats as $stat)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border">
                            <div class="d-flex align-items-center">
                                <div class="me-3 fs-5">
                                    @if($stat->payment_method === 'COD')
                                        <span class="p-2 bg-warning-subtle text-warning-emphasis rounded-circle"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                                    @elseif($stat->payment_method === 'VIETQR')
                                        <span class="p-2 bg-primary-subtle text-primary rounded-circle"><i class="fa-solid fa-qrcode"></i></span>
                                    @else
                                        <span class="p-2 bg-success-subtle text-success rounded-circle"><i class="fa-solid fa-credit-card"></i></span>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 text-xs">{{ $stat->payment_method }}</h6>
                                    <span class="text-muted text-xs">{{ $stat->count }} giao dịch phát sinh</span>
                                </div>
                            </div>
                            <span class="fw-bold text-success fs-6">{{ number_format($stat->total, 0, ',', '.') }}đ</span>
                        </div>
                    @empty
                        <div class="text-center text-muted small py-3">Chưa phát sinh giao dịch thanh toán thành công</div>
                    @endforelse
                </div>
            </div>

            <!-- Top Selling Products Table -->
            <div class="crm-table-card-wrapper">
                <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-star text-warning me-2"></i>Top 5 vật tư bán chạy nhất vụ này</h6>
                    <span class="badge badge-status-green">Doanh số cao</span>
                </div>
                <div class="table-responsive">
                    <table class="table crm-data-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">MẶT HÀNG VẬT TƯ</th>
                                <th>QUY CÁCH</th>
                                <th class="text-center">SỐ LƯỢNG BÁN</th>
                                <th class="pe-4 text-end">DOANH THU THU VỀ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $prod)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-circle me-2.5 bg-dark text-white fw-bold" style="width: 22px; height: 22px; line-height: 16px; font-size: 11px;">
                                                {{ $index + 1 }}
                                            </span>
                                            <div>
                                                <span class="crm-cell-title">{{ $prod->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-secondary text-xs">{{ $prod->packaging }} ({{ $prod->unit }})</td>
                                    <td class="text-center">
                                        <span class="badge badge-tag-blue">
                                            {{ number_format($prod->total_qty) }} {{ $prod->unit }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end fw-bold text-success fs-6">{{ number_format($prod->total_revenue, 0, ',', '.') }}đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">Không phát sinh sản phẩm bán ra trong thời gian lọc.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline -->
        <div class="col-lg-4">
            <div class="crm-table-card-wrapper p-4 h-100">
                <h6 class="fw-bold text-dark mb-4"><i class="fa-solid fa-truck-ramp-box text-success me-2"></i>Trạng thái kho bãi (Timeline)</h6>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-warning bg-warning-subtle text-warning-emphasis">
                        <div>
                            <span class="d-block fw-bold text-xs mb-0.5">Chờ duyệt xuất kho</span>
                            <span class="text-muted opacity-75" style="font-size: 11px;">Cần bốc xếp khẩn trương</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $pendingOrdersCount }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-info bg-info-subtle text-info-emphasis">
                        <div>
                            <span class="d-block fw-bold text-xs mb-0.5">Đang đóng gói hàng</span>
                            <span class="text-muted opacity-75" style="font-size: 11px;">Chuẩn bị hạ tải lên xe</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $processingOrdersCount }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-primary bg-primary-subtle text-primary-emphasis">
                        <div>
                            <span class="d-block fw-bold text-xs mb-0.5">Đang trung chuyển</span>
                            <span class="text-muted opacity-75" style="font-size: 11px;">Xe đang chạy khu vực miền Tây</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $shippingOrdersCount }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-success bg-success-subtle text-success-emphasis">
                        <div>
                            <span class="d-block fw-bold text-xs mb-0.5">Đã hoàn thành</span>
                            <span class="text-muted opacity-75" style="font-size: 11px;">Bàn giao & ký phiếu biên nhận</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $completedOrdersCount }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-danger bg-danger-subtle text-danger-emphasis">
                        <div>
                            <span class="d-block fw-bold text-xs mb-0.5">Đơn hàng bị hủy</span>
                            <span class="text-muted opacity-75" style="font-size: 11px;">Sai thông tin / hết tồn kho</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $cancelledOrdersCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 RECENT ORDERS CRM DATA TABLE (Tài sản bảng chính nội bộ EcoFarm) -->
    <div class="crm-table-card-wrapper">
        <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i>Lịch sử 10 đơn hàng phát sinh gần nhất</h6>
            <span class="badge badge-tag-blue">Thời gian thực</span>
        </div>
        <div class="table-responsive">
            <table class="table crm-data-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">MÃ ĐƠN & KHÁCH HÀNG</th>
                        <th>SỐ ĐIỆN THOẠI</th>
                        <th>ĐỊA CHỈ GIAO HÀNG</th>
                        <th>ĐỐI TƯỢNG</th>
                        <th>MỨC ƯU TIÊN</th>
                        <th>TRẠNG THÁI</th>
                        <th class="pe-4 text-end">TỔNG THANH TOÁN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="crm-cell-title text-dark">#ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="crm-cell-subtext">{{ $order->customer_name }}</span>
                            </td>
                            <td class="text-secondary"><i class="fa-solid fa-phone me-1 opacity-75"></i>{{ $order->customer_phone }}</td>
                            <td><span class="text-truncate d-inline-block text-secondary" style="max-width: 200px;">{{ $order->shipping_address }}</span></td>
                            <td>
                                @if($order->user && $order->user->role === 'agency')
                                    <span class="badge-tag-blue"><i class="fa-solid fa-building me-1"></i>Đại lý B2B</span>
                                @else
                                    <span class="badge-tag-gray"><i class="fa-solid fa-leaf me-1 text-success"></i>Nhà vườn</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'shipping')
                                    <span class="badge-flame-orange"><i class="fa-solid fa-fire"></i>🔥 5 Cháy Rực</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge-flame-yellow"><i class="fa-solid fa-fire"></i>🔥 3 Bén Lửa</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge-flame-red"><i class="fa-solid fa-fire"></i>🔥 Khẩn cấp</span>
                                @else
                                    <span class="badge-tag-gray">🔥 Tắt Ngấm</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge-flame-red"><span class="status-dot-pulse dot-red"></span>Chờ duyệt</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge-flame-yellow"><span class="status-dot-pulse dot-yellow"></span>Đóng gói</span>
                                @elseif($order->status === 'shipping')
                                    <span class="badge-flame-orange"><span class="status-dot-pulse dot-blue"></span>Đang giao</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge-status-green"><span class="status-dot-pulse dot-green"></span>Hoàn thành</span>
                                @else
                                    <span class="badge-tag-gray"><span class="status-dot-pulse dot-red"></span>Đã hủy</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end fw-bold text-danger fs-6">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Không tìm thấy đơn hàng nào phát sinh trong khoảng thời gian đã lọc.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
