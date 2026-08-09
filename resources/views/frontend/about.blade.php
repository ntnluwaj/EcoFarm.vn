@extends('frontend.layouts.master')

@section('title', 'Giới Thiệu Về EcoFarm - Hệ Thống Vật Tư Nông Nghiệp Hàng Đầu')

@section('content')

<!-- 🌟 1. HERO HEADER BANNER (GREEN LUSH GRADIENT OVERLAY LIKE MOCKUP) -->
<div class="position-relative overflow-hidden text-white text-center py-5" style="background: linear-gradient(135deg, rgba(27, 94, 32, 0.92) 0%, rgba(46, 125, 50, 0.88) 100%), url('{{ asset('images/ecofarm_green_field.jpg') }}') no-repeat center center; background-size: cover; min-height: 280px; display: flex; align-items: center; justify-content: center;">
    <div class="container py-4 z-2 position-relative">
        <h1 class="display-4 fw-black mb-2 text-uppercase tracking-tight" style="font-weight: 900; text-shadow: 0 3px 12px rgba(0,0,0,0.4);">Về Chúng Tôi</h1>
        <p class="lead max-w-2xl mx-auto text-light opacity-90 fw-medium mb-3" style="max-width: 680px; font-size: 1.1rem;">
            Đồng hành bền vững cùng bà con nông dân Việt Nam với giải pháp vật tư nông nghiệp chính hãng, chất lượng cao & tư vấn kỹ thuật tận tâm 24/7.
        </p>
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-20 text-white text-sm font-semibold backdrop-blur-sm border border-white border-opacity-25 shadow-sm">
            <a href="{{ route('home') }}" class="text-white text-decoration-none hover-opacity">Trang chủ</a>
            <span class="opacity-60">&gt;&gt;</span>
            <span class="text-warning fw-bold">Giới thiệu công ty</span>
        </div>
    </div>
</div>

