@extends('frontend.layouts.master')

@section('title', 'Lịch sử đặt hàng vật tư cá nhân')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center">
            <div class="bg-success-subtle text-success p-3 rounded-circle me-3">
                <i class="fa-solid fa-clock-rotate-left fs-4"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-1">Lịch sử đặt hàng vật tư cá nhân</h3>
                <p class="text-muted small mb-0">Theo dõi danh sách hóa đơn, trạng thái thanh toán và hành trình giao nhận vật tư của bạn.</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-status-green font-semibold">
                <span class="status-dot-pulse dot-green"></span>Tổng cộng {{ $orders->count() }} đơn hàng
            </span>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- 🌟 CRM TABLE CARD WRAPPER MATCHING SCREENSHOT DESIGN -->
        <div class="crm-table-card-wrapper">
            <!-- Filter Bar above table (Search + Pill filters matching screenshot 1) -->
            <div class="crm-table-filter-bar">
                <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                    <div class="position-relative flex-grow-1">
                        <i class="fa-solid fa-magnifying-glass crm-search-icon-inside"></i>
                        <input type="text" id="orderSearchInput" class="crm-table-search-input" placeholder="Tìm theo mã đơn ECF..., địa chỉ giao hàng, SĐT...">
                    </div>
                </div>

                <!-- Quick Filter Pills -->
                <div class="crm-filter-pill-group">
                    <button type="button" class="crm-filter-pill active" onclick="filterTable('all')">Tất cả <span class="pill-count">{{ $orders->count() }}</span></button>
                    <button type="button" class="crm-filter-pill" onclick="filterTable('paid')">Đã thanh toán <span class="pill-count">{{ $orders->where('payment_status', 'paid')->count() }}</span></button>
                    <button type="button" class="crm-filter-pill" onclick="filterTable('unpaid')">Chưa thanh toán <span class="pill-count">{{ $orders->where('payment_status', '!=', 'paid')->count() }}</span></button>
                    <button type="button" class="crm-filter-pill" onclick="filterTable('shipping')">Đang giao hàng <span class="pill-count">{{ $orders->where('status', 'shipping')->count() }}</span></button>
                    <button type="button" class="crm-filter-pill" onclick="filterTable('completed')">Đã hoàn thành <span class="pill-count">{{ $orders->where('status', 'completed')->count() }}</span></button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table crm-data-table align-middle mb-0" id="ordersDataTable">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3" style="width: 40px;"><input class="form-check-input" type="checkbox"></th>
                            <th class="py-3" style="width: 22%;">MÃ ĐƠN & KHÁCH HÀNG</th>
                            <th class="py-3" style="width: 16%;">MỨC ƯU TIÊN</th>
                            <th class="py-3 text-center" style="width: 16%;">THANH TOÁN</th>
                            <th class="py-3 text-center" style="width: 16%;">VẬN ĐƠN</th>
                            <th class="py-3 text-center" style="width: 15%;">NGÀY ĐẶT</th>
                            <th class="py-3 text-end" style="width: 15%;">TỔNG TIỀN</th>
                            <th class="pe-4 py-3 text-center" style="width: 10%;">THAO TÁC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="order-row-item" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
                                <!-- Checkbox -->
                                <td class="ps-4"><input class="form-check-input" type="checkbox"></td>

                                <!-- Mã đơn & Khách hàng -->
                                <td>
                                    <span class="crm-cell-title text-success">ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    <span class="crm-cell-subtext"><i class="fa-solid fa-user me-1 text-muted"></i>{{ $order->customer_name }} &bull; {{ $order->customer_phone }}</span>
                                </td>

                                <!-- Mức ưu tiên (Flame badges matching screenshots) -->
                                <td>
                                    @if($order->status === 'shipping')
                                        <span class="badge-flame-orange"><i class="fa-solid fa-fire"></i>🔥 5 Cháy Rực</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge-flame-yellow"><i class="fa-solid fa-fire"></i>🔥 3 Bén Lửa</span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge-flame-red"><i class="fa-solid fa-fire"></i>🔥 Khẩn cấp</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge-tag-blue"><i class="fa-solid fa-check me-1"></i>Đã xong</span>
                                    @else
                                        <span class="badge-tag-gray">🔥 Tắt Ngấm</span>
                                    @endif
                                </td>

                                <!-- Thanh toán -->
                                <td class="text-center">
                                    @if($order->payment_status === 'paid')
                                        <span class="badge-status-green">
                                            <span class="status-dot-pulse dot-green"></span>Đã trả tiền ({{ strtoupper($order->payment_method) }})
                                        </span>
                                    @else
                                        <span class="badge-flame-yellow">
                                            <span class="status-dot-pulse dot-yellow"></span>Chưa thanh toán
                                        </span>
                                    @endif
                                </td>

                                <!-- Trạng thái vận đơn -->
                                <td class="text-center">
                                    @if($order->status === 'pending')
                                        <span class="badge-tag-gray"><span class="status-dot-pulse dot-yellow"></span>Chờ xác nhận</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge-tag-blue"><span class="status-dot-pulse dot-blue"></span>Đang bốc xếp</span>
                                    @elseif($order->status === 'shipping')
                                        <span class="badge-flame-orange"><span class="status-dot-pulse dot-blue"></span>Xe đang giao</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge-status-green"><span class="status-dot-pulse dot-green"></span>Đã nhận hàng</span>
                                    @else
                                        <span class="badge-flame-red"><span class="status-dot-pulse dot-red"></span>Đã hủy đơn</span>
                                    @endif
                                </td>

                                <!-- Ngày đặt -->
                                <td class="text-center text-secondary text-xs">
                                    {{ $order->created_at->format('H:i d/m/Y') }}
                                </td>

                                <!-- Tổng tiền -->
                                <td class="text-end fw-bold text-success fs-6">
                                    {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                </td>

                                <!-- Action Buttons -->
                                <td class="pe-4 text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle border p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-ellipsis-vertical text-secondary"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1 py-1" style="font-size: 13px; z-index: 1050;">
                                            <li>
                                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('orders.track', ['order_id' => $order->id, 'phone' => $order->customer_phone]) }}">
                                                    <i class="fa-solid fa-route text-warning" style="width: 16px;"></i> Xem hành trình
                                                </a>
                                            </li>
                                            @if($order->status === 'pending')
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                                                        <i class="fa-solid fa-pen-to-square text-primary" style="width: 16px;"></i> Sửa thông tin
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal{{ $order->id }}">
                                                        <i class="fa-solid fa-circle-xmark text-danger" style="width: 16px;"></i> Hủy đơn hàng
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    @if($order->status === 'pending')
                                        <!-- Modal Sửa thông tin -->
                                        <div class="modal fade text-start" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-bottom bg-light py-3">
                                                        <h6 class="modal-title fw-bold m-0 text-success"><i class="fa-solid fa-pen-to-square me-2"></i>Thay đổi thông tin ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('orders.updateInfo', $order->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body py-3">
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold text-dark">Địa chỉ giao hàng mới <span class="text-danger">*</span></label>
                                                                <input type="text" name="shipping_address" class="form-control rounded-3 text-xs" value="{{ $order->shipping_address }}" required style="font-size: 13px;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold text-dark mb-2">Phương thức thanh toán <span class="text-danger">*</span></label>
                                                                <div class="d-flex flex-column gap-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_cod_{{ $order->id }}" value="cod" {{ strtolower($order->payment_method) === 'cod' ? 'checked' : '' }}>
                                                                        <label class="form-check-label text-dark text-xs" for="pay_cod_{{ $order->id }}">💵 Trả tiền mặt khi giao hàng (COD)</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_vietqr_{{ $order->id }}" value="vietqr" {{ strtolower($order->payment_method) === 'vietqr' ? 'checked' : '' }}>
                                                                        <label class="form-check-label text-dark text-xs" for="pay_vietqr_{{ $order->id }}">🏦 Chuyển khoản ngân hàng (VietQR)</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light py-2">
                                                            <button type="button" class="btn btn-light btn-sm fw-semibold rounded-3 text-xs" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-success btn-sm fw-bold rounded-3 text-xs" style="background-color: #2e7d32; border: none;">LƯU THAY ĐỔI</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hủy đơn -->
                                        <div class="modal fade text-start" id="cancelOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-bottom bg-light py-3">
                                                        <h6 class="modal-title fw-bold m-0 text-danger"><i class="fa-solid fa-ban me-2"></i>Hủy đơn ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body py-3">
                                                            <label class="form-label small fw-bold text-dark">Lý do hủy đơn hàng <span class="text-danger">*</span></label>
                                                            <textarea name="cancel_reason" rows="3" class="form-control rounded-3 text-xs" placeholder="Nhập lý do hủy..." required style="font-size: 12px; resize: none;"></textarea>
                                                        </div>
                                                        <div class="modal-footer bg-light py-2">
                                                            <button type="button" class="btn btn-light btn-sm fw-semibold rounded-3 text-xs" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-danger btn-sm fw-bold rounded-3 text-xs">XÁC NHẬN HỦY</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
            <div class="text-muted mb-3">
                <i class="fa-solid fa-box-open opacity-25" style="font-size: 70px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Chưa có lịch sử giao dịch</h5>
            <p class="text-muted small mb-4">Bạn chưa thực hiện đặt mua mặt hàng vật tư nào trên hệ thống.</p>
            <a href="{{ route('products.index') }}" class="btn btn-success fw-bold px-4 py-2 rounded-3 text-xs" style="background-color: #2e7d32; border: none;">
                <i class="fa-solid fa-basket-shopping me-2"></i>Khám phá danh mục vật tư
            </a>
        </div>
    @endif
</div>

<script>
    // Live Search Filter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('orderSearchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const q = this.value.toLowerCase();
                const rows = document.querySelectorAll('.order-row-item');
                rows.forEach(r => {
                    r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        }
    });

    // Quick Pill Filter Function
    function filterTable(filter) {
        // Toggle Active Pill Button Style
        const buttons = document.querySelectorAll('.crm-filter-pill');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        const rows = document.querySelectorAll('.order-row-item');
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const payment = row.getAttribute('data-payment');
            
            if (filter === 'all') {
                row.style.display = '';
            } else if (filter === 'paid') {
                row.style.display = payment === 'paid' ? '' : 'none';
            } else if (filter === 'unpaid') {
                row.style.display = payment !== 'paid' ? '' : 'none';
            } else if (filter === 'shipping') {
                row.style.display = status === 'shipping' ? '' : 'none';
            } else if (filter === 'completed') {
                row.style.display = status === 'completed' ? '' : 'none';
            }
        });
    }
</script>
@endsection