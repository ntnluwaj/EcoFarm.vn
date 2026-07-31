@extends('frontend.layouts.master')

@section('content')
<!-- Leaflet Map CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .auth-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f1f5f9;
        min-height: 75vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        z-index: 2;
    }
    /* 🌟 BACKGROUND FLOATING ORGANIC BLOBS */
    .auth-bg-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        z-index: 1;
        pointer-events: none;
    }
    .auth-shape-1 {
        width: 300px;
        height: 300px;
        background: #81c784;
        top: -50px;
        left: -50px;
        opacity: 0.25;
        animation: float-blob-1 15s ease-in-out infinite;
    }
    .auth-shape-2 {
        width: 450px;
        height: 450px;
        background: #2e7d32;
        bottom: -100px;
        right: -100px;
        opacity: 0.18;
        animation: float-blob-2 20s ease-in-out infinite;
    }
    .auth-shape-3 {
        width: 250px;
        height: 250px;
        background: #a5d6a7;
        top: 35%;
        right: 15%;
        opacity: 0.2;
        animation: float-blob-1 18s ease-in-out infinite;
    }

    @keyframes float-blob-1 {
        0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
        50% { transform: translateY(-30px) scale(1.1) rotate(15deg); }
    }
    @keyframes float-blob-2 {
        0%, 100% { transform: translateY(0px) scale(1.1) rotate(0deg); }
        50% { transform: translateY(30px) scale(0.9) rotate(-15deg); }
    }

    .auth-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: #ffffff;
        position: relative;
        z-index: 10;
    }
    .auth-banner {
        background: linear-gradient(135deg, #1b5e20, #2e7d32, #4caf50);
        color: #ffffff;
        padding: 48px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }
    .auth-banner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" stroke="white" stroke-width="1" fill="none" opacity="0.05"/></svg>');
        background-size: 45px 45px;
        pointer-events: none;
    }
    .auth-form-side {
        padding: 48px;
    }
    .form-control-custom {
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #2e7d32;
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.15);
    }
    .input-group-custom-text {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: #64748b;
        padding-left: 18px;
        padding-right: 18px;
    }
    .form-control-custom-right {
        border-radius: 0 12px 12px 0 !important;
        border-left: none !important;
    }
    .btn-auth-submit {
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        border: none;
        padding: 14px;
        font-weight: 700;
        border-radius: 12px;
        color: #ffffff;
        font-size: 14.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        letter-spacing: 0.5px;
    }
    .btn-auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.45);
        background: linear-gradient(135deg, #1b5e20, #0f3d11);
    }
    .benefit-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        font-size: 14px;
    }
    .benefit-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* 🌟 GLASSMORPHISM TESTIMONIAL CARD */
    .glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15);
    }
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffc107;
        color: #1b5e20;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 13px;
    }
    /* 🌟 SUGGESTION DROPDOWN STYLES */
    #address-suggestions {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-top: 4px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden;
    }
    .suggestion-item {
        padding: 12px 16px;
        font-size: 13.5px;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .suggestion-item:last-child {
        border-bottom: none;
    }
    .suggestion-item:hover {
        background-color: #f1f8f5;
        color: #1b5e20;
    }
    .suggestion-item i {
        color: #94a3b8;
    }
</style>

<div class="auth-container py-5">
    <!-- Floating background circles -->
    <div class="auth-bg-shape auth-shape-1"></div>
    <div class="auth-bg-shape auth-shape-2"></div>
    <div class="auth-bg-shape auth-shape-3"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="auth-card card">
                    <div class="row g-0">
                        <!-- Left side: Marketing Banner -->
                        <div class="col-md-5 d-none d-md-flex auth-banner">
                            <div>
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 55px; filter: brightness(0) invert(1);" class="mb-2">
                                </a>
                                <h5 class="fw-bold mt-2">Nền tảng Vật tư & Kỹ thuật Nông nghiệp số</h5>
                                <div class="mt-4">
                                    <div class="benefit-item">
                                        <div class="benefit-icon"><i class="fa-solid fa-leaf"></i></div>
                                        <span>Vật tư nông nghiệp chính hãng 100%</span>
                                    </div>
                                    <div class="benefit-item">
                                        <div class="benefit-icon"><i class="fa-solid fa-user-doctor"></i></div>
                                        <span>Kỹ sư hỗ trợ canh tác trực tuyến 24/7</span>
                                    </div>
                                    <div class="benefit-item">
                                        <div class="benefit-icon"><i class="fa-solid fa-qrcode"></i></div>
                                        <span>Thanh toán thông minh VietQR tiện lợi</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-3 border-top border-white-50 text-white-50 small">
                                <i class="fa-solid fa-shield-halved me-1"></i> Hệ thống bảo mật thông tin tối cao.
                            </div>
                        </div>

                        <!-- Right side: Register Form -->
                        <div class="col-md-7 auth-form-side">
                            <div class="mb-4">
                                <h3 class="fw-extrabold text-dark mb-1">Đăng ký tài khoản</h3>
                                <p class="text-muted small">Đăng ký ngay để mua sắm vật tư nông nghiệp và cập nhật cẩm nang kỹ thuật mới nhất.</p>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4 p-3" role="alert" style="font-size: 13px; background-color: #ffebee; color: #c62828;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                                        <div>
                                            <ul class="mb-0 ps-3 mt-1">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('register') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <!-- Họ tên -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-bold text-dark small">Họ tên của quý khách <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control form-control-custom form-control-custom-right" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-bold text-dark small">Địa chỉ Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-regular fa-envelope"></i></span>
                                            <input type="email" class="form-control form-control-custom form-control-custom-right" id="email" name="email" placeholder="email@gmail.com" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <!-- Số điện thoại -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-bold text-dark small">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-solid fa-phone"></i></span>
                                            <input type="text" class="form-control form-control-custom form-control-custom-right" id="phone" name="phone" placeholder="Số điện thoại của bạn" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>

                                    <!-- Mật khẩu -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-bold text-dark small">Mật khẩu <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control form-control-custom form-control-custom-right" id="password" name="password" placeholder="Tối thiểu 6 ký tự" required>
                                        </div>
                                    </div>

                                    <!-- Địa chỉ nhận hàng mặc định -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark small">Địa chỉ nhận hàng mặc định <span class="text-danger">*</span></label>
                                        
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

                                        <div class="form-text text-muted mb-2 mt-1" style="font-size: 11px;">Kéo ghim hoặc click chọn điểm trên bản đồ bên dưới để tự động điền địa chỉ:</div>
                                        
                                        <!-- Map container -->
                                        <div class="position-relative overflow-hidden rounded-3 border" style="border-color: #e2e8f0 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.02); height: 260px;">
                                            <div id="map" style="height: 100%; z-index: 1;"></div>
                                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2 text-center" style="z-index: 1000; font-size: 11px; backdrop-filter: blur(4px);">
                                                <i class="fa-solid fa-circle-info text-warning me-1"></i> Kéo ghim hoặc click chọn điểm trên bản đồ để tự động dịch thành địa chỉ chữ.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Xác nhận mật khẩu -->
                                    <div class="col-12">
                                        <label for="password_confirmation" class="form-label fw-bold text-dark small">Xác nhận lại mật khẩu <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-solid fa-shield-halved"></i></span>
                                            <input type="password" class="form-control form-control-custom form-control-custom-right" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu phía trên" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-auth-submit w-100 mt-4 mb-3 d-inline-flex justify-content-center align-items-center gap-2">
                                    <i class="fa-solid fa-user-plus"></i> ĐĂNG KÝ TÀI KHOẢN MỚI
                                </button>

                                <!-- Login Link -->
                                <div class="text-center mt-3">
                                    <span class="text-muted small">Quý khách đã có tài khoản rồi?</span>
                                    <a href="{{ route('login') }}" class="text-success small fw-bold text-decoration-none ms-1">Đăng nhập ngay</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Map JS and Logic -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
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

    document.addEventListener("DOMContentLoaded", function () {
        // Tọa độ mặc định: Cần Thơ, Việt Nam (10.0356, 105.7801)
        var defaultLat = 10.0356;
        var defaultLng = 105.7801;

        // Khởi tạo bản đồ
        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Nạp các ô bản đồ từ OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tạo marker có thể kéo thả
        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

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
                            
                            isUpdatingFromMap = true;
                            map.setView([lat, lon], 16);
                            marker.setLatLng([lat, lon]);
                            setTimeout(() => {
                                isUpdatingFromMap = false;
                            }, 500);
                        }
                    })
                    .catch(err => console.error('Geocoding form error:', err));
            }, 1000);
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

        // Hàm gọi API Reverse Geocoding của Nominatim (OpenStreetMap)
        function updateAddressFromCoords(lat, lng) {
            var searchInput = document.getElementById('address-search');
            if (searchInput) searchInput.placeholder = "Đang định vị địa chỉ từ bản đồ...";

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1&accept-language=vi`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        isUpdatingFromMap = true;
                        if (searchInput && data.display_name) {
                            searchInput.value = data.display_name;
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
                    if (searchInput) searchInput.placeholder = "Gõ để tìm kiếm địa chỉ nhanh...";
                })
                .catch(error => {
                    isUpdatingFromMap = false;
                    console.error("Lỗi reverse geocoding:", error);
                    if (searchInput) searchInput.placeholder = "Gõ để tìm kiếm địa chỉ nhanh...";
                });
        }

        // Tự động lấy GPS trình duyệt của người dùng khi load trang
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                map.setView([userLat, userLng], 16);
                marker.setLatLng([userLat, userLng]);
                updateAddressFromCoords(userLat, userLng);
            }, function (error) {
                console.log("Quyền truy cập vị trí bị từ chối hoặc lỗi GPS, sử dụng vị trí mặc định.");
            });
        }

        // Sự kiện khi người dùng click trực tiếp lên bản đồ
        map.on('click', function (e) {
            var coords = e.latlng;
            marker.setLatLng(coords);
            updateAddressFromCoords(coords.lat, coords.lng);
        });

        // Sự kiện khi người dùng kéo thả marker xong
        marker.on('dragend', function (e) {
            var coords = marker.getLatLng();
            updateAddressFromCoords(coords.lat, coords.lng);
        });

        // 🌟 TÌM KIẾM ĐỊA CHỈ GỢI Ý & TỰ ĐỘNG BAY BẢN ĐỒ (AUTO-PAN & AUTOCONFIRM)
        var addressInput = document.getElementById('address-search');
        var suggestionsContainer = document.getElementById('address-suggestions');

        // Hàm chống rung (Debounce) để hạn chế gửi quá nhiều request
        function debounce(func, wait) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    func.apply(context, args);
                }, wait);
            };
        }

        var fetchSuggestions = debounce(function (query) {
            if (!query || query.trim().length < 3) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&limit=5&countrycodes=vn&accept-language=vi`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            var div = document.createElement('div');
                            div.className = 'dropdown-item text-wrap border-bottom text-start py-2 small';
                            div.style.fontSize = '12.5px';
                            div.style.cursor = 'pointer';
                            div.innerHTML = `<i class="fa-solid fa-location-dot text-success me-2"></i> <span>${item.display_name}</span>`;
                            div.addEventListener('click', function () {
                                addressInput.value = item.display_name;
                                var lat = parseFloat(item.lat);
                                var lon = parseFloat(item.lon);
                                
                                // Di chuyển bản đồ & ghim
                                map.setView([lat, lon], 16);
                                marker.setLatLng([lat, lon]);
                                
                                isUpdatingFromMap = true;
                                
                                // Điền địa chỉ
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
                                
                                suggestionsContainer.style.display = 'none';
                            });
                            suggestionsContainer.appendChild(div);
                        });
                        suggestionsContainer.style.display = 'block';
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error("Lỗi lấy gợi ý địa chỉ:", error);
                });
        }, 400);

        if (addressInput) {
            // Lắng nghe sự kiện gõ địa chỉ
            addressInput.addEventListener('input', function () {
                fetchSuggestions(this.value);
            });

            // Ẩn dropdown gợi ý khi click ra ngoài
            document.addEventListener('click', function (e) {
                if (e.target !== addressInput && e.target !== suggestionsContainer) {
                    suggestionsContainer.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection
