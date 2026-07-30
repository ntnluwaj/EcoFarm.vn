@extends('frontend.layouts.master')

@section('content')
<style>
    .auth-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8fafc;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    .auth-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: #ffffff;
    }
    .auth-banner {
        background: linear-gradient(135deg, #1b5e20, #2e7d32, #4caf50);
        color: #ffffff;
        padding: 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }
    .auth-banner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" stroke="white" stroke-width="1" fill="none" opacity="0.05"/></svg>');
        background-size: 40px 40px;
        pointer-events: none;
    }
    .auth-form-side {
        padding: 48px;
    }
    .form-control-custom {
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        padding: 12px 16px;
        border-radius: 10px;
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
        border-radius: 10px 0 0 10px;
        color: #64748b;
    }
    .form-control-custom-right {
        border-radius: 0 10px 10px 0 !important;
        border-left: none !important;
    }
    .btn-auth-submit {
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        border: none;
        padding: 12px;
        font-weight: 700;
        border-radius: 10px;
        color: #ffffff;
        font-size: 14.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }
    .btn-auth-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(46, 125, 50, 0.3);
        opacity: 0.95;
    }
    .benefit-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 14.5px;
    }
    .benefit-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
</style>

<div class="auth-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="auth-card card">
                    <div class="row g-0">
                        <!-- Left side: Marketing Banner -->
                        <div class="col-md-5 d-none d-md-flex auth-banner">
                            <div class="mb-5">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 60px; filter: brightness(0) invert(1);" class="mb-2">
                                </a>
                                <h4 class="fw-bold mt-2">Nền tảng Vật tư & Kỹ thuật Nông nghiệp số</h4>
                            </div>
                            <div class="my-auto">
                                <div class="benefit-item">
                                    <div class="benefit-icon"><i class="fa-solid fa-leaf"></i></div>
                                    <span>Vật tư nông nghiệp chính hãng 100% từ đối tác lớn.</span>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon"><i class="fa-solid fa-user-doctor"></i></div>
                                    <span>Đội ngũ kỹ sư nông nghiệp sẵn sàng hỗ trợ 24/7.</span>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon"><i class="fa-solid fa-qrcode"></i></div>
                                    <span>Thanh toán thông minh, đối soát dòng tiền tự động.</span>
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
