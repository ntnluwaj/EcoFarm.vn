@extends('frontend.layouts.master')

@section('content')
<div class="container my-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="row justify-content-center">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="text-center py-3 border-bottom mb-3">
                    <div class="position-relative d-inline-block mb-2.5">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle border border-2 border-success shadow-sm" style="width: 75px; height: 75px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center" style="width: 75px; height: 75px;">
                                <i class="fa-solid fa-circle-user fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                    <span class="badge bg-success-subtle text-success text-xs px-2.5 py-1">{{ strtoupper($user->role) }}</span>
                </div>
                <div class="list-group list-group-flush" style="font-size: 14px;">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-success bg-success-subtle rounded-3">
                        <i class="fa-solid fa-user-gear me-2"></i>Thông tin cá nhân
                    </a>
                    <a href="{{ route('cart.history') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Lịch sử đơn hàng
                    </a>
                    <a href="{{ route('rewards.index') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-gift me-2"></i>Tích điểm đổi quà
                    </a>
                    <a href="{{ route('profile.vouchers') }}" class="list-group-item list-group-item-action border-0 py-2.5 fw-semibold text-dark hover-success">
                        <i class="fa-solid fa-ticket me-2"></i>Ví Voucher của tôi
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa-solid fa-id-card text-success me-2"></i>Quản lý thông tin tài khoản
                    </h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="font-size: 13.5px;">
                            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="font-size: 13.5px;">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Vui lòng kiểm tra lại dữ liệu nhập vào:
                            <ul class="mb-0 mt-1.5 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- Ảnh đại diện (Avatar) -->
                            <div class="col-md-12 d-flex align-items-center gap-3 mb-3 pb-3 border-bottom border-light-subtle">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle border border-2 border-success shadow-sm" style="width: 65px; height: 65px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 65px; height: 65px;">
                                        <i class="fa-solid fa-circle-user fs-2"></i>
                                    </div>
                                @endif
                                <div>
                                    <label for="avatar" class="form-label fw-semibold text-dark mb-1" style="font-size: 13px;">Thay đổi ảnh đại diện</label>
                                    <input type="file" class="form-control form-control-sm rounded-3" id="avatar" name="avatar" accept="image/*">
                                    <div class="form-text text-muted text-xs">Hỗ trợ JPG, PNG, GIF. Dung lượng tối đa 2MB.</div>
                                </div>
                            </div>

                            <!-- Họ và tên -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark" style="font-size: 13px;">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Email (Disabled) -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ Email</label>
                                <input type="email" class="form-control rounded-3 bg-light" id="email" value="{{ $user->email }}" disabled>
                                <div class="form-text text-muted text-xs">Email dùng để đăng nhập và không thể thay đổi.</div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold text-dark" style="font-size: 13px;">Số điện thoại</label>
                                <input type="text" class="form-control rounded-3" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <!-- Địa chỉ giao hàng mặc định -->
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ giao hàng mặc định</label>
                                <textarea class="form-control rounded-3" id="address" name="address" rows="2" placeholder="Ví dụ: 123 Đường 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ">{{ old('address', $user->address) }}</textarea>
                                <div class="form-text text-success text-xs mt-1">
                                    <i class="fa-solid fa-circle-info me-1"></i>Địa chỉ này sẽ được tự động điền vào hóa đơn khi bạn đặt mua hàng để tiết kiệm thời gian!
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <h6 class="fw-bold text-dark mb-2.5">
                                <i class="fa-solid fa-lock text-success me-2"></i>Thay đổi mật khẩu (Bỏ trống nếu giữ nguyên)
                            </h6>

                            <!-- Mật khẩu mới -->
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold text-dark" style="font-size: 13px;">Mật khẩu mới</label>
                                <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Tối thiểu 6 ký tự">
                            </div>

                            <!-- Xác nhận mật khẩu mới -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold text-dark" style="font-size: 13px;">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                            </div>
                        </div>

                        <div class="mt-4 pt-2 border-top border-light-subtle d-flex justify-content-end">
                            <button type="submit" class="btn btn-success fw-semibold rounded-3 px-4 py-2" style="background-color: #2e7d32; border: none;">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
