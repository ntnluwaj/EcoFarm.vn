@extends('frontend.layouts.master')

@section('title', 'Giới Thiệu Về EcoFarm - Hệ Thống Vật Tư Nông Nghiệp Hàng Đầu')

@section('content')
<style>
    /* 🌟 UNIFIED ORGANIC AGRICULTURAL DESIGN SYSTEM (100% MATCH WITH CONTACT PAGE) */
    .about-hero {
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

    .about-card-beige {
        background-color: #f7f4ea;
        border: 2px dashed #e2d9bc;
        border-radius: 24px;
        padding: 40px 28px 30px 28px;
        position: relative;
        transition: all 0.3s ease;
    }
    .about-card-green {
        background: linear-gradient(135deg, #1b4317 0%, #2e5b29 100%);
        color: #ffffff;
        border-radius: 24px;
        padding: 40px 28px 30px 28px;
        position: relative;
        box-shadow: 0 15px 35px rgba(27, 67, 23, 0.25);
        transition: all 0.3s ease;
    }
    .about-card-beige:hover, .about-card-green:hover {
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

    .eco-stat-card {
        background: #f7f4ea;
        border-radius: 20px;
        padding: 20px;
        border: 1px dashed #e2d9bc;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .eco-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1b4317 0%, #2e5b29 60%, #8bc34a 100%);
    }
    .eco-stat-card:hover {
        transform: translateY(-5px);
        background-color: #ffffff;
        box-shadow: 0 15px 30px rgba(46, 91, 41, 0.12);
    }

    .eco-feature-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }
    .eco-feature-box:hover {
        transform: translateY(-5px);
        border-color: #2e5b29;
        box-shadow: 0 16px 32px -6px rgba(46, 91, 41, 0.15);
    }

    .eco-icon-container {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: linear-gradient(135deg, #1b4317 0%, #2e5b29 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 10px 20px -4px rgba(46, 91, 41, 0.3);
        flex-shrink: 0;
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

<!-- 🌟 HERO SECTION WITH TORN PAPER BOTTOM DIVIDER (UNIFIED WITH CONTACT PAGE) -->
<div class="about-hero text-center">
    <div class="container position-relative z-1" style="max-width: 820px;">
        <span class="hero-pill-badge mb-3">
            <i class="fa-solid fa-wheat-awn me-1 text-warning"></i> Thương Hiệu Vật Tư Nông Nghiệp EcoFarm
        </span>
        <h1 class="display-4 fw-extrabold text-white mb-3" style="font-weight: 900; letter-spacing: -0.5px;">
            Giới Thiệu Về Chúng Tôi
        </h1>
        <p class="lead text-white-50 mx-auto font-medium" style="font-size: 16.5px; line-height: 1.6; max-width: 700px;">
            Đồng hành bền vững cùng bà con nông dân Việt Nam với giải pháp vật tư nông nghiệp chính hãng, chất lượng cao & tư vấn kỹ thuật canh tác tận tâm 24/7.
        </p>

        <!-- Breadcrumb Pill -->
        <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-md border mt-2" style="background-color: rgba(15, 45, 20, 0.85) !important; backdrop-filter: blur(10px); border-color: rgba(255, 255, 255, 0.3) !important;">
            <a href="{{ route('home') }}" class="fw-bold text-decoration-none" style="color: #ffffff !important; font-size: 13px;">
                <i class="fa-solid fa-house me-1" style="color: #8bc34a !important;"></i> Trang chủ
            </a>
            <span style="color: #8bc34a !important; font-weight: 900; font-size: 13px;">&gt;&gt;</span>
            <span class="fw-extrabold" style="color: #fde047 !important; font-weight: 800; font-size: 13px;">Giới thiệu công ty</span>
        </div>
    </div>

    <!-- Organic Torn Paper Bottom Divider -->
    <div class="torn-paper-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,65 C650,140 900,10 1200,45 L1200,120 L0,120 Z" fill="#ffffff"></path>
        </svg>
    </div>
</div>

<!-- 🌟 TOP 3 FEATURED OVERVIEW CARDS (UNIFIED 100% WITH CONTACT PAGE) -->
<div class="container" style="margin-top: -30px; position: relative; z-index: 3; max-width: 1100px;">
    <div class="row g-4 justify-content-center">
        
        <!-- CARD 1: 10.000+ HO NONG (BEIGE) -->
        <div class="col-md-4">
            <div class="about-card-beige text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-green-bg">
                    <i class="fa-solid fa-wheat-awn"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-dark mb-2" style="font-weight: 800; font-size: 20px; color: #1b4317 !important;">
                        10.000+ Nhà Vườn
                    </h4>
                    <p class="text-secondary small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Tin tưởng đồng hành cùng EcoFarm Mekong qua các mùa vụ trúng mùa được giá.
                    </p>
                </div>
                <div>
                    <a href="{{ route('products.index') }}" class="fw-bold text-success text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Khám Phá Vật Tư &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- CARD 2: 100% CHINH HANG (SOLID FOREST GREEN) -->
        <div class="col-md-4">
            <div class="about-card-green text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-light-bg">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-white mb-2" style="font-weight: 800; font-size: 20px;">
                        100% Chính Hãng
                    </h4>
                    <p class="text-white-50 small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Nhập khẩu và phân phối trực tiếp từ các nhà máy lớn Bayer, Syngenta, Đầu Trâu, Phú Mỹ.
                    </p>
                </div>
                <div>
                    <a href="{{ route('products.index') }}" class="fw-bold text-warning text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Kiểm Tra Cam Kết &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- CARD 3: GIAO HANG HOA TOC (BEIGE) -->
        <div class="col-md-4">
            <div class="about-card-beige text-center h-100 d-flex flex-column justify-content-between">
                <div class="card-floating-icon icon-green-bg">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="mt-2">
                    <h4 class="fw-extrabold text-dark mb-2" style="font-weight: 800; font-size: 20px; color: #1b4317 !important;">
                        Giao Hàng Hỏa Tốc
                    </h4>
                    <p class="text-secondary small mb-3" style="font-size: 13.5px; line-height: 1.5;">
                        Kho bãi trung tâm tại Cần Thơ vận chuyển vật tư trực tiếp tận tay nhà vườn toàn quốc.
                    </p>
                </div>
                <div>
                    <a href="{{ route('contact.index') }}" class="fw-bold text-success text-decoration-none small d-inline-flex align-items-center gap-1 hover-opacity">
                        <i class="fa-solid fa-circle-play me-1 text-xs"></i> Liên Hệ Kho Bãi &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 🌟 SECTION 1: STORY & STATS GRID (ORGANIC 2-COLUMN LAYOUT) -->
<div class="container py-5 my-4" style="max-width: 1100px;">
    <div class="row g-5 align-items-center">
        
        <!-- Left Column: Story & 4 Scorecard Stats -->
        <div class="col-lg-6">
            <span class="hero-pill-badge text-success border-success-subtle bg-success-subtle mb-3">
                🌿 Về EcoFarm Mekong
            </span>
            <h2 class="display-6 fw-extrabold text-dark mb-3" style="font-weight: 900; color: #1b4317 !important; font-size: 2.1rem;">
                Hệ Thống Phân Phối Vật Tư Nông Nghiệp <span class="text-success">Hàng Đầu Miền Tây</span>
            </h2>
            <p class="text-secondary mb-4" style="font-size: 15px; line-height: 1.8;">
                Khởi đầu từ khát vọng giải quyết nỗi trăn trở về chất lượng vật tư của bà con Đồng bằng sông Cửu Long, <strong>EcoFarm</strong> tự hào là đối tác chiến lược trực tiếp của các tập đoàn uy tín (Bayer, Syngenta, Đầu Trâu, Nhật Bản). Chúng tôi cam kết 100% sản phẩm chính ngạch, an toàn thổ nhưỡng và bảo vệ năng suất tối đa.
            </p>

            <!-- 4 Scorecard Stat Cards Grid (2x2) -->
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="eco-stat-card">
                        <div class="fw-extrabold tracking-tight mb-1" style="font-size: 2.1rem; color: #1b4317 !important; font-weight: 900;">10.000+</div>
                        <div class="text-secondary text-xs font-bold uppercase tracking-wider">Nhà vườn tin dùng</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="eco-stat-card">
                        <div class="fw-extrabold tracking-tight mb-1" style="font-size: 2.1rem; color: #1b4317 !important; font-weight: 900;">94%</div>
                        <div class="text-secondary text-xs font-bold uppercase tracking-wider">Tỷ lệ hài lòng</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="eco-stat-card">
                        <div class="fw-extrabold tracking-tight mb-1" style="font-size: 2.1rem; color: #1b4317 !important; font-weight: 900;">Top 100</div>
                        <div class="text-secondary text-xs font-bold uppercase tracking-wider">Thương hiệu uy tín</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="eco-stat-card">
                        <div class="fw-extrabold tracking-tight mb-1" style="font-size: 2.1rem; color: #1b4317 !important; font-weight: 900;">15+</div>
                        <div class="text-secondary text-xs font-bold uppercase tracking-wider">Năm đồng hành</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-lime-submit d-inline-flex align-items-center gap-2" style="background-color: #2e5b29; color: #ffffff;">
                <span>Khám phá sản phẩm vật tư</span> <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- Right Column: Structured Image Gallery Collage & Key Value Points -->
        <div class="col-lg-6">
            <div class="position-relative mb-4">
                <img src="{{ asset('images/ecofarm_engineer.jpg') }}" alt="Kỹ sư tư vấn nông nghiệp" class="img-fluid rounded-4 shadow-lg w-100" style="height: 270px; object-fit: cover; border: 4px solid #ffffff; box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;">
                
                <!-- Floating Badge Safely INSIDE Container -->
                <div class="position-absolute bottom-0 end-0 m-3 z-3">
                    <div class="p-3 rounded-4 text-white shadow-xl backdrop-blur-md" style="background: linear-gradient(135deg, rgba(27,67,23,0.95) 0%, rgba(46,91,41,0.95) 100%); border: 1.5px solid rgba(255,255,255,0.4); max-width: 210px;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-seedling text-warning fs-5"></i>
                            <span class="fw-extrabold text-sm" style="font-weight: 800;">EcoFarm Mekong</span>
                        </div>
                        <div class="text-xs opacity-90">Gắn kết bền vững cùng nhà nông</div>
                    </div>
                </div>
            </div>

            <!-- 2 Secondary Image Cards Row -->
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <img src="{{ asset('images/ecofarm_green_field.jpg') }}" alt="Cánh đồng Mekong" class="img-fluid rounded-4 shadow-sm w-100" style="height: 125px; object-fit: cover; border: 2px solid #ffffff;">
                </div>
                <div class="col-6">
                    <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư" class="img-fluid rounded-4 shadow-sm w-100" style="height: 125px; object-fit: cover; border: 2px solid #ffffff;">
                </div>
            </div>

            <!-- Key Value Checklist Grid -->
            <div class="row g-2.5 pt-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-light-subtle">
                        <i class="fa-solid fa-circle-check text-success fs-6"></i>
                        <span class="fw-bold text-dark text-xs">Vật tư chuẩn ISO/VietGAP</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-light-subtle">
                        <i class="fa-solid fa-user-doctor text-success fs-6"></i>
                        <span class="fw-bold text-dark text-xs">Kỹ sư hỗ trợ tận vườn 24/7</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-light-subtle">
                        <i class="fa-solid fa-truck-fast text-success fs-6"></i>
                        <span class="fw-bold text-dark text-xs">Giao hàng hỏa tốc Mekong</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-light-subtle">
                        <i class="fa-solid fa-tags text-success fs-6"></i>
                        <span class="fw-bold text-dark text-xs">Giá niêm yết nhà máy</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 🌟 SECTION 2: FULL-WIDTH LUSH GREEN CALLOUT BANNER -->
<div class="position-relative overflow-hidden text-white text-center py-5" style="background: linear-gradient(135deg, rgba(27, 67, 23, 0.95) 0%, rgba(46, 91, 41, 0.92) 100%), url('{{ asset('images/ecofarm_green_field.jpg') }}') no-repeat center center; background-size: cover; min-height: 260px; display: flex; align-items: center; justify-content: center;">
    <div class="container py-4 z-2 position-relative">
        <span class="hero-pill-badge mb-2">
            <i class="fa-solid fa-star me-1 text-warning"></i> Khám Phá EcoFarm
        </span>
        <h2 class="display-5 fw-extrabold mb-3 text-white" style="font-weight: 900; font-size: 2.35rem; text-shadow: 0 4px 12px rgba(0,0,0,0.35);">
            Giải Pháp Nông Nghiệp Toàn Diện - <span class="text-warning">Trúng Mùa Được Giá</span>
        </h2>
        <p class="lead max-w-2xl mx-auto text-light opacity-95 mb-4" style="max-width: 740px; font-size: 1.15rem; line-height: 1.7;">
            Liên kết trực tiếp chuỗi cung ứng vật tư nông nghiệp chính hãng, bảo vệ mùa màng hiệu quả và đem lại hiệu quả kinh tế vượt trội cho bà con.
        </p>
        <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-extrabold shadow-lg hover-lift" style="color: #1b4317 !important; font-weight: 800; font-size: 14px;">
            <i class="fa-solid fa-phone me-2"></i> Liên hệ tư vấn ngay
        </a>
    </div>
</div>

<!-- 🌟 SECTION 3: WHY CHOOSE ECOFARM / VALUE PROPOSITION -->
<div class="bg-light py-5">
    <div class="container py-4" style="max-width: 1100px;">
        <div class="row g-5 align-items-center">
            
            <!-- Left Column: Image with Floating Glass Badges -->
            <div class="col-lg-5">
                <div class="position-relative">
                    <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư EcoFarm" class="img-fluid rounded-4 shadow-xl w-100" style="height: 400px; object-fit: cover; border: 4px solid #ffffff;">
                    
                    <div class="position-absolute bottom-0 start-0 p-4 w-100">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-white bg-opacity-95 shadow-md border border-white">
                                    <div class="fw-bold text-dark text-sm">Chất Lượng Cao</div>
                                    <div class="text-muted text-xs">Đạt chuẩn VietGAP</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-white bg-opacity-95 shadow-md border border-white">
                                    <div class="fw-bold text-dark text-sm">Uy Tín Hàng Đầu</div>
                                    <div class="text-muted text-xs">Tin cậy 100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: 3 Feature Highlight Cards with Icon Boxes -->
            <div class="col-lg-7">
                <span class="hero-pill-badge text-success border-success-subtle bg-success-subtle mb-3">
                    Tại sao chọn EcoFarm?
                </span>
                <h2 class="display-6 fw-extrabold text-dark mb-4" style="font-weight: 900; color: #1b4317 !important; font-size: 2.1rem;">
                    Điểm Đến Tin Cậy Cho Mọi Nhà Vườn Mekong
                </h2>

                <div class="d-flex flex-column gap-3.5">
                    
                    <!-- Feature Box 1 -->
                    <div class="eco-feature-box d-flex align-items-start gap-4">
                        <div class="eco-icon-container">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1.5" style="font-size: 1.1rem; color: #1b4317 !important;">Giá Cả Cạnh Tranh & Ưu Đãi Đại Lý</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Sản phẩm nhập trực tiếp từ các nhà máy sản xuất (Bayer, Syngenta, Đầu Trâu), tối ưu chi phí gieo trồng và bảo vệ quyền lợi tối đa cho bà con nông dân.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Box 2 -->
                    <div class="eco-feature-box d-flex align-items-start gap-4">
                        <div class="eco-icon-container">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1.5" style="font-size: 1.1rem; color: #1b4317 !important;">Sản Phẩm Chính Hãng 100%</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Đầy đủ mã QR quét kiểm tra nguồn gốc xuất xứ, tem chống hàng giả hàng nhái. Cam kết bồi hoàn 200% nếu phát hiện sản phẩm không đạt chuẩn.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Box 3 -->
                    <div class="eco-feature-box d-flex align-items-start gap-4">
                        <div class="eco-icon-container">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1.5" style="font-size: 1.1rem; color: #1b4317 !important;">Đội Ngũ Kỹ Sư Nông Nghiệp Đồng Hành 24/7</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Đội ngũ kỹ sư giàu kinh nghiệm thực tế sẵn sàng thăm vườn, chẩn đoán bệnh cây và lập phác đồ điều trị tận tâm cho từng vụ mùa.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
