@extends('frontend.layouts.master')

@section('title', 'Nhật ký & Lịch sử đặt hàng vật tư')

@section('content')
<div class="crm-table-container container my-5" style="min-height: 80vh;">
    <!-- CRM Top Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-receipt text-success me-2"></i>Nhật ký & Lịch sử đặt hàng vật tư
            </h3>
            <p class="text-secondary small mb-0">
                <span class="status-dot-pulse dot-green me-1"></span>
                <strong>{{ $orders->count() }} đơn hàng</strong> cá nhân trong hệ thống &bull; 
                <span class="text-success fw-bold">{{ $orders->where('payment_status', 'paid')->count() }} đơn đã thanh toán đối soát</span>
            </p>
        </div>
        <div>
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs font-semibold" style="font-size: 13px;">
                <i class="fa-regular fa-calendar-check text-success me-1.5"></i>Vụ Hè Thu 2026
            </span>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="row g-4">
            <!-- Left Filter & Breakdown Panel (Giống hệt giao diện CRM mẫu) -->
            <div class="col-lg-4">
                <div class="crm-filter-panel mb-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-sliders text-success me-2"></i>Bộ lọc nâng cao</h6>
                    
                    <!-- Search Input -->
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-secondary">Tìm kiếm nhanh</label>
                        <div class="crm-search-wrapper">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" id="orderSearchInput" class="crm-search-input" placeholder="Mã đơn ECF..., SĐT, tên người nhận...">
                        </div>
                    </div>

                    <!-- Date Filters -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-secondary">Từ ngày</label>
                            <input type="date" class="form-control form-control-sm rounded-3 text-xs" style="font-size: 12px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-secondary">Đến ngày</label>
                            <input type="date" class="form-control form-control-sm rounded-3 text-xs" style="font-size: 12px;">
                        </div>
                    </div>

                    <!-- Status Filter Pills -->
                    <div class="mb-4">
                        <label class="form-label text-xs fw-bold text-secondary mb-2 d-block">Trạng thái vận đơn</label>
                        <div class="d-flex flex-wrap gap-1.5">
                            <button type="button" class="btn-filter-pill active"><i class="fa-solid fa-layer-group me-1"></i>Tất cả</button>
                            <button type="button" class="btn-filter-pill"><i class="fa-solid fa-clock me-1 text-warning"></i>Chờ duyệt</button>
                            <button type="button" class="btn-filter-pill"><i class="fa-solid fa-boxes-packing me-1 text-primary"></i>Đóng gói</button>
                            <button type="button" class="btn-filter-pill"><i class="fa-solid fa-truck-fast me-1 text-info"></i>Đang giao</button>
                            <button type="button" class="btn-filter-pill"><i class="fa-solid fa-circle-check me-1 text-success"></i>Hoàn thành</button>
                        </div>
                    </div>

                    <!-- Content Distribution Bar Widget (Cơ cấu nội dung giống ảnh) -->
                    <div class="pt-3 border-top">
                        <h6 class="fw-bold text-dark mb-2 style="font-size: 13.5px;">Cơ cấu trạng thái đơn</h6>
                        <p class="text-muted text-xs mb-3">Tỷ lệ xử lý thành công bến bãi EcoFarm</p>
                        
                        @php
                            $completedCount = $orders->where('status', 'completed')->count();
                            $shippingCount = $orders->where('status', 'shipping')->count();
                            $pendingCount = $orders->where('status', 'pending')->count();
                            $total = max(1, $orders->count());
                            $completedPct = round(($completedCount / $total) * 100);
                            $shippingPct = round(($shippingCount / $total) * 100);
                            $pendingPct = round(($pendingCount / $total) * 100);
                        @endphp

                        <div class="mb-2">
                            <div class="d-flex justify-content-between text-xs mb-1">
                                <span class="fw-semibold text-success"><i class="fa-solid fa-circle me-1 fs-6"></i>Đã giao thành công</span>
                                <span class="fw-bold text-dark">{{ $completedPct }}%</span>
                            </div>
                            <div class="crm-progress-bar-bg mb-2">
                                <div class="crm-progress-bar-fill bg-success" style="width: {{ $completedPct }}%;"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between text-xs mb-1">
                                <span class="fw-semibold text-info"><i class="fa-solid fa-circle me-1 fs-6"></i>Xe đang trung chuyển</span>
                                <span class="fw-bold text-dark">{{ $shippingPct }}%</span>
                            </div>
                            <div class="crm-progress-bar-bg mb-2">
                                <div class="crm-progress-bar-fill bg-info" style="width: {{ $shippingPct }}%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between text-xs mb-1">
                                <span class="fw-semibold text-warning"><i class="fa-solid fa-circle me-1 fs-6"></i>Chờ xác nhận bốc xếp</span>
                                <span class="fw-bold text-dark">{{ $pendingPct }}%</span>
                            </div>
                            <div class="crm-progress-bar-bg">
                                <div class="crm-progress-bar-fill bg-warning" style="width: {{ $pendingPct }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Rows List (Giao diện thẻ hàng floating giống mẫu) -->
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-2" id="orderListContainer">
                    @foreach($orders as $order)
                        <div class="crm-card-row">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                <!-- Info Column -->
                                <div>
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-1.5">
                                        <!-- Pulsing status dot -->
                                        @if($order->status === 'completed')
                                            <span class="status-dot-pulse dot-green" title="Đã hoàn thành"></span>
                                        @elseif($order->status === 'shipping')
                                            <span class="status-dot-pulse dot-blue" title="Đang vận chuyển"></span>
                                        @elseif($order->status === 'processing')
                                            <span class="status-dot-pulse dot-orange" title="Đang bốc xếp"></span>
                                        @else
                                            <span class="status-dot-pulse dot-red" title="Chờ xử lý"></span>
                                        @endif

                                        <!-- Name & Code -->
                                        <h6 class="fw-bold text-dark mb-0 me-1" style="font-size: 15px;">
                                            ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} &bull; {{ $order->customer_name }}
                                        </h6>

                                        <!-- Flame Badges -->
                                        @if($order->status === 'shipping')
                                            <span class="crm-badge badge-flame-orange">
                                                <i class="fa-solid fa-fire me-1"></i>Đang vận chuyển
                                            </span>
                                        @elseif($order->status === 'completed')
                                            <span class="crm-badge badge-pill-green">
                                                <i class="fa-solid fa-circle-check me-1"></i>Đã giao thành công
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="crm-badge badge-flame-yellow">
                                                <i class="fa-solid fa-boxes-packing me-1"></i>Đang đóng gói
                                            </span>
                                        @elseif($order->status === 'pending')
                                            <span class="crm-badge badge-flame-red">
                                                <i class="fa-solid fa-clock me-1"></i>Chờ xác nhận
                                            </span>
                                        @else
                                            <span class="crm-badge badge-tag-outline">Đã hủy</span>
                                        @endif

                                        <!-- Payment status tag -->
                                        @if($order->payment_status === 'paid')
                                            <span class="badge-tag-outline text-success border-success-subtle">
                                                <i class="fa-solid fa-wallet me-1 text-success"></i>Đã trả tiền ({{ strtoupper($order->payment_method) }})
                                            </span>
                                        @else
                                            <span class="badge-tag-outline text-warning border-warning-subtle">
                                                <i class="fa-regular fa-clock me-1 text-warning"></i>Chưa thanh toán ({{ strtoupper($order->payment_method) }})
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Subtitle Note -->
                                    <div class="text-secondary text-xs d-flex align-items-center flex-wrap gap-3">
                                        <span><i class="fa-solid fa-location-dot me-1 text-muted"></i>{{ Str::limit($order->shipping_address, 45) }}</span>
                                        <span><i class="fa-solid fa-phone me-1 text-muted"></i>{{ $order->customer_phone }}</span>
                                        <span class="fw-bold text-success"><i class="fa-solid fa-sack-dollar me-1"></i>{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>

                                <!-- Right Metadata & Actions -->
                                <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-3 pt-2 pt-md-0 border-top border-md-0">
                                    <span class="text-muted text-xs font-semibold">
                                        <i class="fa-regular fa-calendar-check me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                    </span>

                                    <!-- Actions Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle p-2 shadow-xs border text-secondary hover-success" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 34px; height: 34px;">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-1" style="font-size: 13px; z-index: 1050;">
                                            <li>
                                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('orders.track', ['order_id' => $order->id, 'phone' => $order->customer_phone]) }}">
                                                    <i class="fa-solid fa-route text-warning" style="width: 16px;"></i> Xem hành trình
                                                </a>
                                            </li>
                                            @if($order->status === 'pending')
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                                                        <i class="fa-solid fa-pen-to-square text-primary" style="width: 16px;"></i> Thay đổi thông tin
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
                                </div>
                            </div>
                        </div>

                        <!-- Modals for Edit & Cancel -->
                        @if($order->status === 'pending')
                            <div class="modal fade text-start" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-bottom border-light-subtle bg-light rounded-t-4 py-3">
                                            <h6 class="modal-title fw-bold m-0 text-success"><i class="fa-solid fa-pen-to-square me-2"></i>Thay đổi thông tin đơn hàng ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('orders.updateInfo', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body py-3">
                                                <p class="small text-secondary mb-3">Quý khách có thể thay đổi địa chỉ giao hàng hoặc phương thức thanh toán khi đơn hàng ở trạng thái <strong>Chờ xác nhận</strong>.</p>
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
                                                            <label class="form-check-label text-dark text-xs" for="pay_vietqr_{{ $order->id }}">🏦 Chuyển khoản ngân hàng nhanh (VietQR)</label>
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

                            <div class="modal fade text-start" id="cancelOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-bottom border-light-subtle bg-light rounded-t-4 py-3">
                                            <h6 class="modal-title fw-bold m-0"><i class="fa-solid fa-ban me-2"></i>Xác nhận hủy đơn hàng ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body py-3">
                                                <p class="small text-secondary mb-3">Bạn có chắc chắn muốn hủy đơn hàng này? Vui lòng điền lý do hủy đơn bên dưới:</p>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-dark">Lý do hủy đơn hàng <span class="text-danger">*</span></label>
                                                    <textarea name="cancel_reason" rows="3" class="form-control rounded-3 text-xs" placeholder="Ví dụ: Thay đổi địa điểm nhận hàng, muốn chọn sản phẩm khác..." required style="font-size: 12px; resize: none;"></textarea>
                                                </div>
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
                    @endforeach
                </div>
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
    // Live Search Filter cho danh sách đơn hàng
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('orderSearchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('.crm-card-row');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? 'block' : 'none';
                });
            });
        }
    });
</script>
@endsection