<!-- 🌟 2. SECTION 1: INTERACTIVE STORY & STATS GRID (TOP CONTENT SECTION LIKE MOCKUP) -->
<div class="bg-white py-5 border-bottom">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            
            <!-- Left Column: Story & 4 Scorecard Stats -->
            <div class="col-lg-5">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success-subtle text-success text-xs font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-leaf text-success"></i> Về EcoFarm Mekong
                </div>
                <h2 class="display-6 fw-extrabold text-dark mb-3 tracking-tight" style="font-weight: 800; line-height: 1.25;">
                    Hệ Thống Phân Phối Vật Tư Nông Nghiệp Hàng Đầu Miền Tây
                </h2>
                <p class="text-secondary leading-relaxed mb-4" style="font-size: 14.5px; line-height: 1.75;">
                    Khởi đầu từ khát vọng giải quyết nỗi trăn trở về chất lượng vật tư của bà con Đồng bằng sông Cửu Long, <strong>EcoFarm</strong> tự hào là đối tác chiến lược trực tiếp của các tập đoàn hàng đầu (Bayer, Syngenta, Đầu Trâu, Nhật Bản). Chúng tôi cam kết 100% sản phẩm chính ngạch, an toàn thổ nhưỡng và bảo vệ năng suất tối đa.
                </p>

                <!-- 4 Scorecard Stat Cards Grid (2x2) -->
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3.5 rounded-4 bg-light border border-slate-100 hover-lift transition-all">
                            <div class="display-6 fw-black text-success tracking-tight mb-1" style="font-weight: 900; font-size: 2rem;">10.000+</div>
                            <div class="text-muted text-xs font-bold uppercase">Nhà vườn tin dùng</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3.5 rounded-4 bg-light border border-slate-100 hover-lift transition-all">
                            <div class="display-6 fw-black text-success tracking-tight mb-1" style="font-weight: 900; font-size: 2rem;">94%</div>
                            <div class="text-muted text-xs font-bold uppercase">Tỷ lệ hài lòng</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3.5 rounded-4 bg-light border border-slate-100 hover-lift transition-all">
                            <div class="display-6 fw-black text-success tracking-tight mb-1" style="font-weight: 900; font-size: 2rem;">Top 100</div>
                            <div class="text-muted text-xs font-bold uppercase">Thương hiệu uy tín</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3.5 rounded-4 bg-light border border-slate-100 hover-lift transition-all">
                            <div class="display-6 fw-black text-success tracking-tight mb-1" style="font-weight: 900; font-size: 2rem;">15+</div>
                            <div class="text-muted text-xs font-bold uppercase">Năm đồng hành</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('products.index') }}" class="btn btn-success btn-lg rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #2e7d32; border: none;">
                    <span>Khám phá sản phẩm</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Middle Column: Overlapping Collage Images with Floating Badge -->
            <div class="col-lg-4 text-center position-relative">
                <div class="position-relative d-inline-block w-100 max-w-md mx-auto">
                    <!-- Image 1 Top Offset -->
                    <img src="{{ asset('images/ecofarm_green_field.jpg') }}" alt="Mùa màng bội thu" class="img-fluid rounded-4 shadow-lg mb-3 object-cover w-100" style="height: 200px; border: 4px solid #ffffff;">
                    
                    <!-- Image 2 Main Center Offset -->
                    <img src="{{ asset('images/ecofarm_engineer.jpg') }}" alt="Kỹ sư tư vấn" class="img-fluid rounded-4 shadow-lg mb-3 object-cover w-100" style="height: 190px; border: 4px solid #ffffff; margin-top: -25px; position: relative; z-index: 2;">
                    
                    <!-- Image 3 Bottom Offset -->
                    <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư EcoFarm" class="img-fluid rounded-4 shadow-lg object-cover w-100" style="height: 170px; border: 4px solid #ffffff; margin-top: -25px; position: relative; z-index: 1;">

                    <!-- Floating Green Badge -->
                    <div class="position-absolute top-50 start-100 translate-middle-y d-none d-md-block z-3" style="margin-left: -60px;">
                        <div class="p-3 rounded-4 text-white shadow-xl backdrop-blur-md text-start" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%); border: 2px solid rgba(255,255,255,0.4); width: 170px;">
                            <div class="p-2 bg-white bg-opacity-20 rounded-circle d-inline-block mb-2">
                                <i class="fa-solid fa-seedling text-warning fs-4"></i>
                            </div>
                            <div class="fw-extrabold text-sm mb-1" style="font-weight: 800;">Gắn Kết Cùng Nhà Nông</div>
                            <div class="text-xs opacity-90">Bền vững theo thời gian</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Mission Points -->
            <div class="col-lg-3">
                <h4 class="fw-extrabold text-dark mb-3" style="font-weight: 800; font-size: 1.3rem;">
                    Nông Nghiệp Bền Vững - Nâng Tầm Nông Sản Việt
                </h4>
                <p class="text-secondary small leading-relaxed mb-4">
                    EcoFarm tiên phong ứng dụng công nghệ sinh học và vật tư cao cấp giúp bảo vệ sức khỏe cây trồng và thổ nhưỡng tự nhiên.
                </p>

                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-2.5">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-check text-success text-xs"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark text-sm">Phân bón & Thuốc chuẩn ISO/VietGAP</div>
                            <div class="text-muted text-xs">An toàn và rõ nguồn gốc xuất xứ</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-2.5">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-user-doctor text-success text-xs"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark text-sm">Tư vấn kỹ thuật tận vườn 24/7</div>
                            <div class="text-muted text-xs">Đội ngũ kỹ sư dày dạn kinh nghiệm</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-2.5">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-truck-fast text-success text-xs"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark text-sm">Giao hàng hỏa tốc bãi kho Mekong</div>
                            <div class="text-muted text-xs">Nhanh chóng tận tay nhà vườn</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-2.5">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-tags text-success text-xs"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark text-sm">Giá gốc từ nhà máy sản xuất</div>
                            <div class="text-muted text-xs">Tối ưu chi phí đầu tư mùa vụ</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top text-muted text-xs">
                    * Báo cáo khảo sát hơn 500 nhà vườn Mekong 2026.<br>
                    ** Bình chọn hệ thống đại lý vật tư uy tín.
                </div>
            </div>

        </div>
    </div>
</div>

<!-- 🌟 3. SECTION 2: FULL-WIDTH LUSH GREEN CALLOUT BANNER (MIDDLE BANNER LIKE MOCKUP) -->
<div class="position-relative overflow-hidden text-white text-center py-5" style="background: linear-gradient(135deg, rgba(27, 94, 32, 0.94) 0%, rgba(46, 125, 50, 0.9) 100%), url('{{ asset('images/ecofarm_green_field.jpg') }}') no-repeat center center; background-size: cover; min-height: 260px; display: flex; align-items: center; justify-content: center;">
    <div class="container py-4 z-2 position-relative">
        <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1.5 rounded-pill text-uppercase tracking-wider">Khám Phá EcoFarm</span>
        <h2 class="display-5 fw-extrabold mb-3 text-white tracking-tight" style="font-weight: 900; text-shadow: 0 3px 10px rgba(0,0,0,0.3);">
            Giải Pháp Nông Nghiệp Toàn Diện - Trúng Mùa Được Giá
        </h2>
        <p class="lead max-w-2xl mx-auto text-light opacity-90 mb-4" style="max-width: 720px; font-size: 1.15rem;">
            Liên kết trực tiếp chuỗi cung ứng vật tư nông nghiệp chính hãng, bảo vệ mùa màng hiệu quả và đem lại hiệu quả kinh tế vượt trội cho bà con.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-extrabold text-success shadow-lg hover-lift" style="color: #1b5e20 !important; font-weight: 800;">
            <i class="fa-solid fa-phone me-2"></i> Liên hệ tư vấn ngay
        </a>
    </div>
