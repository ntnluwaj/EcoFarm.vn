@extends('frontend.layouts.master')

@section('title', 'Báo Cáo Doanh Thu Bãi Kho EcoFarm')

@section('content')
<div class="crm-table-container container my-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-chart-line text-success me-2"></i>BÁO CÁO DOANH THU & KHO VẬN NỘI BỘ
            </h3>
            <p class="text-secondary small mb-0">Theo dõi dòng tiền bán lẻ B2C, hiệu suất giao nhận và cơ cấu phân bổ vận đơn EcoFarm</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill font-semibold shadow-xs" style="font-size: 12px;">
                <span class="status-dot-pulse dot-green me-1.5"></span>Cơ sở Cần Thơ & ĐBSCL
            </span>
            <a href="/admin" class="btn btn-outline-success btn-sm fw-bold px-3 py-2 rounded-pill">
                <i class="fa-solid fa-gauge me-1"></i>Vào Filament Admin
            </a>
        </div>
    </div>

    <!-- Date Filter Card -->
    <form method="GET" action="{{ route('admin.reports') }}" class="crm-filter-panel mb-4">
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

    <!-- Stat Cards (Vibrant Cards) -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-md-3">
            <div class="crm-card-row p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Doanh thu thực tế</span>
                    <div class="p-2 bg-success-subtle text-success rounded-circle"><i class="fa-solid fa-sack-dollar fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-success mb-1">{{ number_format($revenue, 0, ',', '.') }}đ</h3>
                <p class="text-muted text-xs mb-0">Từ các đơn hàng hoàn tất</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Orders Count Card -->
        <div class="col-md-3">
            <div class="crm-card-row p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Tổng số đơn hàng</span>
                    <div class="p-2 bg-primary-subtle text-primary rounded-circle"><i class="fa-solid fa-boxes-stacked fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-primary mb-1">{{ $totalOrdersCount }} đơn</h3>
                <p class="text-muted text-xs mb-0">Chốt trong khoảng thời gian lọc</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Average Order Value Card -->
        <div class="col-md-3">
            <div class="crm-card-row p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Giá trị TB đơn</span>
                    <div class="p-2 bg-info-subtle text-info rounded-circle"><i class="fa-solid fa-scale-balanced fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-info mb-1">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</h3>
                <p class="text-muted text-xs mb-0">Tính trên đơn hoàn thành</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-calculator" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Completion Rate Card -->
        <div class="col-md-3">
            <div class="crm-card-row p-4 mb-0 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-bold text-xs text-uppercase">Tỷ lệ hủy đơn</span>
                    <div class="p-2 bg-danger-subtle text-danger rounded-circle"><i class="fa-solid fa-ban fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-danger mb-1">
                    {{ $totalOrdersCount > 0 ? round(($cancelledOrdersCount / $totalOrdersCount) * 100, 1) : 0 }}%
                </h3>
                <p class="text-muted text-xs mb-0">Tổng cộng {{ $cancelledOrdersCount }} đơn bị hủy</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-trash-can" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4 mb-4">
        <!-- Left Column: Business Breakdown & Top Products -->
        <div class="col-lg-8">
            <!-- Payment Methods -->
            <div class="crm-filter-panel mb-4">
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

            <!-- Top Selling Products CRM Table -->
            <div class="crm-filter-panel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-star text-warning me-2"></i>Top 5 vật tư bán chạy nhất vụ này</h6>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 font-semibold text-xs">Doanh số cao</span>
                </div>
                <div class="table-responsive">
                    <table class="crm-table">
                        <thead>
                            <tr>
                                <th class="ps-3">STT / Tên vật tư</th>
                                <th>Quy cách</th>
                                <th class="text-center">Số lượng bán</th>
                                <th class="pe-3 text-end">Doanh thu thu về</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $prod)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-circle me-2.5 bg-dark text-white fw-bold" style="width: 24px; height: 24px; line-height: 18px; font-size: 11px;">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="fw-bold text-dark text-xs">{{ $prod->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary text-xs">{{ $prod->packaging }} ({{ $prod->unit }})</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill fw-bold text-xs">
                                            {{ number_format($prod->total_qty) }} {{ $prod->unit }}
                                        </span>
                                    </td>
                                    <td class="pe-3 text-end fw-bold text-success fs-6">{{ number_format($prod->total_revenue, 0, ',', '.') }}đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted text-xs">Không phát sinh sản phẩm bán ra trong thời gian lọc.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Warehouse Order Status Timeline -->
        <div class="col-lg-4">
            <div class="crm-filter-panel h-100">
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

    <!-- Recent Orders CRM Table -->
    <div class="crm-filter-panel">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i>Nhật ký 10 đơn hàng phát sinh gần nhất</h6>
            <span class="badge bg-light text-dark border px-3 py-1 rounded-pill text-xs">Cập nhật thời gian thực</span>
        </div>
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th class="ps-3">Mã đơn / Người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Đối tượng</th>
                        <th>Trạng thái</th>
                        <th class="pe-3 text-end">Tổng thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    @if($order->status === 'completed')
                                        <span class="status-dot-pulse dot-green me-2"></span>
                                    @elseif($order->status === 'shipping')
                                        <span class="status-dot-pulse dot-blue me-2"></span>
                                    @elseif($order->status === 'processing')
                                        <span class="status-dot-pulse dot-orange me-2"></span>
                                    @else
                                        <span class="status-dot-pulse dot-red me-2"></span>
                                    @endif
                                    <div>
                                        <span class="fw-bold text-dark d-block text-xs">ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-secondary text-xs">{{ $order->customer_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary text-xs"><i class="fa-solid fa-phone me-1 opacity-75"></i>{{ $order->customer_phone }}</td>
                            <td><span class="text-truncate d-inline-block text-secondary text-xs" style="max-width: 220px;">{{ $order->shipping_address }}</span></td>
                            <td>
                                @if($order->user && $order->user->role === 'agency')
                                    <span class="crm-badge badge-flame-orange"><i class="fa-solid fa-building me-1"></i>Đại lý B2B</span>
                                @else
                                    <span class="badge-tag-outline"><i class="fa-solid fa-leaf me-1 text-success"></i>Nhà vườn</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="crm-badge badge-flame-red"><i class="fa-solid fa-clock me-1"></i>Chờ duyệt</span>
                                @elseif($order->status === 'processing')
                                    <span class="crm-badge badge-flame-yellow"><i class="fa-solid fa-boxes-packing me-1"></i>Đóng gói</span>
                                @elseif($order->status === 'shipping')
                                    <span class="crm-badge badge-flame-orange"><i class="fa-solid fa-truck-fast me-1"></i>Đang giao</span>
                                @elseif($order->status === 'completed')
                                    <span class="crm-badge badge-pill-green"><i class="fa-solid fa-circle-check me-1"></i>Hoàn thành</span>
                                @else
                                    <span class="crm-badge badge-tag-outline text-danger border-danger-subtle">Đã hủy</span>
                                @endif
                            </td>
                            <td class="pe-3 text-end fw-bold text-danger text-xs fs-6">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted text-xs">Không tìm thấy đơn hàng nào phát sinh trong khoảng thời gian đã lọc.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
