@extends('frontend.layouts.master')

@section('title', 'Giới Thiệu Về EcoFarm - Hệ Thống Vật Tư Nông Nghiệp Hàng Đầu')

@section('content')

<!-- 🌟 PREMIUIM GOOGLE FONTS FOR EXECUTIVE TYPOGRAPHY -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .eco-about-wrapper {
        font-family: 'Plus Jakarta Sans', 'Be Vietnam Pro', system-ui, -apple-system, sans-serif;
        color: #1e293b;
    }

    .eco-heading-title {
        font-family: 'Plus Jakarta Sans', 'Be Vietnam Pro', sans-serif;
        font-weight: 900 !important;
        letter-spacing: -0.03em !important;
        line-height: 1.25 !important;
    }

    .eco-text-gradient {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .eco-stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
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
        background: linear-gradient(90deg, #1b5e20 0%, #2e7d32 60%, #f59e0b 100%);
    }

    .eco-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px -8px rgba(46, 125, 50, 0.16);
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
        border-color: #2e7d32;
        box-shadow: 0 16px 32px -6px rgba(46, 125, 50, 0.15);
    }

    .eco-icon-container {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 10px 20px -4px rgba(46, 125, 50, 0.35);
        flex-shrink: 0;
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.08) !important;
    }

    .object-cover {
        object-fit: cover;
    }
</style>