</div>

<!-- 🌟 4. SECTION 3: WHY CHOOSE ECOFARM / VALUE PROPOSITION (BOTTOM SECTION LIKE MOCKUP) -->
<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            
            <!-- Left Column: Collage Image with Floating Glass Cards -->
            <div class="col-lg-5">
                <div class="position-relative">
                    <img src="{{ asset('images/ecofarm_warehouse.jpg') }}" alt="Kho vật tư EcoFarm" class="img-fluid rounded-4 shadow-xl w-100 object-cover" style="height: 400px;">
                    
                    <div class="position-absolute bottom-0 start-0 p-4 w-100">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-white bg-opacity-90 backdrop-blur-md shadow-md border border-white">
                                    <div class="fw-bold text-dark text-sm">Chất Lượng Cao</div>
                                    <div class="text-muted text-xs">Đạt chuẩn VietGAP</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-white bg-opacity-90 backdrop-blur-md shadow-md border border-white">
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
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success-subtle text-success text-xs font-bold uppercase tracking-wider mb-3">
                    Tại sao chọn EcoFarm?
                </div>
                <h2 class="display-6 fw-extrabold text-dark mb-4 tracking-tight" style="font-weight: 800;">
                    Điểm Đến Tin Cậy Cho Mọi Nhà Vườn Mekong
                </h2>

                <div class="d-flex flex-column gap-3">
                    
                    <!-- Feature Box 1 -->
                    <div class="p-4 rounded-4 bg-white shadow-sm border border-slate-100 hover-lift transition-all d-flex align-items-start gap-4">
                        <div class="p-3 rounded-3 text-white shrink-0" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 16px rgba(46, 125, 50, 0.25);">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <div>
                            <h5 class="fw-extrabold text-dark mb-1.5" style="font-weight: 800;">Giá Cả Cạnh Tranh & Ưu Đãi Đại Lý</h5>
                            <p class="text-secondary small mb-0 leading-relaxed">
                                Sản phẩm nhập trực tiếp từ các nhà máy sản xuất (Bayer, Syngenta, Đầu Trâu), tối ưu chi phí gieo trồng và bảo vệ quyền lợi tối đa cho bà con nông dân.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Box 2 -->
                    <div class="p-4 rounded-4 bg-white shadow-sm border border-slate-100 hover-lift transition-all d-flex align-items-start gap-4">
                        <div class="p-3 rounded-3 text-white shrink-0" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 16px rgba(46, 125, 50, 0.25);">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h5 class="fw-extrabold text-dark mb-1.5" style="font-weight: 800;">Sản Phẩm Chính Hãng 100%</h5>
                            <p class="text-secondary small mb-0 leading-relaxed">
                                Đầy đủ mã QR quét kiểm tra nguồn gốc xuất xứ, tem chống hàng giả hàng nhái. Cam kết bồi hoàn 200% nếu phát hiện sản phẩm không đạt chuẩn.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Box 3 -->
                    <div class="p-4 rounded-4 bg-white shadow-sm border border-slate-100 hover-lift transition-all d-flex align-items-start gap-4">
                        <div class="p-3 rounded-3 text-white shrink-0" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 16px rgba(46, 125, 50, 0.25);">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <h5 class="fw-extrabold text-dark mb-1.5" style="font-weight: 800;">Đội Ngũ Kỹ Sư Nông Nghiệp Đồng Hành 24/7</h5>
                            <p class="text-secondary small mb-0 leading-relaxed">
                                Đội ngũ kỹ sư giàu kinh nghiệm thực tế sẵn sàng thăm vườn, chẩn đoán bệnh cây và lập phác đồ điều trị tận tâm cho từng vụ mùa.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.08) !important;
    }
    .hover-opacity:hover {
        opacity: 0.8;
    }
    .object-cover {
        object-fit: cover;
    }
</style>

@endsection
