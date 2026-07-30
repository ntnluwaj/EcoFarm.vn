@extends('frontend.layouts.master')

@section('content')
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

                            <!-- Glassmorphism Signature testimonial -->
                            <div class="glass-card p-4 rounded-4 mt-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-warning text-dark fw-bold" style="font-size: 11px;"><i class="fa-solid fa-star me-1"></i>Tin cậy</span>
                                    <span class="text-white-50" style="font-size: 11px;">Chứng nhận Nông nghiệp Xanh</span>
                                </div>
                                <p class="mb-0 text-white font-italic small" style="line-height: 1.6; opacity: 0.9;">
                                    "Từ khi mua phân bón hữu cơ tại EcoFarm, vườn nhãn của tôi đạt năng suất tăng 35% mà chi phí lại tối ưu rõ rệt."
                                </p>
                                <div class="mt-3 d-flex align-items-center gap-2">
                                    <div class="avatar-circle">B</div>
                                    <div>
                                        <div class="text-white fw-bold small">Chú Bảy Sông Hậu</div>
                                        <div class="text-white-50" style="font-size: 10px;">HTX Cây ăn quả Cần Thơ</div>
                                    </div>
                                </div>
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
                                        <label for="address" class="form-label fw-bold text-dark small">Địa chỉ nhận hàng mặc định</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-custom-text"><i class="fa-solid fa-location-dot"></i></span>
                                            <input type="text" class="form-control form-control-custom form-control-custom-right" id="address" name="address" placeholder="Ví dụ: 123 Đường 3/2, Cần Thơ" value="{{ old('address') }}">
                                        </div>
                                        <div class="form-text text-muted" style="font-size: 11px;">Giúp tiết kiệm thời gian nhập khi thanh toán hóa đơn.</div>
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
@endsection
