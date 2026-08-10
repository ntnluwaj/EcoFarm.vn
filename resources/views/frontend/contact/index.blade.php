@extends('frontend.layouts.master')

@section('title', 'Liên Hệ & Tư Vấn Kỹ Thuật Nông Nghiệp - EcoFarm')

@section('content')
<style>
    /* Styling inspired by modern organic agriculture design layout */
    .contact-hero {
        position: relative;
        background: linear-gradient(180deg, rgba(15, 45, 20, 0.85) 0%, rgba(27, 94, 32, 0.92) 100%), 
                    url('https://images.unsplash.com/photo-1592982537447-7440770cbfc9?q=80&w=1600&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        color: #ffffff;
        padding-top: 5rem;
        padding-bottom: 7rem;
    }

    .hero-pill-badge {
        display: inline-block;
        border: 1px solid rgba(255, 255, 255, 0.4);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
    }

    .torn-paper-divider {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        z-index: 2;
    }
    .torn-paper-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 55px;
    }

    .contact-card-beige {
        background-color: #f7f4ea;
        border: 2px dashed #e2d9bc;
        border-radius: 24px;
        padding: 40px 28px 30px 28px;
        position: relative;
        transition: all 0.3s ease;
    }
    .contact-card-green {
        background: linear-gradient(135deg, #1b4317 0%, #2e5b29 100%);
        color: #ffffff;
        border-radius: 24px;
        padding: 40px 28px 30px 28px;
        position: relative;
        box-shadow: 0 15px 35px rgba(27, 67, 23, 0.25);
        transition: all 0.3s ease;
    }
    .contact-card-beige:hover, .contact-card-green:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .card-floating-icon {
        position: absolute;
        top: -24px;
        left: 50%;
        transform: translateX(-50%);
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    .icon-green-bg {
        background-color: #2e5b29;
        color: #ffffff;
    }
    .icon-light-bg {
        background-color: #8bc34a;
        color: #ffffff;
    }

    .form-input-beige {
        background-color: #f7f4ea !important;
        border: 1px dashed #d6ccb0 !important;
        border-radius: 16px !important;
        padding: 12px 18px !important;
        font-size: 14px !important;
        color: #1b4317 !important;
        transition: all 0.2s ease;
    }
    .form-input-beige:focus {
        border-color: #2e5b29 !important;
        box-shadow: 0 0 0 3px rgba(46, 91, 41, 0.15) !important;
        background-color: #ffffff !important;
    }

    .btn-lime-submit {
        background-color: #8bc34a;
        color: #ffffff;
        font-weight: 800;
        font-size: 15px;
        border-radius: 50px;
        padding: 12px 36px;
        border: none;
        box-shadow: 0 8px 20px rgba(139, 195, 74, 0.35);
        transition: all 0.3s ease;
    }
    .btn-lime-submit:hover {
        background-color: #7cb342;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(139, 195, 74, 0.45);
    }
</style>

<!-- 🌟 HERO SECTION WITH TORN PAPER BOTTOM DIVIDER -->
<div class="contact-hero text-center">
    <div class="container position-relative z-1" style="max-width: 800px;">
        <span class="hero-pill-badge mb-3">
            <i class="fa-solid fa-seedling me-1 text-warning"></i> Tư Vấn Nông Nghiệp EcoFarm
        </span>
        <h1 class="display-4 fw-extrabold text-white mb-3" style="font-weight: 900; letter-spacing: -0.5px;">
            Liên Hệ Với Chúng Tôi
        </h1>
        <p class="lead text-white-50 mx-auto font-medium" style="font-size: 16.5px; line-height: 1.6; max-width: 680px;">
            Đội ngũ kỹ sư nông học EcoFarm sẵn sàng tư vấn kỹ thuật canh tác, hướng dẫn liều lượng bón phân và hỗ trợ báo giá phân phối vật tư chính hãng cho nhà vườn.
        </p>
    </div>

    <!-- Organic Torn Paper Bottom Divider -->
    <div class="torn-paper-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,65 C650,140 900,10 1200,45 L1200,120 L0,120 Z" fill="#ffffff"></path>
        </svg>
    </div>
</div>

<!-- 🌟 TOP 3 FEATURED CONTACT CARDS (MATCHING MOCKUP LAYOUT) -->
<div class="container" style="margin-top: -30px; position: relative; z-index: 3; max-width: 1100px;">
    <div class="row g-4 justify-content-center">
        
        <!-- CARD 1: PHONE HOTLINE (BEIGE) -->
        <div class="col-md-4">
            <div class="contact-card-beige text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-green-bg">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-dark mb-2" style="font-weight: 800; font-size: 20px; color: #1b4317 !important;">
                        0398 037 435
                    </h4>
                    <p class="text-secondary small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Tổng đài tư vấn kỹ thuật nông nghiệp, chẩn đoán sâu bệnh & hỗ trợ đặt hàng hỏa tốc 24/7.
                    </p>
                </div>
                <div>
                    <a href="tel:0398037435" class="fw-bold text-success text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Gọi Cho Kỹ Sư Ngay &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- CARD 2: EMAIL SUPPORT (SOLID FOREST GREEN) -->
        <div class="col-md-4">
            <div class="contact-card-green text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-light-bg">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-white mb-2" style="font-weight: 800; font-size: 20px;">
                        contact@ecofarm.vn
                    </h4>
                    <p class="text-white-50 small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Hỗ trợ tiếp nhận thông tin báo giá đại lý, hóa đơn VAT và giải đáp thắc mắc về sản phẩm.
                    </p>
                </div>
                <div>
                    <a href="mailto:contact@ecofarm.vn" class="fw-bold text-warning text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Gửi Email Thắc Mắc &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- CARD 3: ADDRESS LOCATION (BEIGE) -->
        <div class="col-md-4">
            <div class="contact-card-beige text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-green-bg">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-dark mb-2" style="font-weight: 800; font-size: 20px; color: #1b4317 !important;">
                        TP. Cần Thơ, Việt Nam
                    </h4>
                    <p class="text-secondary small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Trung tâm phân phối vật tư & Kho vận vật tư nông nghiệp chính hãng đồng bằng Sông Cửu Long.
                    </p>
                </div>
                <div>
                    <a href="#location-map" class="fw-bold text-success text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Xem Bản Đồ Kho Vận &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 🌟 BOTTOM 2-COLUMN SECTION: WORKING TIME & GET IN TOUCH FORM -->
<div class="container py-5 my-4" style="max-width: 1100px;">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-5 p-3.5" role="alert" style="background-color: #e8f5e9; color: #1b5e20;">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5 align-items-start">
        
        <!-- LEFT COLUMN: WORKING TIME & LOCATION MAP -->
        <div class="col-lg-5">
            
            <h3 class="fw-extrabold text-dark mb-2" style="font-weight: 800; color: #1b4317 !important;">
                Giờ Làm Việc Của EcoFarm
            </h3>
            <p class="text-secondary small mb-4" style="font-size: 14px; line-height: 1.6;">
                Đội ngũ kỹ sư hỗ trợ trực tuyến liên tục trong giờ làm việc. Ngoài giờ hành chính, quý khách có thể gửi tin nhắn để kỹ sư phản hồi vào sáng hôm sau.
            </p>

            <!-- WORKING TIME LIST -->
            <div class="d-flex flex-column gap-2.5 mb-4 text-sm">
                <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 bg-light border border-light-subtle">
                    <span class="text-success fs-5"><i class="fa-regular fa-clock"></i></span>
                    <div>
                        <strong class="text-dark d-block">Thứ Hai - Thứ Sáu:</strong>
                        <span class="text-muted">7:00 AM - 6:00 PM</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 bg-light border border-light-subtle">
                    <span class="text-success fs-5"><i class="fa-regular fa-clock"></i></span>
                    <div>
                        <strong class="text-dark d-block">Thứ Bảy:</strong>
                        <span class="text-muted">7:30 AM - 5:00 PM</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 bg-light border border-light-subtle">
                    <span class="text-danger fs-5"><i class="fa-solid fa-triangle-exclamation"></i></span>
                    <div>
                        <strong class="text-dark d-block">Chủ Nhật & Ngày Lễ:</strong>
                        <span class="text-muted">8:00 AM - 12:00 PM (Hotline khẩn cấp)</span>
                    </div>
                </div>
            </div>

            <!-- LOCATION MAP HEADER -->
            <h4 class="fw-bold text-dark mb-3 mt-4" id="location-map" style="font-size: 18px; color: #1b4317 !important;">
                Vị Trí Kho Trung Tâm :
            </h4>
            
            <!-- GOOGLE MAP EMBEDDED -->
            <div class="rounded-4 overflow-hidden shadow-sm border border-light-subtle" style="height: 230px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.84777552802!2d105.78018337583637!3d10.045952671800164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a062a728a3013d%3A0xb7e584f2ffc4285b!2zQ8OhaSBLaOG6vywgTmluaCBLacOqzIB1LCBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>

        <!-- RIGHT COLUMN: GET IN TOUCH FORM (MATCHING MOCKUP LAYOUT) -->
        <div class="col-lg-7">
            
            <div class="text-end-md mb-2">
                <span class="hero-pill-badge text-success border-success-subtle bg-success-subtle">
                    Liên Hệ Tức Thì
                </span>
            </div>

            <h2 class="display-6 fw-extrabold text-dark mb-4" style="font-weight: 900; color: #1b4317 !important;">
                Gửi Yêu Cầu Tư Vấn !
            </h2>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4.5 bg-white" style="border: 1px solid rgba(0,0,0,0.06) !important;">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Họ và Tên -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-dark small">Họ và Tên Quý Khách *</label>
                            <input type="text" name="name" id="name" class="form-control form-input-beige" placeholder="Nhập họ và tên..." value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold text-dark small">Số Điện Thoại Nhận Tư Vấn *</label>
                            <input type="text" name="phone" id="phone" class="form-control form-input-beige" placeholder="Ví dụ: 0907xxxxxx" value="{{ old('phone', auth()->check() ? auth()->user()->phone : '') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label for="email" class="form-label fw-bold text-dark small">Địa Chỉ Email (Nếu có)</label>
                            <input type="email" name="email" id="email" class="form-control form-input-beige" placeholder="Ví dụ: nhavuon@gmail.com" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}">
                        </div>

                        <!-- Vấn đề cần tư vấn (Chủ đề) -->
                        <div class="col-12">
                            <label for="subject" class="form-label fw-bold text-dark small">Chủ Đề & Vấn Đề Cần Kỹ Sư Hỗ Trợ *</label>
                            <input type="text" name="subject" id="subject" class="form-control form-input-beige" placeholder="Ví dụ: Tư vấn quy trình xử lý ra hoa sầu riêng / Báo giá phân bón Đầu Trâu" value="{{ old('subject') }}" required>
                        </div>

                        <!-- Nội dung chi tiết -->
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold text-dark small">Nội Dung Tin Nhắn Chi Tiết *</label>
                            <textarea name="message" id="message" rows="4" class="form-control form-input-beige" placeholder="Mô tả cụ thể triệu chứng sâu bệnh trên cây trồng, diện tích nhà vườn hoặc câu hỏi vật tư..." required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 text-start">
                        <button type="submit" class="btn btn-lime-submit">
                            Gửi Yêu Cầu Tư Vấn
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
