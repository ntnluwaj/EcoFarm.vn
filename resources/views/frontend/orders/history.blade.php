@extends('frontend.layouts.master')

@section('title', 'Lịch sử đặt hàng vật tư')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
        <div class="bg-success-subtle text-success p-3 rounded-circle me-3">
            <i class="fa-solid fa-clock-rotate-left fs-4"></i>
        </div>
        <div>
            <h3 class="fw-bold text-dark mb-1">Lịch sử đặt hàng vật tư cá nhân</h3>
            <p class="text-muted small mb-0">Theo dõi danh sách hóa đơn và trục đồ họa tiến độ giao nhận vật tư của bạn.</p>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase" style="border-bottom: 2px solid #eef2f3; font-size: 12px;">
                        <tr>
                            <th class="fw-bold text-center py-3" style="width: 12%;">Mã đơn</th>
                            <th class="fw-bold py-3" style="width: 22%;">Thời gian đặt đơn</th>
                            <th class="fw-bold text-end py-3" style="width: 18%;">Tổng tiền</th>
                            <th class="fw-bold text-center py-3" style="width: 16%;">Thanh toán</th>
                            <th class="fw-bold text-center py-3" style="width: 16%;">Trạng thái vận đơn</th>
                            <th class="fw-bold text-center py-3" style="width: 16%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark small">
                        @foreach($orders as $order)
                            <tr style="border-bottom: 1px solid #f1f4f5;">
                                <td class="text-center py-3">
                                    <span class="badge bg-danger-subtle text-danger fw-bold px-2.5 py-1.5 rounded-3" style="font-size: 12px;">
                                        ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                
                                <td class="text-secondary py-3">
                                    <i class="fa-regular fa-calendar me-1.5 opacity-75"></i>{{ $order->created_at->format('H:i - d/m/Y') }}
                                </td>
                                
                                <td class="text-end fw-bold text-success py-3 fs-6">
                                    {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                </td>
                                
                                <td class="text-center py-3">
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success-subtle text-success fw-semibold px-2.5 py-1.5 rounded-pill border border-success-subtle" style="font-size: 11px;">
                                            <i class="fa-solid fa-circle-check me-1"></i>Đã trả tiền
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis fw-semibold px-2.5 py-1.5 rounded-pill border border-warning-subtle" style="font-size: 11px;">
                                            <i class="fa-solid fa-clock me-1"></i>Chưa thanh toán
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="text-center py-3">
                                    @if($order->status === 'pending')
                                        <span class="badge bg-light text-dark border fw-medium px-2.5 py-1.5 rounded-3" style="font-size: 11px;">Chờ xác nhận</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-medium px-2.5 py-1.5 rounded-3" style="font-size: 11px;">Đang bốc xếp</span>
                                    @elseif($order->status === 'shipping')
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fw-medium px-2.5 py-1.5 rounded-3" style="font-size: 11px;">Xe đang vận chuyển</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge bg-success text-white fw-medium px-2.5 py-1.5 rounded-3" style="font-size: 11px;">Đã nhận hàng</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-medium px-2.5 py-1.5 rounded-3" style="font-size: 11px;">Đã hủy đơn</span>
                                    @endif
                                </td>
                                
                                <td class="text-center py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('orders.track', ['order_id' => $order->id, 'phone' => $order->customer_phone]) }}" class="btn btn-warning btn-sm fw-bold px-3 py-1.5 rounded-3 shadow-xs text-dark transition-all" style="background-color: #ffc107; border: none; font-size: 12px;">
                                            <i class="fa-solid fa-route me-1"></i>Xem tiến độ
                                        </a>

                                        @if($order->status === 'pending')
                                            <button type="button" class="btn btn-outline-primary btn-sm fw-bold px-3 py-1.5 rounded-3 transition-all" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                                                <i class="fa-solid fa-pen-to-square me-1"></i>Thay đổi thông tin
                                            </button>

                                            <button type="button" class="btn btn-outline-danger btn-sm fw-bold px-3 py-1.5 rounded-3 transition-all" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#cancelOrderModal{{ $order->id }}">
                                                <i class="fa-solid fa-circle-xmark me-1"></i>Hủy đơn
                                            </button>

                                            <!-- Modal Thay đổi thông tin đơn hàng -->
                                            <div class="modal fade text-start" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <div class="modal-header border-bottom border-light-subtle bg-light rounded-t-4 py-3">
                                                            <h6 class="modal-title fw-bold m-0"><i class="fa-solid fa-pen-to-square me-2 text-success"></i>Thay đổi thông tin đơn hàng ECF{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('orders.updateInfo', $order->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body py-3">
                                                                <p class="small text-secondary mb-3">Quý khách có thể thay đổi địa chỉ giao hàng hoặc phương thức thanh toán khi đơn hàng đang ở trạng thái <strong>Chờ xác nhận</strong>.</p>
                                                                
                                                                <!-- Địa chỉ giao hàng -->
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold text-dark">Địa chỉ giao hàng mới <span class="text-danger">*</span></label>
                                                                    <input type="text" name="shipping_address" class="form-control rounded-3 text-xs" value="{{ $order->shipping_address }}" required style="font-size: 13px;">
                                                                </div>

                                                                <!-- Phương thức thanh toán -->
                                                                <div class="mb-3">
                                                                    <label class="form-label small fw-bold text-dark mb-2">Phương thức thanh toán <span class="text-danger">*</span></label>
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="payment_method" id="pay_cod_{{ $order->id }}" value="cod" {{ strtolower($order->payment_method) === 'cod' ? 'checked' : '' }}>
                                                                            <label class="form-check-label text-dark text-xs" for="pay_cod_{{ $order->id }}">
                                                                                💵 Trả tiền mặt khi giao hàng (COD)
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="payment_method" id="pay_vietqr_{{ $order->id }}" value="vietqr" {{ strtolower($order->payment_method) === 'vietqr' ? 'checked' : '' }}>
                                                                            <label class="form-check-label text-dark text-xs" for="pay_vietqr_{{ $order->id }}">
                                                                                🏦 Chuyển khoản ngân hàng nhanh (VietQR)
                                                                            </label>
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
                                                                    <textarea name="cancel_reason" rows="3" class="form-control rounded-3 text-xs" placeholder="Ví dụ: Thay đổi địa điểm nhận hàng, muốn chọn sản phẩm khác, đặt trùng đơn..." required style="font-size: 12px; resize: none;"></textarea>
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
                                    </div>
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

<style>
    /* 🌟 ĐÃ VÁ LỖI: Sửa bộ chọn .table hover thành .table-hover */
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    /* Nút xem tiến độ đổi màu mượt khi di chuột */
    .btn:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }
    .text-xs { font-size: 13px !important; }
</style>
@endsection