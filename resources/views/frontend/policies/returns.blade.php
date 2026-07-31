@extends('frontend.layouts.master')

@section('title', 'Chính Sách Đổi Trả - EcoFarm')

@section('content')
<div class="container py-4" style="font-family: 'Plus Jakarta Sans', sans-serif; min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Chính sách đổi trả</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                <h1 class="fw-bold text-success mb-4" style="font-size: 28px;">Chính Sách Đổi Trả Sản Phẩm</h1>
                
                <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
                    EcoFarm cam kết bảo vệ quyền lợi chính đáng của bà con nông dân và đối tác đại lý. Nếu có bất kỳ sự cố hay lỗi kỹ thuật nào phát sinh từ phía sản phẩm hoặc quá trình giao hàng, chúng tôi sẽ thực hiện đổi trả miễn phí và bồi hoàn đầy đủ.
                </p>

                <hr class="my-4 border-light">

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-calendar-check text-success me-2"></i>1. Thời hạn đổi trả</h3>
                <p class="text-secondary mb-4" style="font-size: 13.5px; line-height: 1.7;">
                    Bà con nông dân có quyền yêu cầu đổi mới hoặc trả lại sản phẩm trong vòng <strong>7 ngày</strong> kể từ ngày ký biên bản nhận hàng thành công.
                </p>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-clipboard-list text-success me-2"></i>2. Điều kiện áp dụng đổi trả</h3>
                <p class="text-secondary mb-2" style="font-size: 13.5px; line-height: 1.7;">
                    <strong>Các trường hợp được đổi trả miễn phí hoàn toàn:</strong>
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Sản phẩm bị lỗi đóng gói của nhà sản xuất (hở nắp chai, rách bao bì, vón cục bất thường đối với phân bón).</li>
                    <li>Sản phẩm bị quá hạn sử dụng (quá date) khi vừa nhận được hàng.</li>
                    <li>Giao sai chủng loại vật tư, sai quy cách đóng gói so với đơn hàng đã xác nhận trên hệ thống.</li>
                    <li>Bị đổ vỡ, hư hỏng trong quá trình vận chuyển của đội ngũ EcoFarm hoặc đối tác giao vận.</li>
                </ul>

                <p class="text-secondary mb-2" style="font-size: 13.5px; line-height: 1.7;">
                    <strong>Yêu cầu về tình trạng sản phẩm:</strong>
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Sản phẩm chưa qua sử dụng, chưa bóc tem nhãn hay niêm phong chai/bao bì.</li>
                    <li>Có kèm theo hóa đơn biên nhận mua hàng hoặc hiển thị lịch sử mua hàng trùng khớp trên hệ thống tài khoản EcoFarm.vn.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-arrows-rotate text-success me-2"></i>3. Quy trình thực hiện đổi trả</h3>
                <ol class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li><strong>Liên hệ yêu cầu:</strong> Gọi điện trực tiếp đến Hotline kỹ sư hỗ trợ <strong>0398 037 435</strong> để thông báo lý do đổi trả và cung cấp ảnh chụp tình trạng sản phẩm qua Zalo/Viber.</li>
                    <li><strong>Xác nhận thông tin:</strong> EcoFarm sẽ kiểm tra đối chiếu lịch sử đơn hàng và phản hồi giải quyết trong vòng 24 giờ.</li>
                    <li><strong>Thu hồi & Thay thế:</strong> Đội vận chuyển EcoFarm hoặc đối tác GHN sẽ đến thu hồi sản phẩm lỗi tại nhà và đồng thời bàn giao sản phẩm mới thay thế miễn phí.</li>
                </ol>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-money-bill-transfer text-success me-2"></i>4. Chính sách hoàn tiền</h3>
                <p class="text-secondary mb-4" style="font-size: 13.5px; line-height: 1.7;">
                    Trong trường hợp trả hàng và yêu cầu hoàn tiền, EcoFarm sẽ thực hiện chuyển khoản bồi hoàn giá trị đơn hàng lại vào tài khoản ngân hàng của khách hàng trong vòng <strong>3 ngày làm việc</strong> sau khi đã nhận lại hàng lỗi tại kho Cần Thơ.
                </p>

                <div class="p-3 bg-light rounded-3 border border-success border-opacity-25 mt-4">
                    <h5 class="fw-bold text-success mb-2" style="font-size: 14.5px;"><i class="fa-solid fa-circle-question me-2"></i>Bà con cần hỗ trợ nhanh?</h5>
                    <p class="text-muted small mb-0">Liên hệ Zalo kỹ sư phụ trách đổi trả hoặc gọi Hotline: <strong>0398 037 435</strong> (Hỗ trợ 24/7).</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
