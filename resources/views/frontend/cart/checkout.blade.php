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

                    <div class="mb-4 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label text-dark small fw-bold mb-0"><i class="fa-solid fa-location-dot me-1 text-success"></i>Địa chỉ giao nhận hàng *</label>
                            @if(auth()->check() && auth()->user()->address)
                                <button type="button" class="btn btn-outline-success btn-xs py-0.5 px-2 rounded-pill fw-semibold border-success" style="font-size: 11px; background: transparent;" onclick="useSavedAddress()">
                                    <i class="fa-house-user fa-solid me-1"></i>Dùng địa chỉ đã lưu
                                </button>
                            @endif
                        </div>
                        <textarea name="address" id="address-input" class="form-control rounded-3 border-light-subtle text-sm p-2.5" rows="3" placeholder="Ghi rõ số nhà, tên đường, xã/phường, quận/huyện, tỉnh thành..." required style="font-size: 13px; resize: none;" autocomplete="off">{{ old('address', auth()->check() ? auth()->user()->address : '') }}</textarea>
                        
                        <!-- Dropdown gợi ý địa chỉ -->
                        <div id="address-suggestions" class="dropdown-menu shadow w-100 p-0 overflow-hidden" style="display: none; max-height: 220px; z-index: 1050; position: absolute; top: 100%; left: 0;"></div>

                        <!-- Khung chứa bản đồ mini Leaflet -->
                        <div id="map-container" class="mt-3 rounded-3 overflow-hidden border border-light-subtle" style="height: 220px; display: none;">
                            <div id="map" class="w-100 h-100"></div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border border-light-subtle">
                        <div class="form-check d-flex align-items-center mb-0">
                            <input class="form-check-input me-2 border-secondary" type="checkbox" name="vat_required" id="vatCheck" value="1" {{ old('vat_required') ? 'checked' : '' }} onchange="toggleVatFields()">
                            <label class="form-check-label text-dark small fw-semibold" style="cursor: pointer;" for="vatCheck">
                                <i class="fa-solid fa-file-invoice-dollar text-success me-1"></i>Yêu cầu xuất hóa đơn đỏ công ty (VAT)
                            </label>
                        </div>

                        <div id="vatFields" class="mt-3 pt-3 border-top border-light-subtle" style="display: {{ old('vat_required') ? 'block' : 'none' }};">
                            <div class="mb-2">
                                <label class="form-label text-dark small fw-bold">Tên công ty / Doanh nghiệp *</label>
                                <input type="text" name="company_name" id="company_name" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Nhập tên doanh nghiệp đăng ký kinh doanh" value="{{ old('company_name') }}" style="font-size: 13px;">
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-dark small fw-bold">Mã số thuế doanh nghiệp *</label>
                                <input type="text" name="tax_code" id="tax_code" class="form-control rounded-3 border-light-subtle text-sm p-2" placeholder="Nhập chính xác mã số thuế công ty" value="{{ old('tax_code') }}" style="font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark small fw-bold mb-3"><i class="fa-solid fa-credit-card me-1 text-success"></i>Phương thức thanh toán dòng tiền *</label>
                        
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
                                        <span class="text-muted" style="font-size: 11px;">Quét mã QR Code hiển thị ở bước tiếp theo để hoàn thành dòng tiền đầu vụ.</span>
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

                    <div class="p-3 bg-success-subtle rounded-3 border border-success-subtle mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success-emphasis" style="font-size: 14px;">Tổng tiền thanh toán:</span>
                            <span class="text-danger fw-bold fs-4">{{ number_format($total, 0, ',', '.') }} VND</span>
                        </div>
                    </div>
                    <span class="text-muted d-block text-center" style="font-size: 11px;">
                        <i class="fa-solid fa-circle-info text-warning me-1"></i>Vật tư nông nghiệp được miễn thuế VAT đầu vụ.
                    </span>
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
    /* Hiệu ứng active đổi màu viền khi tùy chọn phương thức dòng tiền được kích hoạt */
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

        if (vatCheck.checked) {
            vatFields.style.display = 'block';
            companyName.setAttribute('required', 'required');
            taxCode.setAttribute('required', 'required');
        } else {
            vatFields.style.display = 'none';
            companyName.removeAttribute('required');
            taxCode.removeAttribute('required');
            companyName.value = '';
            taxCode.value = '';
        }
    }

    // Tự động kiểm tra trạng thái cũ sau khi trang bị load lại (Old Old State Laravel)
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('vatCheck').checked) {
            document.getElementById('company_name').setAttribute('required', 'required');
            document.getElementById('tax_code').setAttribute('required', 'required');
        }
    });

    // Bản đồ mini Leaflet & Autocomplete gợi ý địa chỉ OpenStreetMap
    document.addEventListener("DOMContentLoaded", function() {
        const addressInput = document.getElementById('address-input');
        const suggestionsBox = document.getElementById('address-suggestions');
        const mapContainer = document.getElementById('map-container');
        
        let map = null;
        let marker = null;
        let debounceTimer = null;

        function initMap(lat, lon, displayName) {
            mapContainer.style.display = 'block';
            
            if (!map) {
                map = L.map('map').setView([lat, lon], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                marker = L.marker([lat, lon]).addTo(map)
                    .bindPopup(displayName)
                    .openPopup();
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

        addressInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(debounceTimer);
            if (query.length < 3) {
                suggestionsBox.style.display = 'none';
                return;
            }

            debounceTimer = setTimeout(() => {
                const url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=vn&limit=5&q=${encodeURIComponent(query)}`;
                
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
    });

    window.useSavedAddress = function() {
        const savedAddress = @json(auth()->check() ? auth()->user()->address : '');
        const addressInput = document.getElementById('address-input');
        if (addressInput && savedAddress) {
            addressInput.value = savedAddress;
            addressInput.dispatchEvent(new Event('input'));
        }
    };
</script>
@endsection