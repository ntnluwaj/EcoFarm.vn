@extends('frontend.layouts.master')

@section('title', 'Điều Khoản Dịch Vụ - EcoFarm')

@section('content')
<div class="container py-4" style="font-family: 'Plus Jakarta Sans', sans-serif; min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Điều khoản dịch vụ</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                <h1 class="fw-bold text-success mb-4" style="font-size: 28px;">Điều Khoản Dịch Vụ</h1>
                
                <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
                    Chào mừng bạn đến với Cổng thông tin & Cung ứng vật tư nông nghiệp trực tuyến EcoFarm.vn. Bằng việc truy cập, đăng ký tài khoản hoặc sử dụng bất kỳ dịch vụ nào của chúng tôi, bạn đồng ý tuân thủ các điều khoản cam kết dưới đây.
                </p>

                <hr class="my-4 border-light">

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-user-check text-success me-2"></i>1. Quyền và nghĩa vụ tài khoản</h3>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Người dùng phải cung cấp thông tin họ tên, số điện thoại và địa chỉ giao hàng chính xác khi đăng ký tài khoản hoặc thanh toán đơn hàng.</li>
                    <li>Bạn chịu trách nhiệm tự bảo mật mật khẩu cá nhân và thông báo ngay cho ban quản trị EcoFarm nếu phát hiện có truy cập trái phép.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-flask-vial text-success me-2"></i>2. Sử dụng sản phẩm vật tư an toàn</h3>
                <p class="text-secondary mb-2" style="font-size: 13.5px; line-height: 1.7;">
                    Đối với các mặt hàng thuộc nhóm **Thuốc bảo vệ thực vật**:
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Bà con nông dân cam kết đọc kỹ hướng dẫn sử dụng và liều lượng khuyến cáo in trên bao bì hoặc cẩm nang nông học của EcoFarm trước khi phun xịt.</li>
                    <li>Tuyệt đối tuân thủ thời gian cách ly (PHI) quy định cho từng loại thuốc để đảm bảo an toàn vệ sinh thực phẩm cho nông sản thu hoạch.</li>
                    <li>EcoFarm từ chối trách nhiệm đối với các thiệt hại về cây trồng hoặc sức khỏe nếu người dùng sử dụng sản phẩm sai quy cách, tự ý tăng liều lượng mà không có sự tư vấn trực tiếp từ kỹ sư nông nghiệp của chúng tôi.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-cash-register text-success me-2"></i>3. Giá cả và thanh toán</h3>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Giá niêm yết trên website là giá bán lẻ đã bao gồm thuế tiêu chuẩn quy định theo Luật thuế Vật tư nông nghiệp hiện hành (Miễn thuế VAT đối với thuốc BVTV và phân bón bón lót đầu vụ theo quy định pháp luật).</li>
                    <li>Khách hàng có thể lựa chọn thanh toán khi nhận hàng (COD) hoặc chuyển khoản ngân hàng qua VietQR tiện lợi.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-circle-exclamation text-success me-2"></i>4. Giới hạn trách nhiệm</h3>
                <p class="text-secondary mb-4" style="font-size: 13.5px; line-height: 1.7;">
                    Hệ thống tư vấn tự động AI EcoBot hoạt động dựa trên cơ sở dữ liệu nông học tổng hợp và mô hình ngôn ngữ lớn nhằm mục đích tham khảo kỹ thuật nhanh. Bà con nên kết hợp với tư vấn thực tế của kỹ sư nông nghiệp tại khu vực trước khi đưa ra quyết định canh tác quy mô lớn.
                </p>

                <div class="p-3 bg-light rounded-3 border border-success border-opacity-25 mt-4">
                    <p class="text-muted small mb-0">Điều khoản này có hiệu lực từ ngày 01/01/2026. Mọi tranh chấp phát sinh sẽ được giải quyết dựa trên thương lượng hợp tác và tuân thủ pháp luật Việt Nam.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