<div class="eco-about-wrapper">

    <!-- 🌟 1. HERO HEADER BANNER (EXECUTIVE LUXURY OVERLAY) -->
    <div class="position-relative overflow-hidden text-white text-center py-5" style="background: linear-gradient(135deg, rgba(27, 94, 32, 0.94) 0%, rgba(46, 125, 50, 0.9) 60%, rgba(245, 158, 11, 0.3) 100%), url('{{ asset('images/ecofarm_green_field.jpg') }}') no-repeat center center; background-size: cover; min-height: 290px; display: flex; align-items: center; justify-content: center;">
        <div class="container py-4 z-2 position-relative">
            <span class="badge bg-amber-400 bg-warning text-dark font-black mb-3 px-3.5 py-1.5 rounded-pill text-uppercase tracking-wider shadow-sm" style="font-weight: 800; font-size: 11px;">
                <i class="fa-solid fa-wheat-awn me-1 text-dark"></i> Thương Hiệu Vật Tư Nông Nghiệp EcoFarm
            </span>
            <h1 class="display-4 eco-heading-title mb-3 text-uppercase text-white" style="font-size: 2.75rem; text-shadow: 0 4px 16px rgba(0,0,0,0.45);">
                Về Chúng Tôi
            </h1>
            <p class="lead max-w-2xl mx-auto text-light opacity-95 fw-medium mb-4" style="max-width: 720px; font-size: 1.12rem; line-height: 1.7;">
                Đồng hành bền vững cùng bà con nông dân Việt Nam với giải pháp vật tư nông nghiệp chính hãng, chất lượng cao & tư vấn kỹ thuật tận tâm 24/7.
            </p>
            <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill bg-white bg-opacity-20 text-white text-sm font-bold backdrop-blur-md border border-white border-opacity-30 shadow-lg">
                <a href="{{ route('home') }}" class="text-white text-decoration-none hover-opacity">Trang chủ</a>
                <span class="text-amber-300 font-black">&gt;&gt;</span>
                <span class="text-warning font-black fw-bold">Giới thiệu công ty</span>
            </div>
        </div>
    </div>

    <!-- 🌟 2. SECTION 1: INTERACTIVE STORY & STATS GRID (EXECUTIVE 2-COLUMN LAYOUT) -->
    <div class="bg-white py-5 border-bottom">
        <div class="container py-4">
            <div class="row g-5 align-items-center">
                
                <!-- Left Column: Story & 4 Scorecard Stats -->
                <div class="col-lg-6">
                    <div class="d-inline-flex align-items-center gap-2 px-3.5 py-1.5 rounded-pill bg-success bg-opacity-10 text-success text-xs font-black uppercase tracking-wider mb-3 border border-success border-opacity-20">
                        <i class="fa-solid fa-leaf text-success"></i> Về EcoFarm Mekong
                    </div>
                    <h2 class="display-6 eco-heading-title text-slate-900 mb-3" style="font-size: 2.1rem;">
                        Hệ Thống Phân Phối Vật Tư Nông Nghiệp <span class="eco-text-gradient">Hàng Đầu Miền Tây</span>
                    </h2>
                    <p class="text-slate-600 leading-relaxed mb-4" style="font-size: 15px; line-height: 1.8;">
                        Khởi đầu từ khát vọng giải quyết nỗi trăn trở về chất lượng vật tư của bà con Đồng bằng sông Cửu Long, <strong>EcoFarm</strong> tự hào là đối tác chiến lược trực tiếp của các tập đoàn hàng đầu (Bayer, Syngenta, Đầu Trâu, Nhật Bản). Chúng tôi cam kết 100% sản phẩm chính ngạch, an toàn thổ nhưỡng và bảo vệ năng suất tối đa.
                    </p>

                    <!-- 4 Scorecard Stat Cards Grid (2x2) -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="eco-stat-card">
                                <div class="eco-heading-title text-success tracking-tight mb-1" style="font-size: 2.1rem; color: #2e7d32 !important;">10.000+</div>
                                <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Nhà vườn tin dùng</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="eco-stat-card">
                                <div class="eco-heading-title text-success tracking-tight mb-1" style="font-size: 2.1rem; color: #2e7d32 !important;">94%</div>
                                <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Tỷ lệ hài lòng</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="eco-stat-card">
                                <div class="eco-heading-title text-success tracking-tight mb-1" style="font-size: 2.1rem; color: #2e7d32 !important;">Top 100</div>
                                <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Thương hiệu uy tín</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="eco-stat-card">
                                <div class="eco-heading-title text-success tracking-tight mb-1" style="font-size: 2.1rem; color: #2e7d32 !important;">15+</div>
                                <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Năm đồng hành</div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('products.index') }}" class="btn btn-success btn-lg rounded-pill px-4 py-3 fw-bold shadow-md d-inline-flex align-items-center gap-2.5" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%); border: none; font-size: 14px;">
                        <span>Khám phá sản phẩm vật tư</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Right Column: Structured Image Gallery Collage & Key Value Points -->
                <div class="col-lg-6">
                    <!-- Main Feature Image with Floating Badge Safely INSIDE Container -->
                    <div class="position-relative mb-4">
                        <img src="{{ asset('images/ecofarm_engineer.jpg') }}" alt="Kỹ sư tư vấn nông nghiệp" class="img-fluid rounded-4 shadow-lg w-100 object-cover" style="height: 270px; border: 4px solid #ffffff; box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;">
                        
                        <!-- Floating Green Badge Safely Positioned INSIDE Image (Bottom-Right) -->
                        <div class="position-absolute bottom-0 end-0 m-3 z-3">
                            <div class="p-3 rounded-4 text-white shadow-xl backdrop-blur-md" style="background: linear-gradient(135deg, rgba(27,94,32,0.96) 0%, rgba(46,125,50,0.96) 100%); border: 1.5px solid rgba(255,255,255,0.4); max-width: 210px;">
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
                            <img src="{{ asset('images/ecofarm_green_field.jpg') }}" alt="Cánh đồng Mekong" class="img-fluid rounded-4 shadow-sm w-100 object-cover" style="height: 125px; border: 2px solid #ffffff;">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư" class="img-fluid rounded-4 shadow-sm w-100 object-cover" style="height: 125px; border: 2px solid #ffffff;">
                        </div>
                    </div>

                    <!-- Key Value Checklist Grid -->
                    <div class="row g-2.5 pt-2">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-slate-200">
                                <i class="fa-solid fa-circle-check text-success fs-6"></i>
                                <span class="fw-bold text-slate-800 text-xs">Vật tư chuẩn ISO/VietGAP</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-slate-200">
                                <i class="fa-solid fa-user-doctor text-success fs-6"></i>
                                <span class="fw-bold text-slate-800 text-xs">Kỹ sư hỗ trợ tận vườn 24/7</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-slate-200">
                                <i class="fa-solid fa-truck-fast text-success fs-6"></i>
                                <span class="fw-bold text-slate-800 text-xs">Giao hàng hỏa tốc Mekong</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2.5 p-3 rounded-3 bg-light border border-slate-200">
                                <i class="fa-solid fa-tags text-success fs-6"></i>
                                <span class="fw-bold text-slate-800 text-xs">Giá niêm yết trực tiếp nhà máy</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- 🌟 3. SECTION 2: FULL-WIDTH LUSH GREEN CALLOUT BANNER (EXECUTIVE WOW BANNER) -->
    <div class="position-relative overflow-hidden text-white text-center py-5" style="background: linear-gradient(135deg, rgba(27, 94, 32, 0.95) 0%, rgba(46, 125, 50, 0.92) 100%), url('{{ asset('images/ecofarm_green_field.jpg') }}') no-repeat center center; background-size: cover; min-height: 260px; display: flex; align-items: center; justify-content: center;">
        <div class="container py-4 z-2 position-relative">
            <span class="badge bg-amber-400 bg-warning text-dark font-black mb-2 px-3.5 py-1.5 rounded-pill text-uppercase tracking-wider shadow-sm" style="font-weight: 800; font-size: 11px;">
                <i class="fa-solid fa-star me-1"></i> Khám Phá EcoFarm
            </span>
            <h2 class="display-5 eco-heading-title mb-3 text-white" style="font-size: 2.35rem; text-shadow: 0 4px 12px rgba(0,0,0,0.35);">
                Giải Pháp Nông Nghiệp Toàn Diện - <span class="text-warning">Trúng Mùa Được Giá</span>
            </h2>
            <p class="lead max-w-2xl mx-auto text-light opacity-95 mb-4" style="max-width: 740px; font-size: 1.15rem; line-height: 1.7;">
                Liên kết trực tiếp chuỗi cung ứng vật tư nông nghiệp chính hãng, bảo vệ mùa màng hiệu quả và đem lại hiệu quả kinh tế vượt trội cho bà con.
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-extrabold shadow-lg hover-lift" style="color: #1b5e20 !important; font-weight: 800; font-size: 14px;">
                <i class="fa-solid fa-phone me-2"></i> Liên hệ tư vấn ngay
            </a>
        </div>
    </div>

    <!-- 🌟 4. SECTION 3: WHY CHOOSE ECOFARM / VALUE PROPOSITION (RICH GLASS CARDS) -->
    <div class="bg-slate-50 py-5" style="background-color: #f8fafc;">
        <div class="container py-4">
            <div class="row g-5 align-items-center">
                
                <!-- Left Column: Image with Floating Glass Badges -->
                <div class="col-lg-5">
                    <div class="position-relative">
                        <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư EcoFarm" class="img-fluid rounded-4 shadow-xl w-100 object-cover" style="height: 400px; border: 4px solid #ffffff;">
                        
                        <div class="position-absolute bottom-0 start-0 p-4 w-100">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white bg-opacity-95 backdrop-blur-md shadow-md border border-white">
                                        <div class="fw-bold text-slate-900 text-sm">Chất Lượng Cao</div>
                                        <div class="text-muted text-xs">Đạt chuẩn VietGAP</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white bg-opacity-95 backdrop-blur-md shadow-md border border-white">
                                        <div class="fw-bold text-slate-900 text-sm">Uy Tín Hàng Đầu</div>
                                        <div class="text-muted text-xs">Tin cậy 100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: 3 Feature Highlight Cards with Icon Boxes -->
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3.5 py-1.5 rounded-pill bg-success bg-opacity-10 text-success text-xs font-black uppercase tracking-wider mb-3 border border-success border-opacity-20">
                        Tại sao chọn EcoFarm?
                    </div>
                    <h2 class="display-6 eco-heading-title text-slate-900 mb-4" style="font-size: 2.1rem;">
                        Điểm Đến Tin Cậy Cho Mọi Nhà Vườn Mekong
                    </h2>

                    <div class="d-flex flex-column gap-3.5">
                        
                        <!-- Feature Box 1 -->
                        <div class="eco-feature-box d-flex align-items-start gap-4">
                            <div class="eco-icon-container">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                            <div>
                                <h5 class="eco-heading-title text-slate-900 mb-1.5" style="font-size: 1.1rem;">Giá Cả Cạnh Tranh & Ưu Đãi Đại Lý</h5>
                                <p class="text-slate-600 small mb-0 leading-relaxed" style="line-height: 1.7;">
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
                                <h5 class="eco-heading-title text-slate-900 mb-1.5" style="font-size: 1.1rem;">Sản Phẩm Chính Hãng 100%</h5>
                                <p class="text-slate-600 small mb-0 leading-relaxed" style="line-height: 1.7;">
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
                                <h5 class="eco-heading-title text-slate-900 mb-1.5" style="font-size: 1.1rem;">Đội Ngũ Kỹ Sư Nông Nghiệp Đồng Hành 24/7</h5>
                                <p class="text-slate-600 small mb-0 leading-relaxed" style="line-height: 1.7;">
                                    Đội ngũ kỹ sư giàu kinh nghiệm thực tế sẵn sàng thăm vườn, chẩn đoán bệnh cây và lập phác đồ điều trị tận tâm cho từng vụ mùa.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
