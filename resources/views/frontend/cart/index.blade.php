@extends('frontend.layouts.master')

@section('title', 'Giỏ Hàng Vật Tư Nông Nghiệp của bạn')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Sản phẩm vật tư</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Giỏ hàng của tôi</li>
        </ol>
    </nav>

    <h4 class="fw-bold text-dark mb-4 d-flex align-items-center">
        <div class="p-2 bg-success-subtle text-success rounded-3 me-2 d-inline-flex"><i class="fa-solid fa-basket-shopping"></i></div>
        GIỎ HÀNG VẬT TƯ CỦA TÔI
    </h4>

    @if(isset($cartItems) && count($cartItems) > 0)
        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                            <thead class="table-light text-secondary fw-semibold">
                                <tr>
                                    <th class="ps-4 py-3">Vật tư nông nghiệp</th>
                                    <th class="py-3">Đơn giá</th>
                                    <th class="py-3 text-center">Số lượng</th>
                                    <th class="py-3 text-end">Thành tiền</th>
                                    <th class="pe-4 py-3 text-center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $item)
                                    <tr>
                                        <!-- Product info -->
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-3 p-1 border text-center me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    @if(!empty($item['image']))
                                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-height: 50px; object-fit: contain;">
                                                    @else
                                                        <i class="fa-solid fa-prescription-bottle-medical text-success-subtle fs-4"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">{{ $item['name'] }}</h6>
                                                    <span class="text-muted text-xs"><i class="fa-solid fa-box me-1"></i>Quy cách: {{ $item['packaging'] }} ({{ $item['unit'] }})</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Unit Price -->
                                        <td class="py-3 fw-bold text-dark">
                                            {{ number_format($item['price'], 0, ',', '.') }}đ
                                        </td>
                                        <!-- Quantity -->
                                        <td class="py-3 text-center">
                                            @php
                                                $prodModel = \App\Models\Product::find($id);
                                                $maxStock = $prodModel ? $prodModel->stock : 999;
                                            @endphp
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-inline-flex flex-column align-items-center">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <div class="input-group input-group-sm border rounded-3 overflow-hidden bg-light" style="max-width: 110px;">
                                                    <button type="button" class="btn btn-light border-0 px-2" onclick="decreaseQty(this)">-</button>
                                                    <input type="number" name="quantity" class="form-control border-0 text-center fw-bold bg-transparent" value="{{ $item['quantity'] }}" min="1" max="{{ $maxStock }}" onchange="this.form.submit()" style="width: 40px; font-size: 13px; padding: 4px 0;">
                                                    <button type="button" class="btn btn-light border-0 px-2" onclick="increaseQty(this)">+</button>
                                                </div>
                                                <span class="text-muted mt-1 text-nowrap" style="font-size: 10px;">
                                                    <i class="fa-solid fa-warehouse text-success"></i> Tồn: {{ $maxStock }}
                                                </span>
                                            </form>
                                        </td>
                                        <!-- Subtotal -->
                                        <td class="py-3 text-end fw-bold text-danger">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                        </td>
                                        <!-- Delete -->
                                        <td class="pe-4 py-3 text-center">
                                            <form action="{{ route('cart.remove') }}" method="POST" class="m-0" onsubmit="return confirm('Bạn có chắc chắn muốn bỏ vật tư này khỏi giỏ hàng?')">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-link text-danger p-0 border-0 shadow-none">
                                                    <i class="fa-regular fa-trash-can fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cart Summary Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center pb-2 border-bottom" style="font-size: 16px;">
                        <i class="fa-solid fa-calculator text-success me-2"></i>Tóm tắt dòng tiền hóa đơn
                    </h5>
                    
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Giá trị vật tư:</span>
                        <span class="fw-semibold text-dark">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small text-secondary">
                        <span>Thuế VAT nông nghiệp:</span>
                        <span class="text-success fw-bold">Miễn thuế (0%)</span>
                    </div>

                    <hr class="border-light-subtle my-3">

                    <div class="p-3 bg-success-subtle rounded-3 border border-success-subtle mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success-emphasis" style="font-size: 14px;">Tổng tiền cần trả:</span>
                            <span class="text-danger fw-bold fs-4">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg w-100 fw-bold rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background-color: #2e7d32; border: none; height: 48px; font-size: 14px;">
                            <i class="fa-solid fa-credit-card"></i> TIẾN HÀNH THANH TOÁN
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-lg w-100 fw-bold rounded-3 d-flex align-items-center justify-content-center gap-2" style="height: 48px; font-size: 14px;">
                            <i class="fa-solid fa-arrow-left"></i> TIẾP TỤC CHỌN VẬT TƯ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart Alert -->
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
            <div class="py-4">
                <i class="fa-solid fa-basket-shopping text-success-subtle mb-4" style="font-size: 100px;"></i>
                <h5 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống!</h5>
                <p class="text-muted small mb-4">Hãy lướt qua danh mục phân bón & thuốc BVTV EcoFarm để tìm sản phẩm phù hợp cho mùa vụ mới.</p>
                <a href="{{ route('products.index') }}" class="btn btn-success fw-bold px-4 py-2.5 rounded-3" style="background-color: #2e7d32; border: none;">
                    <i class="fa-solid fa-chevron-left me-2"></i>Quay lại danh mục vật tư
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    function decreaseQty(btn) {
        const input = btn.nextElementSibling;
        const val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
            input.dispatchEvent(new Event('change'));
        }
    }
    function increaseQty(btn) {
        const input = btn.previousElementSibling;
        const val = parseInt(input.value);
        input.value = val + 1;
        input.dispatchEvent(new Event('change'));
    }
</script>
@endsection
