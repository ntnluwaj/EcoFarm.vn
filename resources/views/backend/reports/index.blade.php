@extends('frontend.layouts.master')

@section('title', 'Báo Cáo Doanh Thu Bãi Kho EcoFarm')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-chart-line text-success me-2"></i>BÁO CÁO DOANH THU & KHO VẬN NỘI BỘ
            </h4>
            <p class="text-secondary small mb-0">Theo dõi dòng tiền bán lẻ B2C và hiệu suất vận hành bến bãi EcoFarm</p>
        </div>
        <div>
            <a href="/admin" class="btn btn-outline-success btn-sm fw-bold px-3 py-2 rounded-3">
                <i class="fa-solid fa-gauge me-1"></i>Vào Filament Admin
            </a>
        </div>
    </div>

    <!-- Date Filter Card -->
    <form method="GET" action="{{ route('admin.reports') }}" class="card border-0 shadow-sm p-4 rounded-4 mb-4 bg-white">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary small"><i class="fa-regular fa-calendar me-1"></i>Từ ngày</label>
                <input type="date" name="start_date" class="form-control rounded-3" value="{{ $startDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary small"><i class="fa-regular fa-calendar me-1"></i>Đến ngày</label>
                <input type="date" name="end_date" class="form-control rounded-3" value="{{ $endDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100 fw-bold rounded-3 py-2" style="background-color: #2e7d32; border: none;">
                    <i class="fa-solid fa-filter me-2"></i>Lọc dữ liệu báo cáo
                </button>
            </div>
        </div>
    </form>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-semibold small text-uppercase">Doanh thu thực tế</span>
                    <div class="p-2 bg-success-subtle text-success rounded-3"><i class="fa-solid fa-sack-dollar fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-success mb-1">{{ number_format($revenue, 0, ',', '.') }}đ</h3>
                <p class="text-muted small mb-0">Từ các đơn hàng hoàn tất</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Orders Count Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-semibold small text-uppercase">Tổng số đơn hàng</span>
                    <div class="p-2 bg-primary-subtle text-primary rounded-3"><i class="fa-solid fa-boxes-stacked fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-primary mb-1">{{ $totalOrdersCount }} đơn</h3>
                <p class="text-muted small mb-0">Chốt trong khoảng thời gian lọc</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Average Order Value Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-semibold small text-uppercase">Giá trị TB đơn</span>
                    <div class="p-2 bg-info-subtle text-info rounded-3"><i class="fa-solid fa-scale-balanced fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-info mb-1">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</h3>
                <p class="text-muted small mb-0">Tính trên đơn hoàn thành</p>
                <div class="position-absolute" style="right: -10px; bottom: -20px; opacity: 0.05;">
                    <i class="fa-solid fa-calculator" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>

        <!-- Completion Rate Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary fw-semibold small text-uppercase">Tỷ lệ hủy đơn</span>
                    <div class="p-2 bg-danger-subtle text-danger rounded-3"><i class="fa-solid fa-ban fs-5"></i></div>
                </div>
                <h3 class="fw-bold text-danger mb-1">
                    {{ $totalOrdersCount > 0 ? round(($cancelledOrdersCount / $totalOrdersCount) * 100, 1) : 0 }}%
                </h3>
                <p class="text-muted small mb-0">Tổng cộng {{ $cancelledOrdersCount }} đơn bị hủy</p>
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
            <!-- B2B vs B2C and Payments -->
            <div class="row g-4 mb-4">
                <!-- Payment Methods -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100">
                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-wallet text-success me-2"></i>Phương thức thanh toán</h6>
                        <div class="d-flex flex-column gap-2.5">
                            @forelse($paymentMethodStats as $stat)
                                <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 text-secondary">
                                            @if($stat->payment_method === 'COD')
                                                <i class="fa-solid fa-hand-holding-dollar text-warning"></i>
                                            @elseif($stat->payment_method === 'VIETQR')
                                                <i class="fa-solid fa-qrcode text-primary"></i>
                                            @else
                                                <i class="fa-solid fa-credit-card text-success"></i>
                                            @endif
                                        </div>
                                        <span class="small fw-semibold">{{ $stat->payment_method }}</span>
                                    </div>
                                    <span class="small fw-bold text-secondary">{{ number_format($stat->total, 0, ',', '.') }}đ ({{ $stat->count }} đơn)</span>
                                </div>
                            @empty
                                <div class="text-center text-muted small py-3">Chưa phát sinh giao dịch thanh toán thành công</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="p-4 border-bottom bg-white">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-star text-warning me-2"></i>Top 5 vật tư bán chạy nhất vụ này</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                        <thead class="table-light text-secondary fw-semibold">
                            <tr>
                                <th class="ps-4">Tên mặt hàng vật tư</th>
                                <th>Quy cách đóng gói</th>
                                <th class="text-center">Số lượng bán</th>
                                <th class="pe-4 text-end">Doanh thu thu về</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $prod)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $prod->name }}</td>
                                    <td>{{ $prod->packaging }} ({{ $prod->unit }})</td>
                                    <td class="text-center fw-semibold text-secondary">{{ number_format($prod->total_qty) }}</td>
                                    <td class="pe-4 text-end fw-bold text-success">{{ number_format($prod->total_revenue, 0, ',', '.') }}đ</td>
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

        <!-- Right Column: Warehouse Order Status Timeline -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100">
                <h6 class="fw-bold text-dark mb-4"><i class="fa-solid fa-truck-ramp-box text-success me-2"></i>Trạng thái kho bãi (Timeline)</h6>
                
                <!-- Status List -->
                <div class="d-flex flex-column gap-3.5 position-relative">
                    <!-- Pending Orders -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-warning bg-warning-subtle text-warning-emphasis">
                        <div>
                            <span class="d-block fw-bold mb-0.5">Chờ duyệt xuất kho</span>
                            <span class="small text-muted opacity-75">Cần bốc xếp khẩn trương</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $pendingOrdersCount }}</span>
                    </div>

                    <!-- Processing Orders -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-info bg-info-subtle text-info-emphasis">
                        <div>
                            <span class="d-block fw-bold mb-0.5">Đang đóng gói hàng</span>
                            <span class="small text-muted opacity-75">Chuẩn bị hạ tải lên xe</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $processingOrdersCount }}</span>
                    </div>

                    <!-- Shipping Orders -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-primary bg-primary-subtle text-primary-emphasis">
                        <div>
                            <span class="d-block fw-bold mb-0.5">Đang trung chuyển</span>
                            <span class="small text-muted opacity-75">Xe đang chạy khu vực miền Tây</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $shippingOrdersCount }}</span>
                    </div>

                    <!-- Completed Orders -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-success bg-success-subtle text-success-emphasis">
                        <div>
                            <span class="d-block fw-bold mb-0.5">Đã hoàn thành</span>
                            <span class="small text-muted opacity-75">Bàn giao & ký phiếu biên nhận</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $completedOrdersCount }}</span>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 border-start border-4 border-danger bg-danger-subtle text-danger-emphasis">
                        <div>
                            <span class="d-block fw-bold mb-0.5">Đơn hàng bị hủy</span>
                            <span class="small text-muted opacity-75">Sai thông tin / hết tồn kho</span>
                        </div>
                        <span class="fs-4 fw-bold">{{ $cancelledOrdersCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="p-4 border-bottom bg-white">
            <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i>Lịch sử 10 đơn hàng phát sinh gần nhất</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                <thead class="table-light text-secondary fw-semibold">
                    <tr>
                        <th class="ps-4">Mã đơn</th>
                        <th>Họ tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Đối tượng</th>
                        <th>Trạng thái</th>
                        <th class="pe-4 text-end">Tổng thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 250px;">{{ $order->shipping_address }}</span></td>
                            <td>
                                @if($order->user && $order->user->role === 'agency')
                                    <span class="badge bg-primary text-white">Đại lý B2B</span>
                                @else
                                    <span class="badge bg-light text-secondary border">Nhà vườn</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge bg-info text-dark">Đóng gói</span>
                                @elseif($order->status === 'shipping')
                                    <span class="badge bg-primary text-white">Đang giao</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-success text-white">Hoàn thành</span>
                                @else
                                    <span class="badge bg-danger text-white">Đã hủy</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
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
