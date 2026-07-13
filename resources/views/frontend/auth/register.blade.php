@extends('frontend.layouts.master')

@section('content')
<div class="container my-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-lg rounded-4 bg-white p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 70px; object-fit: contain;" class="mb-3">
                    <h3 class="fw-bold text-success">Đăng ký tài khoản</h3>
                    <p class="text-muted small">Đăng ký ngay để mua sắm vật tư nông nghiệp và cập nhật cẩm nang kỹ thuật mới nhất</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="font-size: 13.5px;">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Có lỗi xảy ra:
                        <ul class="mb-0 ps-3 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Họ tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-dark" style="font-size: 13px;">Họ tên của bà con <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-user"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="email" name="email" placeholder="email@gmail.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Số điện thoại -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold text-dark" style="font-size: 13px;">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="phone" name="phone" placeholder="Để kỹ sư liên hệ hỗ trợ" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <!-- Địa chỉ nhận hàng mặc định -->
                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ nhận hàng mặc định (Nếu có)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-location-dot"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="address" name="address" placeholder="Ví dụ: 123 Đường 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ" value="{{ old('address') }}">
                        </div>
                        <div class="form-text text-muted" style="font-size: 11px;">Địa chỉ này sẽ được tự động điền khi thanh toán hóa đơn để tiết kiệm thời gian.</div>
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-dark" style="font-size: 13px;">Mật khẩu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="password" name="password" placeholder="Tối thiểu 6 ký tự" required>
                        </div>
                    </div>

                    <!-- Xác nhận mật khẩu -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-dark" style="font-size: 13px;">Xác nhận lại mật khẩu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0 rounded-end-3" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu phía trên" required>
                        </div>
                    </div>

                    <!-- Nút đăng ký -->
                    <button type="submit" class="btn btn-success w-100 fw-semibold rounded-3 py-2.5 mb-3" style="background-color: #2e7d32; border: none; font-size: 14.5px;">
                        <i class="fa-solid fa-user-plus me-2"></i>Đăng ký tài khoản mới
                    </button>

                    <!-- Đã có tài khoản -->
                    <div class="text-center mt-3">
                        <span class="text-muted small">Bà con đã có tài khoản rồi?</span>
                        <a href="{{ route('login') }}" class="text-success small fw-semibold text-decoration-none ms-1">Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
