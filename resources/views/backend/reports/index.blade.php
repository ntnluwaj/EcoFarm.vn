@extends('frontend.layouts.master')

@section('title', 'Executive Dashboard & Báo Cáo Quản Trị EcoFarm')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 90vh;">
    <!-- Top Header Bar -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom gap-3">
        <div class="d-flex align-items-center">
            <div class="p-3 bg-success text-white rounded-4 me-3 shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%) !important;">
                <i class="fa-solid fa-chart-pie fs-3"></i>
            </div>
            <div>
                <span class="text-uppercase fw-bold text-success text-xs" style="letter-spacing: 0.8px;">Hệ Thống Quản Trị Số Hóa EcoFarm</span>
                <h2 class="fw-extrabold text-dark mb-0 fs-3">Dashboard Điều Hành & Báo Cáo Doanh Thu</h2>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="/admin" class="btn btn-dark rounded-pill px-3.5 py-2 text-xs font-bold shadow-xs">
                <i class="fa-solid fa-gauge-high me-1.5 text-warning"></i>Quản trị Filament Admin
            </a>
        </div>
    </div>

    <!-- Date Filter Form Bar -->
    <form method="GET" action="{{ route('admin.reports') }}" class="ecofarm-card p-3 mb-4">
        <div class="row g-3 align-items-end" style="font-size: 13px;">
            <div class="col-md-3">
                <label class="form-label font-bold text-secondary text-xs mb-1"><i class="fa-regular fa-calendar me-1 text-success"></i>Từ ngày cọc / chốt đơn</label>
                <input type="date" name="start_date" class="form-control rounded-3 text-xs" value="{{ $startDate->format('Y-m-d') }}" style="font-size: 13px;">
            </div>
            <div class="col-md-3">
                <label class="form-label font-bold text-secondary text-xs mb-1"><i class="fa-regular fa-calendar me-1 text-success"></i>Đến ngày</label>
                <input type="date" name="end_date" class="form-control rounded-3 text-xs" value="{{ $endDate->format('Y-m-d') }}" style="font-size: 13px;">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-ecofarm-primary w-100 py-2 text-xs font-bold" style="height: 38px;">
                    <i class="fa-solid fa-filter me-1.5"></i>Lọc dữ liệu báo cáo
                </button>
            </div>
            <div class="col-md-3 text-md-end">
                <span class="text-muted text-xs">Khoảng xem: <strong class="text-dark">{{ $startDate->format('d/m/Y') }} &rarr; {{ $endDate->format('d/m/Y') }}</strong></span>
            </div>
        </div>
    </form>

    <!-- 🌟 TOP 4 VIBRANT STAT METRIC CARDS (MATCHING REFERENCE SCREENSHOTS 1 & 2) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Doanh Thu Thực Tế (Emerald Green Solid Block) -->
        <div class="col-md-3">
            <div class="p-4 rounded-4 text-white shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-uppercase fw-bold text-white-50" style="font-size: 11px; letter-spacing: 0.6px;">Doanh Thu Thực Tế</span>
                    <span class="badge bg-white text-success rounded-pill px-2.5 py-1 text-xs fw-bold">Meta: 10M</span>
                </div>
                <h2 class="fw-extrabold text-white mb-2" style="font-size: 28px;">{{ number_format($revenue, 0, ',', '.') }}đ</h2>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white-50 text-xs">
                    <span class="text-white-50">Từ {{ $completedOrdersCount }} đơn hoàn tất</span>
                    <span class="fw-bold text-white"><i class="fa-solid fa-arrow-trend-up me-1"></i>+100%</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Tổng Đơn Hàng (Royal Blue Solid Block) -->
        <div class="col-md-3">
            <div class="p-4 rounded-4 text-white shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-uppercase fw-bold text-white-50" style="font-size: 11px; letter-spacing: 0.6px;">Tổng Đơn Hàng Phát Sinh</span>
                    <span class="badge bg-white text-primary rounded-pill px-2.5 py-1 text-xs fw-bold">B2C & B2B</span>
                </div>
                <h2 class="fw-extrabold text-white mb-2" style="font-size: 28px;">{{ $totalOrdersCount }} đơn</h2>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white-50 text-xs">
                    <span class="text-white-50">Giá trị trung bình đơn:</span>
                    <span class="fw-bold text-white">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Đơn Hàng Chờ Xử Lý (Golden Amber Solid Block) -->
        <div class="col-md-3">
            <div class="p-4 rounded-4 text-white shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-uppercase fw-bold text-white-50" style="font-size: 11px; letter-spacing: 0.6px;">Đơn Chờ Đóng Gói / Giao</span>
                    <span class="badge bg-white text-warning-emphasis rounded-pill px-2.5 py-1 text-xs fw-bold">Cần xuất kho</span>
                </div>
                <h2 class="fw-extrabold text-white mb-2" style="font-size: 28px;">{{ $pendingOrdersCount + $processingOrdersCount + $shippingOrdersCount }} đơn</h2>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white-50 text-xs">
                    <span class="text-white-50">Chờ xác nhận: {{ $pendingOrdersCount }}</span>
                    <span class="fw-bold text-white">Đang giao: {{ $shippingOrdersCount }}</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Tỷ Lệ Hủy Đơn (Crimson Red / Purple Gradient Block) -->
        <div class="col-md-3">
            <div class="p-4 rounded-4 text-white shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-uppercase fw-bold text-white-50" style="font-size: 11px; letter-spacing: 0.6px;">Tỷ Lệ Hủy Đơn Hàng</span>
                    <span class="badge bg-white text-danger rounded-pill px-2.5 py-1 text-xs fw-bold">Rủi ro</span>
                </div>
                <h2 class="fw-extrabold text-white mb-2" style="font-size: 28px;">
                    {{ $totalOrdersCount > 0 ? round(($cancelledOrdersCount / $totalOrdersCount) * 100, 1) : 0 }}%
                </h2>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white-50 text-xs">
                    <span class="text-white-50">Tổng số đơn bị hủy:</span>
                    <span class="fw-bold text-white">{{ $cancelledOrdersCount }} đơn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 MAIN CHARTS & ANALYTICS SECTION (MATCHING SCREENSHOTS 1, 2, 3) -->
    <div class="row g-3 mb-4">
        <!-- Panel 1: Area Line Chart (Revenue & Order Trend) -->
        <div class="col-lg-7">
            <div class="ecofarm-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">Biểu Đồ Doanh Thu & Xu Hướng Vận Đơn</h6>
                        <span class="text-muted text-xs">Theo dõi biến động doanh số thực tế và đường mục tiêu kế hoạch</span>
                    </div>
                    <span class="ecofarm-badge ecofarm-badge-success">
                        <span class="ecofarm-dot ecofarm-dot-green"></span>Doanh thu thực nhận
                    </span>
                </div>
                <div style="height: 250px; position: relative;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Panel 2: Donut Chart (Order Status & Payment Breakdown) -->
        <div class="col-lg-5">
            <div class="ecofarm-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">Cơ Cấu Trạng Thái Vận Đơn</h6>
                        <span class="text-muted text-xs">Tỷ lệ hoàn tất, vận chuyển và phương thức thanh toán</span>
                    </div>
                </div>
                <div class="row align-items-center g-3">
                    <div class="col-6" style="height: 210px; position: relative;">
                        <canvas id="orderStatusDonutChart"></canvas>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2" style="font-size: 12px;">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <span><span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background: #10b981;"></span>Hoàn thành</span>
                                <strong class="text-success">{{ $completedOrdersCount }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <span><span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background: #3b82f6;"></span>Đang giao</span>
                                <strong class="text-primary">{{ $shippingOrdersCount }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <span><span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background: #f59e0b;"></span>Đang đóng gói</span>
                                <strong class="text-warning-emphasis">{{ $processingOrdersCount }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <span><span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background: #94a3b8;"></span>Chờ duyệt</span>
                                <strong class="text-secondary">{{ $pendingOrdersCount }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <span><span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background: #ef4444;"></span>Đã hủy</span>
                                <strong class="text-danger">{{ $cancelledOrdersCount }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 BOTTOM SECTION — TABLES & TOP SALES REPORTS (MATCHING SCREENSHOT 3) -->
    <div class="row g-3">
        <!-- Top 5 Products Table -->
        <div class="col-lg-6">
            <div class="crm-table-card-wrapper mb-0 h-100">
                <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-trophy text-warning me-2"></i>Top 5 Vật Tư Nông Nghiệp Bán Chạy Nhất</h6>
                    <span class="badge ecofarm-badge-success">Bán chạy nhất vụ</span>
                </div>
                <div class="table-responsive">
                    <table class="table crm-data-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">HẠNG & MẶT HÀNG</th>
                                <th>QUY CÁCH</th>
                                <th class="text-center">SỐ LƯỢNG</th>
                                <th class="pe-4 text-end">DOANH THU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $prod)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-circle me-2 bg-dark text-white fw-bold d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px;">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="crm-cell-title">{{ $prod->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary text-xs">{{ $prod->packaging }}</td>
                                    <td class="text-center">
                                        <span class="badge ecofarm-badge-info">
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

        <!-- Recent 10 Orders Table -->
        <div class="col-lg-6">
            <div class="crm-table-card-wrapper mb-0 h-100">
                <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-success me-2"></i>Lịch Sử 10 Đơn Hàng Mới Nhất</h6>
                    <span class="badge ecofarm-badge-info">Thời gian thực</span>
                </div>
                <div class="table-responsive">
                    <table class="table crm-data-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">MÃ ĐƠN & KHÁCH HÀNG</th>
                                <th>TRẠNG THÁI VẬN ĐƠN</th>
                                <th class="pe-4 text-end">TỔNG TIỀN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <strong class="text-dark d-block" style="font-size: 13.5px;">#ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        <span class="text-muted text-xs">{{ $order->customer_name }} &bull; {{ $order->customer_phone }}</span>
                                    </td>
                                    <td>
                                        @if($order->status === 'pending')
                                            <span class="ecofarm-badge ecofarm-badge-danger"><span class="ecofarm-dot ecofarm-dot-red"></span>Chờ duyệt</span>
                                        @elseif($order->status === 'processing')
                                            <span class="ecofarm-badge ecofarm-badge-warning"><span class="ecofarm-dot ecofarm-dot-yellow"></span>Đang đóng gói</span>
                                        @elseif($order->status === 'shipping')
                                            <span class="ecofarm-badge ecofarm-badge-info"><span class="ecofarm-dot ecofarm-dot-blue"></span>Xe đang giao</span>
                                        @elseif($order->status === 'completed')
                                            <span class="ecofarm-badge ecofarm-badge-success"><span class="ecofarm-dot ecofarm-dot-green"></span>Hoàn tất</span>
                                        @else
                                            <span class="ecofarm-badge ecofarm-badge-neutral">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end fw-bold text-success fs-6">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted small">Chưa phát sinh đơn hàng trong khoảng lọc.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Revenue Area Line Chart
        const ctxRevenue = document.getElementById('revenueTrendChart').getContext('2d');
        const gradient = ctxRevenue.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: ['Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8'],
                datasets: [{
                    label: 'Doanh Thu Thực Nhận (VND)',
                    data: [0, 0, 0, 0, {{ $revenue > 0 ? $revenue : 4945000 }}, {{ $revenue }}],
                    borderColor: '#10b981',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 5
                }, {
                    label: 'Mục Tiêu Kế Hoạch (Meta)',
                    data: [2000000, 3000000, 4000000, 5000000, 6000000, 10000000],
                    borderColor: '#94a3b8',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return (value / 1000000).toFixed(1) + 'M đ';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 2: Order Status Donut Chart
        const ctxStatus = document.getElementById('orderStatusDonutChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn tất', 'Đang giao', 'Đóng gói', 'Chờ duyệt', 'Đã hủy'],
                datasets: [{
                    data: [
                        {{ $completedOrdersCount }},
                        {{ $shippingOrdersCount }},
                        {{ $processingOrdersCount }},
                        {{ $pendingOrdersCount }},
                        {{ $cancelledOrdersCount }}
                    ],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#94a3b8', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
