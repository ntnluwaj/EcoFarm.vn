@extends('frontend.layouts.master')

@section('title', 'Tích Lũy Điểm Thưởng & Đổi Quà - EcoFarm')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Tích lũy & Đổi quà</li>
        </ol>
    </nav>

    <!-- Points Summary Card -->
    <div class="card border-0 rounded-4 shadow-sm p-4 text-white mb-5 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%);">
        <div class="row align-items-center position-relative z-3">
            <div class="col-md-8">
                <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-2 text-uppercase shadow-sm">
                    <i class="fa-solid fa-medal me-1"></i> Chương Trình Khách Hàng Thân Thiết
                </span>
                <h2 class="fw-bold mb-2">Xin chào, {{ $user->name }}!</h2>
                <p class="text-white-50 mb-0 mb-md-3">Mua vật tư càng nhiều, tích điểm càng lớn, nhận ngàn ưu đãi hấp dẫn từ EcoFarm.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="d-inline-block bg-white bg-opacity-20 p-3 rounded-4 border border-white border-opacity-25" style="backdrop-filter: blur(5px);">
                    <span class="text-white-50 d-block small text-uppercase" style="font-size: 11px;">Điểm thưởng hiện tại</span>
                    <span class="fs-1 fw-bold text-warning" id="user-points" style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                        <i class="fa-solid fa-coins animate-bounce"></i>{{ number_format($user->reward_points) }}
                    </span>
                    <span class="text-white d-block small" style="font-size: 11px;">Điểm</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Reward Store Section -->
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-gift text-success me-2"></i>Cửa Hàng Đổi Quà (Voucher Store)</h4>
        <p class="text-muted small">Sử dụng điểm thưởng tích lũy của bạn để đổi lấy các mã giảm giá mua hàng giá trị cao.</p>
    </div>

    @if(count($vouchers) > 0)
        <div class="row g-4">
            @foreach($vouchers as $v)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-scale transition-all">
                        <!-- Voucher Header Grid -->
                        <div class="p-4 text-white d-flex justify-content-between align-items-start" 
                             style="background: linear-gradient(135deg, #2e7d32 0%, #81c784 100%);">
                            <div>
                                <span class="badge bg-white text-success fw-bold px-2 py-1 mb-2 shadow-sm" style="font-size: 10px; letter-spacing: 0.5px;">
                                    ĐỔI BẰNG ĐIỂM
                                </span>
                                <h3 class="fw-bold mb-0">
                                    {{ $v->type === 'percent' ? number_format($v->value) . '%' : number_format($v->value, 0, ',', '.') . 'đ' }}
                                </h3>
                                <span class="small opacity-75" style="font-size: 11px;">Chiết khấu đơn hàng</span>
                            </div>
                            <div class="text-end">
                                <div class="bg-warning text-dark fw-bold rounded-pill px-3 py-1 text-center" style="font-size: 13px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <i class="fa-solid fa-coins me-1"></i>{{ $v->points_cost }} Đ
                                </div>
                            </div>
                        </div>

                        <!-- Voucher Body -->
                        <div class="card-body bg-white p-4">
                            <ul class="list-unstyled mb-4 small text-muted">
                                <li class="mb-2">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i>
                                    Đơn tối thiểu: <strong>{{ number_format($v->min_order_amount, 0, ',', '.') }}đ</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i>
                                    Phạm vi: 
                                    <strong>
                                        {{ $v->product ? $v->product->name : 'Áp dụng toàn sàn' }}
                                    </strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-circle-check text-success me-2"></i>
                                    Hạn dùng mã: <strong>30 ngày</strong> kể từ lúc đổi
                                </li>
                            </ul>

                            <button type="button" 
                                    class="btn w-100 py-2 rounded-3 btn-redeem fw-semibold text-uppercase transition-all"
                                    data-id="{{ $v->id }}"
                                    data-cost="{{ $v->points_cost }}"
                                    data-name="Voucher giảm {{ $v->type === 'percent' ? number_format($v->value) . '%' : number_format($v->value, 0, ',', '.') . 'đ' }}"
                                    style="font-size: 13px;"
                                    {{ $user->reward_points >= $v->points_cost ? '' : 'disabled' }}>
                                {{ $user->reward_points >= $v->points_cost ? 'Đổi mã ngay' : 'Không đủ điểm' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
            <i class="fa-solid fa-box-open text-muted mb-3" style="font-size: 50px;"></i>
            <h5 class="text-muted fw-bold">Hiện chưa có voucher quà tặng khả dụng</h5>
            <p class="text-muted small">Vui lòng quay lại sau khi ban quản trị cập nhật kho quà tặng mới.</p>
        </div>
    @endif
</div>

<!-- Beautiful Success Redemption Modal -->
<div class="modal fade" id="redemptionSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="redemptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="mb-3 d-inline-block p-3 bg-success-subtle text-success rounded-circle">
                    <i class="fa-solid fa-gift fs-1"></i>
                </div>
                <h4 class="fw-bold text-success mb-2">Đổi Điểm Thành Công!</h4>
                <p class="text-muted small px-3">Chúc mừng bạn đã sở hữu mã giảm giá cá nhân. Sao chép mã bên dưới và sử dụng ngay khi thanh toán.</p>
                
                <div class="bg-light p-3 rounded-3 border border-dashed border-success d-flex justify-content-between align-items-center mb-4">
                    <span id="generated-voucher-code" class="fs-4 fw-bold text-success font-monospace" style="letter-spacing: 1px;">REDEEM-XXXXXX</span>
                    <button type="button" class="btn btn-success btn-sm px-3" id="btn-copy-code">
                        <i class="fa-regular fa-copy me-1"></i>Sao chép
                    </button>
                </div>
                
                <div class="alert alert-warning py-2 mb-0 small border-0 text-start" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    <strong>Lưu ý:</strong> Mã này chỉ có hiệu lực sử dụng <strong>1 lần duy nhất</strong> và hết hạn sau <strong>30 ngày</strong>.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles for premium feel -->
<style>
    .hover-scale {
        transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .btn-redeem {
        background-color: #2e7d32;
        color: white;
        border: none;
    }
    .btn-redeem:hover:not([disabled]) {
        background-color: #1b5e20;
        color: white;
        box-shadow: 0 4px 10px rgba(46,125,50,0.3);
    }
    .btn-redeem[disabled] {
        background-color: #e0e0e0;
        color: #9e9e9e;
        cursor: not-allowed;
    }
    .animate-bounce {
        animation: bounce 1.5s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .border-dashed {
        border-style: dashed !important;
    }
</style>

<!-- Javascript Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnRedeems = document.querySelectorAll('.btn-redeem');
        const userPointsEl = document.getElementById('user-points');
        const generatedCodeEl = document.getElementById('generated-voucher-code');
        const btnCopy = document.getElementById('btn-copy-code');
        const successModal = new bootstrap.Modal(document.getElementById('redemptionSuccessModal'));

        btnRedeems.forEach(btn => {
            btn.addEventListener('click', function() {
                const voucherId = this.getAttribute('data-id');
                const voucherCost = parseInt(this.getAttribute('data-cost'));
                const voucherName = this.getAttribute('data-name');

                if (confirm(`Bạn có chắc chắn muốn dùng ${voucherCost} điểm thưởng để đổi lấy ${voucherName}?`)) {
                    redeemPoints(voucherId, voucherCost, this);
                }
            });
        });

        function redeemPoints(voucherId, cost, buttonEl) {
            buttonEl.disabled = true;
            buttonEl.textContent = 'Đang xử lý...';

            const csrfToken = '{{ csrf_token() }}';

            fetch('{{ route("rewards.redeem") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ voucher_id: voucherId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật điểm trên UI
                    const newPoints = data.new_points;
                    userPointsEl.innerHTML = `<i class="fa-solid fa-coins animate-bounce"></i>` + newPoints.toLocaleString('vi-VN');
                    
                    // Hiển thị mã đã tạo trong Modal và mở Modal
                    generatedCodeEl.textContent = data.code;
                    successModal.show();

                    // Cập nhật lại trạng thái disable của tất cả các nút đổi mã
                    document.querySelectorAll('.btn-redeem').forEach(btn => {
                        const btnCost = parseInt(btn.getAttribute('data-cost'));
                        if (newPoints < btnCost) {
                            btn.disabled = true;
                            btn.textContent = 'Không đủ điểm';
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Đổi mã ngay';
                        }
                    });
                } else {
                    alert(data.message);
                    buttonEl.disabled = false;
                    buttonEl.textContent = 'Đổi mã ngay';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Có lỗi hệ thống xảy ra, vui lòng thử lại sau!');
                buttonEl.disabled = false;
                buttonEl.textContent = 'Đổi mã ngay';
            });
        }

        // Xử lý sao chép mã giảm giá vào clipboard
        if (btnCopy) {
            btnCopy.addEventListener('click', function() {
                const codeText = generatedCodeEl.textContent;
                navigator.clipboard.writeText(codeText).then(() => {
                    const originalHTML = btnCopy.innerHTML;
                    btnCopy.className = 'btn btn-outline-success btn-sm px-3';
                    btnCopy.innerHTML = '<i class="fa-solid fa-check me-1"></i>Đã chép';
                    setTimeout(() => {
                        btnCopy.className = 'btn btn-success btn-sm px-3';
                        btnCopy.innerHTML = originalHTML;
                    }, 2000);
                }).catch(err => {
                    console.error('Không thể sao chép: ', err);
                });
            });
        }
    });
</script>
@endsection
