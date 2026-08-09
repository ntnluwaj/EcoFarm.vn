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
        <div>
            <span class="badge badge-soft-success">
                <span class="status-dot status-dot-success"></span>Tổng cộng {{ $orders->count() }} đơn hàng
            </span>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Modern Data Table Card Container -->
        <div class="modern-table-card">
            <div class="table-responsive">
                <table class="table modern-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3 text-center" style="width: 13%;">Mã hóa đơn</th>
                            <th class="py-3" style="width: 22%;">Thời gian khởi tạo</th>
                            <th class="py-3 text-end" style="width: 18%;">Tổng tiền thanh toán</th>
                            <th class="py-3 text-center" style="width: 16%;">Trạng thái tiền</th>
                            <th class="py-3 text-center" style="width: 17%;">Hành trình vận đơn</th>
                            <th class="pe-4 py-3 text-center" style="width: 14%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <!-- Mã đơn -->
                                <td class="ps-4 text-center">
                                    <span class="order-code-badge">
                                        ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <!-- Thời gian -->
                                <td class="text-secondary">
                                    <i class="fa-regular fa-calendar-check me-1.5 opacity-75 text-success"></i>
                                    {{ $order->created_at->format('H:i - d/m/Y') }}
                                </td>

                                <!-- Tổng tiền -->
                                <td class="text-end fw-bold text-success fs-6">
                                    {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                </td>

                                <!-- Trạng thái thanh toán -->
                                <td class="text-center">
                                    @if($order->payment_status === 'paid')
                                        <span class="badge-soft-success">
                                            <span class="status-dot status-dot-success"></span>Đã trả tiền
                                        </span>
                                    @else
                                        <span class="badge-soft-warning">
                                            <span class="status-dot status-dot-warning"></span>Chưa thanh toán
                                        </span>
                                    @endif
                                </td>

                                <!-- Trạng thái vận đơn -->
                                <td class="text-center">
                                    @if($order->status === 'pending')
                                        <span class="badge-soft-secondary">
                                            <span class="status-dot status-dot-warning"></span>Chờ xác nhận
                                        </span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge-soft-primary">
                                            <span class="status-dot status-dot-primary"></span>Đang bốc xếp
                                        </span>
                                    @elseif($order->status === 'shipping')
                                        <span class="badge-soft-info">
                                            <span class="status-dot status-dot-info"></span>Xe đang giao
                                        </span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge-soft-success">
                                            <span class="status-dot status-dot-success"></span>Đã nhận hàng
                                        </span>
                                    @else
                                        <span class="badge-soft-danger">
                                            <span class="status-dot status-dot-danger"></span>Đã hủy đơn
                                        </span>
                                    @endif
                                </td>

                                <!-- Hành động -->
                                <td class="pe-4 text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-success btn-sm dropdown-toggle fw-semibold px-3 py-1.5 rounded-3 d-inline-flex align-items-center justify-content-center gap-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px; height: 32px;">
                                            <i class="fa-solid fa-gears"></i> Thao tác
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1 py-1" style="font-size: 13px; z-index: 1050;">
                                            <li>
                                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('orders.track', ['order_id' => $order->id, 'phone' => $order->customer_phone]) }}">
                                                    <i class="fa-solid fa-route text-warning" style="width: 16px;"></i> Xem tiến độ
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

                                    @if($order->status === 'pending')
                                        <!-- Modal Thay đổi thông tin -->
                                        <div class="modal fade text-start" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-bottom bg-light py-3">
                                                        <h6 class="modal-title fw-bold m-0 text-success"><i class="fa-solid fa-pen-to-square me-2"></i>Thay đổi thông tin đơn hàng ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('orders.updateInfo', $order->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body py-3">
                                                            <p class="small text-secondary mb-3">Quý khách có thể thay đổi địa chỉ giao hàng hoặc phương thức thanh toán khi đơn hàng đang ở trạng thái <strong>Chờ xác nhận</strong>.</p>
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

                                        <!-- Modal Hủy đơn hàng -->
                                        <div class="modal fade text-start" id="cancelOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-bottom bg-light py-3">
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
@endsection