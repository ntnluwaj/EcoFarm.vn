@extends('frontend.layouts.master')

@section('title', 'Giới Thiệu Về EcoFarm - Đồng Hành Cùng Nhà Vườn')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Giới thiệu công ty</li>
        </ol>
    </nav>

    <!-- Upgraded Hero Section -->
    <div class="p-5 text-white rounded-4 shadow-sm mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, rgba(27, 94, 32, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%), url('/storage/banners/banner_canhtac.png') no-repeat center center; background-size: cover; min-height: 350px; display: flex; align-items: center;">
        <!-- Organic wave divider at bottom -->
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; transform: rotate(180deg); z-index: 2;">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 35px;">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C120.55,43.25,237,51.62,321.39,56.44Z" style="fill: #f8f9fa; opacity: 1;"></path>
            </svg>
        </div>
        
        <div class="row align-items-center py-3 w-100 z-3 position-relative">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark fw-bold mb-3 px-3 py-2 text-uppercase tracking-wider shadow-sm"><i class="fa-solid fa-circle-check me-1"></i>Chào mừng bạn đến với EcoFarm</span>
                <h1 class="display-4 fw-bold mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Nâng Tầm Nông Nghiệp Việt</h1>
                <p class="lead text-white-50 mb-0" style="text-shadow: 0 1px 5px rgba(0,0,0,0.25); max-width: 650px;">Chúng tôi tự hào là đơn vị tiên phong cung cấp giải pháp số và vật tư nông nghiệp chính hãng chất lượng cao, đồng hành bền vững cùng nhà nông Việt Nam.</p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <div class="p-4 bg-white bg-opacity-10 rounded-circle d-inline-block border border-white border-opacity-25 animate-float-leaf" style="backdrop-filter: blur(8px);">
                    <i class="fa-solid fa-leaf text-warning" style="font-size: 80px; filter: drop-shadow(0 0 15px rgba(255,193,7,0.5));"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Philosophy Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white hover-card-about transition-all">
                <div class="p-3 bg-success-subtle text-success rounded-3 d-inline-block mb-3"><i class="fa-solid fa-eye fs-3"></i></div>
                <h5 class="fw-bold text-dark mb-2">Tầm Nhìn</h5>
                <p class="text-muted small mb-0">Trở thành hệ thống phân phối vật tư nông nghiệp số một tại khu vực miền Tây, mang lại các sản phẩm hữu cơ và thuốc BVTV sinh học an toàn, thân thiện với môi trường.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white hover-card-about transition-all">
                <div class="p-3 bg-success-subtle text-success rounded-3 d-inline-block mb-3"><i class="fa-solid fa-bullseye fs-3"></i></div>
                <h5 class="fw-bold text-dark mb-2">Sứ Mệnh</h5>
                <p class="text-muted small mb-0">Đồng hành cùng nhà vườn trong việc tối ưu hóa năng suất cây trồng, bảo vệ thổ nhưỡng tự nhiên, góp phần nâng cao giá trị thương mại cho nông sản Việt đạt chuẩn quốc tế.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white hover-card-about transition-all">
                <div class="p-3 bg-success-subtle text-success rounded-3 d-inline-block mb-3"><i class="fa-solid fa-hand-holding-heart fs-3"></i></div>
                <h5 class="fw-bold text-dark mb-2">Giá Trị Cốt Lõi</h5>
                <p class="text-muted small mb-0">Đặt chữ **Tín** và chất lượng lên hàng đầu. Đội ngũ chuyên gia sẵn sàng tư vấn kỹ thuật miễn phí, dịch vụ giao vận hỏa tốc, thanh toán linh hoạt, minh bạch.</p>
            </div>
        </div>
    </div>

    <!-- Detailed Introduction -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
        <div class="row g-0">
            <div class="col-lg-6 p-5 d-flex flex-column justify-content-center">
                <h3 class="fw-bold text-success mb-3">Câu Chuyện Của Chúng Tôi</h3>
                <p class="text-dark mb-3" style="line-height: 1.8;">
                    Khởi đầu từ khát vọng giải quyết các khó khăn trong chuỗi cung ứng vật tư của nhà vườn miền Tây, <strong>EcoFarm</strong> được thành lập nhằm mang đến một nền tảng bán lẻ vật tư nông nghiệp chính hãng trực quan và uy tín nhất.
                </p>
                <p class="text-dark mb-4" style="line-height: 1.8;">
                    Chúng tôi liên kết trực tiếp với các tập đoàn phân bón hàng đầu (như Bình Điền, Đầu Trâu) và các nhà sản xuất thuốc bảo vệ thực vật chính ngạch để mang lại mức giá bán lẻ cạnh tranh nhất, loại bỏ hoàn toàn rủi ro hàng giả hàng nhái gây hại mùa màng của bà con.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <h4 class="fw-bold text-dark mb-0">100%</h4>
                        <span class="text-muted text-xs">Sản phẩm chính hãng</span>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold text-dark mb-0">5.000+</h4>
                        <span class="text-muted text-xs">Nhà vườn tin cậy</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 bg-light text-center p-5 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="min-height: 300px; background: linear-gradient(135deg, #f1f8e9 0%, #dcedc8 100%);">
                <div class="z-3">
                    <i class="fa-solid fa-tractor text-success mb-3 animate-tractor" style="font-size: 80px;"></i>
                    <h4 class="fw-bold text-success mb-1">EcoFarm Cần Thơ</h4>
                    <p class="text-muted small">Cung ứng bền vững cho vùng Đồng bằng sông Cửu Long</p>
                </div>
                <i class="fa-solid fa-wheat-awn text-success opacity-10 position-absolute" style="font-size: 200px; right: -50px; bottom: -50px;"></i>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="card border-0 shadow-sm p-5 rounded-4 text-center bg-white">
        <div class="py-3">
            <h4 class="fw-bold text-dark mb-2">Cần Tư Vấn Kỹ Thuật Gieo Trồng?</h4>
            <p class="text-muted small mb-4">Các kỹ sư nông nghiệp giàu kinh nghiệm của EcoFarm luôn sẵn sàng hỗ trợ giải đáp mọi thắc mắc của bạn.</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="tel:1900888999" class="btn btn-success fw-bold px-4 py-2.5 rounded-3 d-inline-flex align-items-center gap-2" style="background-color: #2e7d32; border: none;">
                    <i class="fa-solid fa-phone"></i> Gọi ngay: 1900 888 999
                </a>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-success fw-bold px-4 py-2.5 rounded-3 d-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-book-open"></i> Xem cẩm nang kỹ thuật
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card-about:hover {
        transform: translateY(-8px);
        border-color: rgba(46, 125, 50, 0.18) !important;
        box-shadow: 0 15px 30px rgba(46, 125, 50, 0.15) !important;
    }
    .text-xs {
        font-size: 13px;
    }
    .animate-tractor {
        animation: floatTractor 4s ease-in-out infinite;
    }
    @keyframes floatTractor {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(-2deg); }
    }
    .animate-float-leaf {
        animation: floatLeaf 5s ease-in-out infinite;
    }
    @keyframes floatLeaf {
        0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
        50% { transform: translateY(-15px) rotate(8deg) scale(1.03); }
    }
</style>
@endsection
