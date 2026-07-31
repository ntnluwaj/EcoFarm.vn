@extends('frontend.layouts.master')

@section('title', 'Thanh Toán Đơn Hàng Vật Tư')

@section('content')
<!-- Leaflet.js Map Assets -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="container py-4" style="min-height: 80vh;">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Xác nhận thông tin thanh toán</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h4 class="fw-bold text-dark mb-4 d-flex align-items-center" style="font-size: 18px;">
                    <div class="p-2 bg-success-subtle text-success rounded-3 me-2 d-inline-flex"><i class="fa-solid fa-truck-ramp-box"></i></div>
                    Thông tin nhận hàng & Thanh toán
                </h4>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 small mb-4 shadow-sm text-dark bg-danger-subtle">
                        <span class="fw-bold d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Vui lòng hiệu chỉnh các thông tin sau:</span>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('cart.storeOrder') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold"><i class="fa-regular fa-user me-1 text-success"></i>Họ và tên người nhận vật tư *</label>
                        <input type="text" name="name" class="form-control rounded-3 border-light-subtle text-sm p-2.5" placeholder="Ví dụ: Nguyễn Văn A" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required style="font-size: 13px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold"><i class="fa-solid fa-phone me-1 text-success"></i>Số điện thoại liên hệ *</label>
                        <input type="text" name="phone" class="form-control rounded-3 border-light-subtle text-sm p-2.5" placeholder="Ví dụ: 0907xxxxxx" value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" required style="font-size: 13px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold"><i class="fa-solid fa-envelope me-1 text-success"></i>Địa chỉ Email nhận hóa đơn & tiến độ *</label>
                        <input type="email" name="email" class="form-control rounded-3 border-light-subtle text-sm p-2.5" placeholder="Ví dụ: hotro@ecofarm.vn" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required style="font-size: 13px;">
                    </div>

                    <div class="mb-4 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label text-dark small fw-bold"><i class="fa-solid fa-location-dot me-1 text-success"></i>Địa chỉ giao nhận hàng *</label>
                            @if(auth()->check() && auth()->user()->address)
                                <button type="button" class="btn btn-outline-success btn-xs py-0.5 px-2 rounded-pill fw-semibold border-success" style="font-size: 11px; background: transparent;" onclick="useSavedAddress()">
                                    <i class="fa-house-user fa-solid me-1"></i>Dùng địa chỉ đã lưu
                                </button>
                            @endif
                        </div>
                        
                        <!-- Ô tìm kiếm nhanh tự động phân tách địa chỉ -->
                        <div class="input-group mb-2 shadow-xs">
                            <span class="input-group-text bg-light border-light-subtle text-muted" style="font-size: 12.5px;"><i class="fa-solid fa-magnifying-glass text-success"></i></span>
                            <input type="text" id="address-search" class="form-control rounded-end-3 border-light-subtle text-sm p-2" placeholder="Gõ để tìm kiếm địa chỉ nhanh hoặc tự điền bên dưới..." style="font-size: 13px;" autocomplete="off">
                        </div>
                        
                        <!-- Dropdown gợi ý địa chỉ -->
                        <div id="address-suggestions" class="dropdown-menu shadow w-100 p-0 overflow-hidden" style="display: none; max-height: 220px; z-index: 1050; position: absolute; top: 75px; left: 0;"></div>

                        <!-- 4 trường địa chỉ bắt buộc và phân tách rõ ràng -->
                        <div class="row g-2 mb-2 p-2 bg-light rounded-3 border border-light-subtle">
                            <div class="col-12">
                                <label class="form-label text-dark mb-0 fw-semibold" style="font-size: 11px;">Số nhà, tên đường, ấp/thôn/tổ *</label>
                                <input type="text" name="address_street" id="address_street" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Ví dụ: 123 Đường Cách Mạng Tháng Tám" required style="font-size: 13px;" value="{{ old('address_street') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-dark mb-0 fw-semibold" style="font-size: 11px;">Xã / Phường / Thị trấn *</label>
                                <select name="address_ward" id="address_ward" class="form-select rounded-3 border-light-subtle text-sm p-2" required style="font-size: 13px;">
                                    <option value="">Chọn Xã / Phường</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-dark mb-0 fw-semibold" style="font-size: 11px;">Quận / Huyện *</label>
                                <select name="address_district" id="address_district" class="form-select rounded-3 border-light-subtle text-sm p-2" required style="font-size: 13px;">
                                    <option value="">Chọn Quận / Huyện</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-dark mb-0 fw-semibold" style="font-size: 11px;">Tỉnh / Thành phố *</label>
                                <select name="address_province" id="address_province" class="form-select rounded-3 border-light-subtle text-sm p-2" required style="font-size: 13px;">
                                    <option value="">Chọn Tỉnh / Thành</option>
                                </select>
                            </div>
                        </div>

                        <!-- Khung chứa bản đồ mini Leaflet -->
                        <div id="map-container" class="mt-2 rounded-3 overflow-hidden border border-light-subtle" style="height: 220px; display: none;">
                            <div id="map" class="w-100 h-100"></div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border border-light-subtle">
                        <div class="form-check d-flex align-items-center mb-0">
                            <input class="form-check-input me-2 border-secondary" type="checkbox" name="vat_required" id="vatCheck" value="1" {{ old('vat_required') ? 'checked' : '' }} onchange="toggleVatFields()">
                            <label class="form-check-label text-dark small fw-semibold" style="cursor: pointer;" for="vatCheck">
                                <i class="fa-solid fa-file-invoice-dollar text-success me-1"></i>Yêu cầu xuất hóa đơn điện tử (VAT)
                            </label>
                        </div>

                        <div id="vatFields" class="mt-3 pt-3 border-top border-light-subtle" style="display: {{ old('vat_required') ? 'block' : 'none' }};">
                            <div class="mb-2">
                                <label class="form-label text-dark small fw-bold">Tên công ty / Doanh nghiệp *</label>
                                <input type="text" name="company_name" id="company_name" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Nhập tên doanh nghiệp đăng ký kinh doanh" value="{{ old('company_name') }}" style="font-size: 13px;">
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-dark small fw-bold">Mã số thuế doanh nghiệp *</label>
                                <input type="text" name="tax_code" id="tax_code" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Nhập chính xác mã số thuế công ty" value="{{ old('tax_code') }}" style="font-size: 13px;">
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-dark small fw-bold">Địa chỉ công ty *</label>
                                <input type="text" name="company_address" id="company_address" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Nhập địa chỉ công ty đăng ký thuế" value="{{ old('company_address') }}" style="font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark small fw-bold mb-3"><i class="fa-solid fa-credit-card me-1 text-success"></i>Phương thức thanh toán *</label>
                        
                        <div class="d-flex flex-column gap-2">
                            <label class="p-3 border rounded-3 d-flex align-items-center justify-content-between payment-option bg-light-subtle" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="cod" class="form-check-input me-3 border-secondary" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                    <div>
                                        <strong class="text-dark text-sm d-block" style="font-size: 13px;">💵 Trả tiền mặt khi giao hàng (COD)</strong>
                                        <span class="text-muted" style="font-size: 11px;">Thanh toán trực tiếp cho đơn vị bốc xếp vận chuyển khi nhận vật tư.</span>
                                    </div>
                                </div>
                            </label>

                            <label class="p-3 border rounded-3 d-flex align-items-center justify-content-between payment-option bg-light-subtle" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="vietqr" class="form-check-input me-3 border-secondary" {{ old('payment_method') == 'vietqr' ? 'checked' : '' }}>
                                    <div>
                                        <strong class="text-dark text-sm d-block" style="font-size: 13px;">🏦 Chuyển khoản ngân hàng nhanh (VietQR)</strong>
                                        <span class="text-muted" style="font-size: 11px;">Quét mã QR Code hiển thị ở bước tiếp theo để hoàn thành thanh toán.</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm mt-4" style="background-color: #2e7d32; border: none; height: 48px; font-size: 15px;">
                        <i class="fa-solid fa-circle-check"></i> Xác nhận đặt hàng & Giao vận
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 20px;">
                <h4 class="fw-bold text-dark mb-4 d-flex align-items-center" style="font-size: 18px; pb-2; border-bottom: 1px solid #f1f4f5;">
                    <div class="p-2 bg-success-subtle text-success rounded-3 me-2 d-inline-flex"><i class="fa-solid fa-basket-shopping"></i></div>
                    Danh mục vật tư đặt mua
                </h4>

                @if(isset($cartItems) && count($cartItems) > 0)
                    <div class="d-flex flex-column gap-3 mb-4">
                        @php $total = 0; @endphp
                        @foreach($cartItems as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border border-light-subtle">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <div class="bg-white rounded-2 p-1 text-center me-3 d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px; min-width: 50px;">
                                        @if(!empty($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-height: 40px; object-fit: contain;">
                                        @else
                                            <i class="fa-solid fa-prescription-bottle-medical text-success-subtle fs-5"></i>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 13px;">{{ $item['name'] }}</h6>
                                        <span class="text-muted d-block" style="font-size: 11px;">SL: <strong class="text-dark">{{ $item['quantity'] }}</strong> {{ $item['unit'] ?? 'Chai' }} x {{ number_format($item['price'], 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                                <span class="fw-bold text-dark text-sm ms-2" style="font-size: 13px; min-width: 80px; text-align: right;">
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column gap-2 mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span>Tạm tính:</span>
                            <span class="fw-bold text-dark">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span>Trong đó Thuế VAT:</span>
                            <span class="fw-semibold text-success" id="vat-val">{{ $totalVat > 0 ? number_format($totalVat, 0, ',', '.') . 'đ' : 'Không chịu thuế GTGT' }}</span>
                        </div>
                        <div id="discount-row" class="d-flex justify-content-between text-success {{ $discountAmount > 0 ? '' : 'd-none' }}" style="font-size: 13px;">
                            <span>Chiết khấu (<span id="applied-code" class="fw-bold">{{ session('applied_voucher.code') }}</span>):</span>
                            <span class="fw-bold" id="discount-val">-{{ number_format($discountAmount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <!-- Ô nhập mã giảm giá -->
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px; display: flex; align-items: center;">
                            <i class="fa-solid fa-ticket text-success me-1"></i> Mã giảm giá / Voucher
                        </label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="voucher-code" class="form-control" placeholder="Mã giảm giá (ví dụ: ECF10)" value="{{ session('applied_voucher.code') }}" {{ session()->has('applied_voucher') ? 'disabled' : '' }} style="text-transform: uppercase;">
                            <button class="btn {{ session()->has('applied_voucher') ? 'btn-danger' : 'btn-success' }}" type="button" id="btn-apply-voucher">
                                {{ session()->has('applied_voucher') ? 'Hủy' : 'Áp dụng' }}
                            </button>
                        </div>
                        <div id="voucher-message" class="form-text small mt-1 d-none"></div>

                        @if(isset($vouchers) && count($vouchers) > 0)
                            <div class="mt-2">
                                <a class="text-success text-decoration-none fw-semibold" data-bs-toggle="collapse" href="#available-vouchers" role="button" aria-expanded="false" aria-controls="available-vouchers" style="font-size: 11px; display: inline-flex; align-items: center;">
                                    <i class="fa-solid fa-gift me-1"></i> Xem mã giảm giá hiện có
                                </a>
                                <div class="collapse mt-1" id="available-vouchers">
                                    <div class="card card-body p-2 border bg-light no-scrollbar" style="max-height: 150px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                        @foreach($vouchers as $v)
                                            <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom last-border-none" style="font-size: 10.5px;">
                                                <div class="pe-2">
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 mb-1 d-inline-block" style="font-size: 10px; font-weight: bold; letter-spacing: 0.5px;">{{ $v->code }}</span>
                                                    <span class="d-block text-dark fw-medium">Giảm {{ $v->type === 'percent' ? number_format($v->value) . '%' : number_format($v->value, 0, ',', '.') . 'đ' }}</span>
                                                    <span class="text-muted d-block" style="font-size: 9.5px;">Đơn tối thiểu: {{ number_format($v->min_order_amount, 0, ',', '.') }}đ</span>
                                                </div>
                                                <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 btn-select-voucher" data-code="{{ $v->code }}" {{ session()->has('applied_voucher') ? 'disabled' : '' }} style="font-size: 10px; border-radius: 4px;">
                                                    Chọn
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="p-3 bg-success-subtle rounded-3 border border-success-subtle mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success-emphasis" style="font-size: 14px;">Tổng tiền thanh toán:</span>
                            <span id="final-total" class="text-danger fw-bold fs-4">{{ number_format($finalTotal, 0, ',', '.') }} VND</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-muted small">
                        <p class="mb-0">Giỏ hàng rỗng, không có dữ liệu đặt mua.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Hiệu ứng active đổi màu viền khi tùy chọn phương thức thanh toán được kích hoạt */
    .payment-option:has(input:checked) {
        border-color: #2e7d32 !important;
        background-color: #e8f5e9 !important;
    }
    #address-suggestions {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        border: 1px solid #dee2e6;
        background: #fff;
    }
    #address-suggestions .dropdown-item:hover {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
</style>

<script>
    function toggleVatFields() {
        const vatCheck = document.getElementById('vatCheck');
        const vatFields = document.getElementById('vatFields');
        const companyName = document.getElementById('company_name');
        const taxCode = document.getElementById('tax_code');
        const companyAddress = document.getElementById('company_address');

        if (vatCheck.checked) {
            vatFields.style.display = 'block';
            companyName.setAttribute('required', 'required');
            taxCode.setAttribute('required', 'required');
            companyAddress.setAttribute('required', 'required');
        } else {
            vatFields.style.display = 'none';
            companyName.removeAttribute('required');
            taxCode.removeAttribute('required');
            companyAddress.removeAttribute('required');
            companyName.value = '';
            taxCode.value = '';
            companyAddress.value = '';
        }
    }

    // Tự động kiểm tra trạng thái cũ sau khi trang bị load lại (Old Old State Laravel)
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('vatCheck').checked) {
            document.getElementById('company_name').setAttribute('required', 'required');
            document.getElementById('tax_code').setAttribute('required', 'required');
            document.getElementById('company_address').setAttribute('required', 'required');
        }
    });

    // Hàm khớp tương đối để tự chọn option trong select theo tên địa phương
    function selectOptionByFuzzyText(selectEl, text) {
        if (!selectEl || !text) return false;
        const cleanText = text.toLowerCase()
            .replace(/^(tỉnh|thành phố|quận|huyện|thị xã|thị trấn|phường|xã|tp|q|h)\s+/g, '')
            .trim();
            
        for (let i = 0; i < selectEl.options.length; i++) {
            const opt = selectEl.options[i];
            const cleanOptText = opt.textContent.toLowerCase()
                .replace(/^(tỉnh|thành phố|quận|huyện|thị xã|thị trấn|phường|xã|tp|q|h)\s+/g, '')
                .trim();
            if (cleanOptText === cleanText || opt.value.toLowerCase().includes(cleanText) || cleanText.includes(cleanOptText)) {
                selectEl.selectedIndex = i;
                return true;
            }
        }
        return false;
    }

    // Bản đồ mini Leaflet & Autocomplete gợi ý địa chỉ OpenStreetMap
    document.addEventListener("DOMContentLoaded", function() {
        const addressInput = document.getElementById('address-search');
        const suggestionsBox = document.getElementById('address-suggestions');
        const mapContainer = document.getElementById('map-container');
        
        let map = null;
        let marker = null;
        let debounceTimer = null;
        
        // Cờ chống vòng lặp vô tận giữa map update và input change listeners
        let isUpdatingFromMap = false;
        let formGeocodeTimer = null;

        // 🌟 Tích hợp nạp dữ liệu Tỉnh/Thành, Quận/Huyện, Xã/Phường qua API
        const provinceSelect = document.getElementById('address_province');
        const districtSelect = document.getElementById('address_district');
        const wardSelect = document.getElementById('address_ward');
        const streetInput = document.getElementById('address_street');

        if (provinceSelect && districtSelect && wardSelect) {
            // Nạp Tỉnh/Thành phố
            fetch('https://provinces.open-api.vn/api/p/')
                .then(res => res.json())
                .then(data => {
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.name;
                        opt.textContent = p.name;
                        opt.setAttribute('data-code', p.code);
                        provinceSelect.appendChild(opt);
                    });
                    
                    // Khôi phục giá trị cũ (old state) nếu có
                    const oldProvince = "{{ old('address_province') }}";
                    if (oldProvince) {
                        provinceSelect.value = oldProvince;
                        provinceSelect.dispatchEvent(new Event('change'));
                    }
                });

            // Lắng nghe đổi Tỉnh/Thành
            provinceSelect.addEventListener('change', function() {
                const selectedOpt = this.options[this.selectedIndex];
                const code = selectedOpt.getAttribute('data-code');
                
                districtSelect.innerHTML = '<option value="">Chọn Quận / Huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn Xã / Phường</option>';

                if (!code) return;

                fetch(`https://provinces.open-api.vn/api/p/${code}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        const districts = data.districts || [];
                        districts.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = d.name;
                            opt.textContent = d.name;
                            opt.setAttribute('data-code', d.code);
                            districtSelect.appendChild(opt);
                        });
                        
                        const oldDistrict = "{{ old('address_district') }}";
                        if (oldDistrict) {
                            districtSelect.value = oldDistrict;
                            districtSelect.dispatchEvent(new Event('change'));
                        }
                    });
            });

            // Lắng nghe đổi Quận/Huyện
            districtSelect.addEventListener('change', function() {
                const selectedOpt = this.options[this.selectedIndex];
                const code = selectedOpt.getAttribute('data-code');
                
                wardSelect.innerHTML = '<option value="">Chọn Xã / Phường</option>';

                if (!code) return;

                fetch(`https://provinces.open-api.vn/api/d/${code}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        const wards = data.wards || [];
                        wards.forEach(w => {
                            const opt = document.createElement('option');
                            opt.value = w.name;
                            opt.textContent = w.name;
                            wardSelect.appendChild(opt);
                        });
                        
                        const oldWard = "{{ old('address_ward') }}";
                        if (oldWard) {
                            wardSelect.value = oldWard;
                        }
                    });
            });
        }

        // Tự động tìm kiếm tọa độ từ thông tin trong form và chuyển tâm bản đồ tới đó
        function geocodeFormAddress() {
            if (isUpdatingFromMap) return;

            const street = streetInput ? streetInput.value.trim() : '';
            const ward = wardSelect ? wardSelect.value : '';
            const district = districtSelect ? districtSelect.value : '';
            const province = provinceSelect ? provinceSelect.value : '';

            if (!province) return; // Bắt buộc phải chọn Tỉnh/Thành phố trước

            const queryParts = [];
            if (street) queryParts.push(street);
            if (ward) queryParts.push(ward);
            if (district) queryParts.push(district);
            if (province) queryParts.push(province);

            const query = queryParts.join(', ');

            clearTimeout(formGeocodeTimer);
            formGeocodeTimer = setTimeout(() => {
                const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=vn&q=${encodeURIComponent(query)}`;
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            // Cập nhật bản đồ mà không kích hoạt reverse geocoding ngược lại
                            isUpdatingFromMap = true;
                            initMap(lat, lon, query);
                            setTimeout(() => {
                                isUpdatingFromMap = false;
                            }, 500);
                        }
                    })
                    .catch(err => console.error('Geocoding form error:', err));
            }, 1000); // Debounce 1 giây để tránh spam API khi gõ chữ
        }

        // Đăng ký sự kiện lắng nghe thay đổi thông tin trên form
        if (provinceSelect) {
            provinceSelect.addEventListener('change', () => {
                if (!isUpdatingFromMap) geocodeFormAddress();
            });
        }
        if (districtSelect) {
            districtSelect.addEventListener('change', () => {
                if (!isUpdatingFromMap) geocodeFormAddress();
            });
        }
        if (wardSelect) {
            wardSelect.addEventListener('change', () => {
                if (!isUpdatingFromMap) geocodeFormAddress();
            });
        }
        if (streetInput) {
            streetInput.addEventListener('input', () => {
                if (!isUpdatingFromMap) geocodeFormAddress();
            });
        }

        function initMap(lat, lon, displayName) {
            mapContainer.style.display = 'block';
            
            if (!map) {
                map = L.map('map').setView([lat, lon], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                marker = L.marker([lat, lon], { draggable: true }).addTo(map)
                    .bindPopup(displayName)
                    .openPopup();

                // Lắng nghe sự kiện kéo ghim thủ công
                marker.on('dragend', function() {
                    const coords = marker.getLatLng();
                    updateAddressFromCoords(coords.lat, coords.lng);
                });

                // Lắng nghe sự kiện click trên bản đồ
                map.on('click', function(e) {
                    const coords = e.latlng;
                    marker.setLatLng(coords);
                    updateAddressFromCoords(coords.lat, coords.lng);
                });
            } else {
                const latLng = new L.LatLng(lat, lon);
                map.setView(latLng, 15);
                marker.setLatLng(latLng);
                marker.setPopupContent(displayName).openPopup();
            }
            
            setTimeout(() => {
                map.invalidateSize();
            }, 200);
        }

        // Hàm gọi API Reverse Geocoding của Nominatim (OpenStreetMap)
        function updateAddressFromCoords(lat, lng) {
            if (addressInput) addressInput.placeholder = "Đang định vị địa chỉ từ bản đồ...";

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1&accept-language=vi`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        isUpdatingFromMap = true;
                        if (addressInput && data.display_name) {
                            addressInput.value = data.display_name;
                        }
                        
                        // Phân tách địa chỉ
                        const addr = data.address || {};
                        const province = addr.city || addr.state || addr.province || '';
                        selectOptionByFuzzyText(provinceSelect, province);
                        
                        provinceSelect.dispatchEvent(new Event('change'));
                        
                        setTimeout(() => {
                            const district = addr.subdistrict || addr.district || addr.city_district || addr.county || '';
                            selectOptionByFuzzyText(districtSelect, district);
                            
                            districtSelect.dispatchEvent(new Event('change'));
                            
                            setTimeout(() => {
                                const ward = addr.suburb || addr.quarter || addr.village || addr.commune || addr.town || '';
                                selectOptionByFuzzyText(wardSelect, ward);
                                
                                setTimeout(() => {
                                    isUpdatingFromMap = false;
                                }, 200);
                            }, 350);
                        }, 350);

                        const road = addr.road || '';
                        const houseNumber = addr.house_number || '';
                        const street = houseNumber ? `${houseNumber} ${road}` : road;
                        if (streetInput) {
                            streetInput.value = street || data.display_name.split(',')[0];
                        }
                    } else {
                        isUpdatingFromMap = false;
                    }
                    if (addressInput) addressInput.placeholder = "Gõ để tìm kiếm địa chỉ nhanh...";
                })
                .catch(error => {
                    isUpdatingFromMap = false;
                    console.error("Lỗi reverse geocoding:", error);
                    if (addressInput) addressInput.placeholder = "Gõ để tìm kiếm địa chỉ nhanh...";
                });
        }

        if (addressInput) {
            addressInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(debounceTimer);
                if (query.length < 3) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    const url = `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&countrycodes=vn&limit=5&q=${encodeURIComponent(query)}`;
                    
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox.innerHTML = '';
                            if (data.length === 0) {
                                suggestionsBox.style.display = 'none';
                                return;
                            }

                            data.forEach(item => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'dropdown-item text-wrap border-bottom text-start py-2 small';
                                btn.style.fontSize = '12.5px';
                                btn.innerHTML = `<i class="fa-solid fa-location-dot text-success me-2"></i>${item.display_name}`;
                                btn.addEventListener('click', function() {
                                    addressInput.value = item.display_name;
                                    suggestionsBox.style.display = 'none';
                                    
                                    isUpdatingFromMap = true;
                                    
                                    // Phân tách địa chỉ từ đối tượng address của Nominatim
                                    const addr = item.address || {};
                                    const province = addr.city || addr.state || addr.province || '';
                                    selectOptionByFuzzyText(provinceSelect, province);
                                    
                                    provinceSelect.dispatchEvent(new Event('change'));
                                    
                                    setTimeout(() => {
                                        const district = addr.subdistrict || addr.district || addr.city_district || addr.county || '';
                                        selectOptionByFuzzyText(districtSelect, district);
                                        
                                        districtSelect.dispatchEvent(new Event('change'));
                                        
                                        setTimeout(() => {
                                            const ward = addr.suburb || addr.quarter || addr.village || addr.commune || addr.town || '';
                                            selectOptionByFuzzyText(wardSelect, ward);
                                            
                                            setTimeout(() => {
                                                isUpdatingFromMap = false;
                                            }, 200);
                                        }, 350);
                                    }, 350);

                                    const road = addr.road || '';
                                    const houseNumber = addr.house_number || '';
                                    const street = houseNumber ? `${houseNumber} ${road}` : road;
                                    if (streetInput) {
                                        streetInput.value = street || item.display_name.split(',')[0];
                                    }
                                    
                                    initMap(parseFloat(item.lat), parseFloat(item.lon), item.display_name);
                                });
                                suggestionsBox.appendChild(btn);
                            });
                            suggestionsBox.style.display = 'block';
                        })
                        .catch(err => {
                            console.error('Error fetching suggestions:', err);
                        });
                }, 450);
            });

            document.addEventListener('click', function(e) {
                if (e.target !== addressInput && e.target !== suggestionsBox) {
                    suggestionsBox.style.display = 'none';
                }
            });
        }
    });

    // 🌟 XỬ LÝ ÁP DỤNG MÃ GIẢM GIÁ (VOUCHER) BẰNG AJAX
    document.addEventListener("DOMContentLoaded", function() {
        const btnApply = document.getElementById('btn-apply-voucher');
        const voucherInput = document.getElementById('voucher-code');
        const voucherMsg = document.getElementById('voucher-message');
        const discountRow = document.getElementById('discount-row');
        const appliedCode = document.getElementById('applied-code');
        const discountVal = document.getElementById('discount-val');
        const finalTotal = document.getElementById('final-total');
        const vatVal = document.getElementById('vat-val');

        if (btnApply) {
            btnApply.addEventListener('click', function() {
                const code = voucherInput.value.trim();

                // Nếu đang ở trạng thái hủy mã (nút có class btn-danger)
                if (btnApply.classList.contains('btn-danger')) {
                    applyVoucherCode('');
                    return;
                }

                if (!code) {
                    showVoucherMessage('Vui lòng nhập mã giảm giá!', 'text-danger');
                    return;
                }

                applyVoucherCode(code);
            });
        }

        // Xử lý khi chọn nhanh voucher từ danh sách
        document.querySelectorAll('.btn-select-voucher').forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                if (voucherInput && btnApply) {
                    voucherInput.value = code;
                    btnApply.click();
                }
            });
        });

        function showVoucherMessage(msg, className) {
            voucherMsg.textContent = msg;
            voucherMsg.className = 'form-text small mt-1 ' + className;
            voucherMsg.classList.remove('d-none');
        }

        function applyVoucherCode(code) {
            btnApply.disabled = true;
            
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch('{{ route("cart.applyVoucher") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                btnApply.disabled = false;
                if (data.success) {
                    if (code === '') {
                        // Hủy thành công
                        voucherInput.value = '';
                        voucherInput.disabled = false;
                        btnApply.textContent = 'Áp dụng';
                        btnApply.className = 'btn btn-success btn-sm';
                        discountRow.classList.add('d-none');
                        finalTotal.textContent = data.new_total_formatted + ' VND';
                        if (vatVal && data.new_vat_formatted) { vatVal.textContent = data.new_vat_formatted; }
                        showVoucherMessage('Đã hủy áp dụng mã giảm giá.', 'text-muted');
                        
                        // Kích hoạt lại nút chọn voucher
                        document.querySelectorAll('.btn-select-voucher').forEach(b => b.disabled = false);
                    } else {
                        // Áp dụng thành công
                        voucherInput.disabled = true;
                        btnApply.textContent = 'Hủy';
                        btnApply.className = 'btn btn-danger btn-sm';
                        appliedCode.textContent = data.code;
                        discountVal.textContent = '-' + data.discount_amount_formatted;
                        discountRow.classList.remove('d-none');
                        finalTotal.textContent = data.new_total_formatted + ' VND';
                        if (vatVal && data.new_vat_formatted) { vatVal.textContent = data.new_vat_formatted; }
                        showVoucherMessage(data.message, 'text-success');

                        // Vô hiệu hóa nút chọn voucher khác khi đã áp mã thành công
                        document.querySelectorAll('.btn-select-voucher').forEach(b => b.disabled = true);
                    }
                } else {
                    showVoucherMessage(data.message, 'text-danger');
                }
            })
            .catch(err => {
                btnApply.disabled = false;
                console.error(err);
                showVoucherMessage('Có lỗi kết nối hệ thống, vui lòng thử lại!', 'text-danger');
            });
        }
    });

    window.useSavedAddress = function() {
        const savedAddress = @json(auth()->check() ? auth()->user()->address : '');
        if (savedAddress) {
            const parts = savedAddress.split(',').map(p => p.trim());
            const pSel = document.getElementById('address_province');
            const dSel = document.getElementById('address_district');
            const wSel = document.getElementById('address_ward');

            if (parts.length >= 4) {
                document.getElementById('address_street').value = parts[0];
                
                selectOptionByFuzzyText(pSel, parts[3]);
                pSel.dispatchEvent(new Event('change'));
                
                setTimeout(() => {
                    selectOptionByFuzzyText(dSel, parts[2]);
                    dSel.dispatchEvent(new Event('change'));
                    
                    setTimeout(() => {
                        selectOptionByFuzzyText(wSel, parts[1]);
                    }, 350);
                }, 350);
            } else if (parts.length === 3) {
                document.getElementById('address_street').value = parts[0];
                
                selectOptionByFuzzyText(pSel, parts[2]);
                pSel.dispatchEvent(new Event('change'));
                
                setTimeout(() => {
                    selectOptionByFuzzyText(dSel, parts[1]);
                    dSel.dispatchEvent(new Event('change'));
                    
                    setTimeout(() => {
                        selectOptionByFuzzyText(wSel, parts[0]);
                    }, 350);
                }, 350);
            } else {
                document.getElementById('address_street').value = savedAddress;
            }
            
            const searchInput = document.getElementById('address-search');
            if (searchInput) {
                searchInput.value = savedAddress;
            }
        }
    };
</script>
@endsection