@extends('frontend.layouts.master')

@section('content')
<div class="container my-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card border-0 shadow-lg rounded-4 bg-white p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 70px; object-fit: contain;" class="mb-3">
                    <h3 class="fw-bold text-success">Đăng nhập tài khoản</h3>
                    <p class="text-muted small">Chào mừng bà con trở lại với cửa hàng vật tư EcoFarm</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="font-size: 13.5px;">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="email" name="email" placeholder="Nhập địa chỉ email đăng ký" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-dark" style="font-size: 13px;">Mật khẩu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="password" name="password" placeholder="Nhập mật khẩu tài khoản" required>
                        </div>
                    </div>

                    <!-- Ghi nhớ đăng nhập -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" style="user-select: none;" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="#" onclick="alert('Bà con vui lòng liên hệ hotline 1900 888 999 để kỹ sư hỗ trợ cấp lại mật khẩu nhé!')" class="text-success small fw-semibold text-decoration-none">Quên mật khẩu?</a>
                    </div>

                    <!-- Nút đăng nhập -->
                    <button type="submit" class="btn btn-success w-100 fw-semibold rounded-3 py-2.5 mb-3" style="background-color: #2e7d32; border: none; font-size: 14.5px;">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Đăng nhập tài khoản
                    </button>

                    <!-- Chưa có tài khoản -->
                    <div class="text-center mt-3">
                        <span class="text-muted small">Bà con chưa có tài khoản?</span>
                        <a href="{{ route('register') }}" class="text-success small fw-semibold text-decoration-none ms-1">Đăng ký thành viên mới</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
