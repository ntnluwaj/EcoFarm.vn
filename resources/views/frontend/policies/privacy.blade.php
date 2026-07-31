@extends('frontend.layouts.master')

@section('title', 'Chính Sách Bảo Mật - EcoFarm')

@section('content')
<div class="container py-4" style="font-family: 'Plus Jakarta Sans', sans-serif; min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Chính sách bảo mật</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                <h1 class="fw-bold text-success mb-4" style="font-size: 28px;">Chính Sách Bảo Mật Thông Tin</h1>
                
                <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
                    EcoFarm hiểu rằng sự tin tưởng và bảo mật thông tin cá nhân là vô cùng quan trọng đối với bà con nông dân và các hợp tác xã. Chúng tôi cam kết bảo vệ tuyệt đối dữ liệu cá nhân theo các điều khoản quy định dưới đây.
                </p>

                <hr class="my-4 border-light">

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-database text-success me-2"></i>1. Các thông tin thu thập</h3>
                <p class="text-secondary mb-2" style="font-size: 13.5px; line-height: 1.7;">
                    Khi đăng ký tài khoản, đặt hàng hoặc gửi yêu cầu tư vấn trên EcoFarm.vn, chúng tôi sẽ thu thập các thông tin sau:
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li><strong>Thông tin định danh:</strong> Họ và tên, số điện thoại liên hệ, địa chỉ email.</li>
                    <li><strong>Thông tin địa chỉ hành chính có cấu trúc:</strong> Tỉnh/Thành, Quận/Huyện, Xã/Phường, Số nhà/Tên đường và vị trí tọa độ ghim trên bản đồ (để giao nhận hàng hóa).</li>
                    <li><strong>Dữ liệu nghiệp vụ:</strong> Nội dung câu hỏi tư vấn kỹ thuật, nhật ký trò chuyện với trợ lý ảo AI EcoBot, thông tin hóa đơn doanh nghiệp (nếu có yêu cầu xuất hóa đơn điện tử).</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-bullseye text-success me-2"></i>2. Mục đích sử dụng thông tin</h3>
                <p class="text-secondary mb-2" style="font-size: 13.5px; line-height: 1.7;">
                    Mọi dữ liệu được thu thập chỉ phục vụ cho các hoạt động nghiệp vụ nội bộ của EcoFarm:
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Xử lý giao nhận đơn hàng vật tư nông nghiệp chính xác tới bờ ruộng hoặc kho bãi.</li>
                    <li>Gửi thông báo cập nhật tiến độ đơn hàng và tích điểm thưởng đổi quà.</li>
                    <li>Hỗ trợ kỹ sư nông học gọi điện tư vấn kỹ thuật và trợ lý ảo AI EcoBot tư vấn dịch sâu bệnh hại.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-lock text-success me-2"></i>3. Cam kết bảo mật dữ liệu</h3>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li><strong>Tuyệt đối không bán/chia sẻ:</strong> EcoFarm cam kết không cung cấp, mua bán hay chia sẻ thông tin cá nhân của bà con nông dân cho bất kỳ bên thứ ba nào khi chưa có sự đồng ý bằng văn bản.</li>
                    <li><strong>Mã hóa bảo mật:</strong> Mật khẩu tài khoản của bạn được mã hóa bằng thuật toán Bcrypt an toàn cao cấp trước khi lưu trữ trong cơ sở dữ liệu.</li>
                    <li><strong>An toàn thanh toán:</strong> Mọi thông tin chuyển khoản VietQR hoặc ví liên kết đều được thực hiện qua cổng thanh toán bảo mật tiêu chuẩn, không lưu giữ thông tin thẻ ngân hàng trên server của chúng tôi.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-user-shield text-success me-2"></i>4. Quyền lợi của khách hàng</h3>
                <p class="text-secondary mb-4" style="font-size: 13.5px; line-height: 1.7;">
                    Bà con có quyền truy cập trang Cá nhân để cập nhật lại thông tin địa chỉ, mật khẩu bất kỳ lúc nào. Nếu có nhu cầu xóa vĩnh viễn tài khoản hoặc ngưng nhận các bản tin hỗ trợ nông nghiệp, vui lòng liên hệ hotline <strong>0398 037 435</strong> để được phục vụ ngay.
                </p>

                <div class="p-3 bg-light rounded-3 border border-success border-opacity-25 mt-4">
                    <p class="text-muted small mb-0">Chính sách bảo mật này được áp dụng và cập nhật định kỳ nhằm tuân thủ quy định pháp luật hiện hành của Nước Cộng hòa Xã hội Chủ nghĩa Việt Nam.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
