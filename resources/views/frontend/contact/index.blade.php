@extends('frontend.layouts.master')

@section('content')
<div class="container my-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success mb-2">Liên hệ & Tư vấn kỹ thuật</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Bà con có thắc mắc về vật tư nông nghiệp, cần tư vấn quy trình canh tác hoặc chính sách đại lý? Hãy liên hệ ngay với đội ngũ kỹ sư của EcoFarm.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Contact Information Cards -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-4">Thông tin liên hệ</h5>
                
                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; min-width: 44px;">
                        <i class="fa-solid fa-phone fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Đường dây nóng</strong>
                        <span class="text-muted" style="font-size: 13.5px;">1900 888 999 - (0292) 3 888 999</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; min-width: 44px;">
                        <i class="fa-solid fa-envelope fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Địa chỉ Email</strong>
                        <span class="text-muted" style="font-size: 13.5px;">contact@ecofarm.vn</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; min-width: 44px;">
                        <i class="fa-solid fa-location-dot fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Bến bãi bốc xếp</strong>
                        <span class="text-muted" style="font-size: 13.5px;">KCN Trà Nóc, Quận Bình Thủy, TP. Cần Thơ</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; min-width: 44px;">
                        <i class="fa-solid fa-clock fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Giờ mở bến làm việc</strong>
                        <span class="text-muted" style="font-size: 13.5px;">Tất cả các ngày: 7:00 - 21:00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-4">Gửi tin nhắn tư vấn</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="font-size: 13.5px;">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Họ tên -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-dark" style="font-size: 13px;">Họ tên của bà con <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Ví dụ: Trần Văn B" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold text-dark" style="font-size: 13px;">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="phone" name="phone" placeholder="Để kỹ sư gọi lại tư vấn" value="{{ old('phone', auth()->check() ? auth()->user()->phone : '') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12">
                            <label for="email" class="form-label fw-semibold text-dark" style="font-size: 13px;">Địa chỉ Email (Nếu có)</label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="email@gmail.com" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}">
                        </div>

                        <!-- Tiêu đề -->
                        <div class="col-md-12">
                            <label for="subject" class="form-label fw-semibold text-dark" style="font-size: 13px;">Vấn đề cần tư vấn / liên hệ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="subject" name="subject" placeholder="Ví dụ: Tư vấn liều lượng bón NPK Đầu Trâu cho xoài" value="{{ old('subject') }}" required>
                        </div>

                        <!-- Nội dung tin nhắn -->
                        <div class="col-md-12">
                            <label for="message" class="form-label fw-semibold text-dark" style="font-size: 13px;">Nội dung tin nhắn chi tiết <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-3" id="message" name="message" rows="4" placeholder="Ghi rõ tình trạng vườn tược, câu hỏi kỹ thuật hoặc yêu cầu cung ứng vật tư..." required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 border-top border-light-subtle d-flex justify-content-end">
                        <button type="submit" class="btn btn-success fw-semibold rounded-3 px-4 py-2" style="background-color: #2e7d32; border: none;">
                            <i class="fa-solid fa-paper-plane me-2"></i>Gửi liên hệ tư vấn
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
