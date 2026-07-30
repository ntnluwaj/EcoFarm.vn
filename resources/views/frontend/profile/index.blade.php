@extends('frontend.layouts.master')

@section('content')
<style>
    /* Premium style overrides for Profile Page */
    .profile-card-banner {
        height: 90px;
        background: linear-gradient(135deg, #a3e635 0%, #10b981 100%);
    }
    .profile-menu-item {
        color: #4b5563 !important;
        background-color: transparent !important;
        border: none !important;
        transition: all 0.2s ease-in-out !important;
        font-size: 13.5px;
        border-radius: 8px !important;
        margin-bottom: 4px;
    }
    .profile-menu-item:hover {
        background-color: rgba(16, 185, 129, 0.06) !important;
        color: #059669 !important;
        transform: translateX(4px);
    }
    .profile-menu-item:hover i {
        color: #059669 !important;
    }
    .profile-menu-item.active-menu {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.18) !important;
    }
    .profile-menu-item.active-menu i {
        color: #ffffff !important;
    }
    
    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12) !important;
    }
    
    .avatar-wrapper {
        width: 85px;
        height: 85px;
        margin-top: -45px;
    }
    .avatar-img {
        width: 85px;
        height: 85px;
        object-fit: cover;
        background-color: #ffffff;
        border: 4px solid #ffffff;
    }
    .avatar-placeholder {
        width: 85px;
        height: 85px;
        background-color: #ffffff;
        border: 4px solid #ffffff;
    }
</style>

<div class="container my-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="row justify-content-center">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <!-- Cover Banner -->
                <div class="profile-card-banner"></div>
                
                <!-- Avatar & Role info -->
                <div class="text-center px-3 pb-3 position-relative">
                    <div class="avatar-wrapper position-relative d-inline-block mx-auto mb-2">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img rounded-circle shadow-sm">
                        @else
                            <div id="avatar-placeholder" class="avatar-placeholder rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center shadow-sm">
                                <i class="fa-solid fa-circle-user fs-1"></i>
                            </div>
                        @endif
                        <!-- Camera button overlay -->
                        <button type="button" class="position-absolute bottom-0 end-0 btn btn-success p-0 rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 28px; height: 28px; border: 2.5px solid white;" onclick="document.getElementById('avatar').click()">
                            <i class="fa-solid fa-camera" style="font-size: 11px;"></i>
                        </button>
                    </div>
                    
                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 15px;">{{ $user->name }}</h6>
                    <span class="badge bg-success-subtle text-success text-xs px-2.5 py-1 mb-2">{{ strtoupper($user->role) }}</span>
                    
                    <div class="mt-1 mb-2">
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold text-xs" style="font-size: 11px;" onclick="document.getElementById('avatar').click()">
                            <i class="fa-solid fa-image me-1"></i>Thay đổi ảnh
                        </button>
                    </div>
                </div>
                
                <!-- Navigation menu -->
                <div class="list-group list-group-flush px-3 pb-3 border-0">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action profile-menu-item active-menu d-flex align-items-center gap-2 py-2.5 px-3">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                    <a href="{{ route('cart.history') }}" class="list-group-item list-group-item-action profile-menu-item d-flex align-items-center gap-2 py-2.5 px-3">
                        <i class="fa-solid fa-clock-rotate-left text-muted"></i>
                        <span>Lịch sử đơn hàng</span>
                    </a>
                    <a href="{{ route('rewards.index') }}" class="list-group-item list-group-item-action profile-menu-item d-flex align-items-center gap-2 py-2.5 px-3">
                        <i class="fa-solid fa-gift text-muted"></i>
                        <span>Tích điểm đổi quà</span>
                    </a>
                    <a href="{{ route('profile.vouchers') }}" class="list-group-item list-group-item-action profile-menu-item d-flex align-items-center gap-2 py-2.5 px-3">
                        <i class="fa-solid fa-ticket text-muted"></i>
                        <span>Ví Voucher của tôi</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-id-card text-success"></i>
                        <span>Thông tin tài khoản</span>
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
                        
                        <!-- Hidden input for avatar upload -->
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none">

                        <!-- Main Info Grid -->
                        <div class="row g-3 mb-4">
                            <!-- Họ và tên -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark mb-1" style="font-size: 13px;">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold text-dark mb-1" style="font-size: 13px;">Số điện thoại</label>
                                <input type="text" class="form-control rounded-3" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <!-- Email (Disabled) -->
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold text-dark mb-1" style="font-size: 13px;">Địa chỉ Email</label>
                                <input type="email" class="form-control rounded-3 bg-light" id="email" value="{{ $user->email }}" disabled>
                                <div class="form-text text-muted text-xs mt-1">Email này dùng để đăng nhập hệ thống và không được chỉnh sửa.</div>
                            </div>

                            <!-- Địa chỉ giao hàng mặc định -->
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-semibold text-dark mb-1" style="font-size: 13px;">Địa chỉ nhận hàng mặc định</label>
                                <textarea class="form-control rounded-3" id="address" name="address" rows="2" placeholder="Ví dụ: 123 Đường 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ">{{ old('address', $user->address) }}</textarea>
                                <div class="form-text text-success text-xs mt-1">
                                    <i class="fa-solid fa-circle-info me-1"></i>Địa chỉ này sẽ được điền tự động vào hoá đơn thanh toán giúp tiết kiệm thời gian!
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Block (Premium Card style) -->
                        <div class="card border-0 bg-light p-3 rounded-4 mb-4" style="border: 1px solid rgba(0, 0, 0, 0.04) !important;">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 13.5px;">
                                <i class="fa-solid fa-lock text-success"></i>
                                <span>Thay đổi mật khẩu tài khoản</span>
                            </h6>
                            <div class="row g-3">
                                <!-- Mật khẩu mới -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold text-dark mb-1" style="font-size: 12.5px;">Mật khẩu mới</label>
                                    <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Tối thiểu 6 ký tự">
                                </div>

                                <!-- Xác nhận mật khẩu mới -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark mb-1" style="font-size: 12.5px;">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 pt-3 border-top border-light-subtle d-flex justify-content-end">
                            <button type="submit" class="btn btn-success fw-semibold rounded-3 px-4 py-2.5 shadow-sm hover-scale" style="background-color: #2e7d32; border: none; transition: all 0.2s ease;">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            const objectUrl = URL.createObjectURL(file);
            
            if (preview) {
                preview.src = objectUrl;
            } else if (placeholder) {
                // Replace placeholder div with an image element
                const parent = placeholder.parentNode;
                const img = document.createElement('img');
                img.id = 'avatar-preview';
                img.src = objectUrl;
                img.className = 'avatar-img rounded-circle shadow-sm';
                img.style.objectFit = 'cover';
                parent.replaceChild(img, placeholder);
            }
        }
    });
</script>
@endsection
