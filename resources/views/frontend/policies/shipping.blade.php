@extends('frontend.layouts.master')

@section('title', 'Chính Sách Giao Hàng - EcoFarm')

@section('content')
<div class="container py-4" style="font-family: 'Plus Jakarta Sans', sans-serif; min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Chính sách giao hàng</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                <h1 class="fw-bold text-success mb-4" style="font-size: 28px;">Chính Sách Vận Chuyển & Giao Nhận</h1>
                
                <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
                    EcoFarm cam kết mang đến giải pháp phân phối vật tư nông nghiệp (phân bón, thuốc bảo vệ thực vật) nhanh chóng, an toàn và tối ưu chi phí nhất cho bà con nông dân và các hợp tác xã tại Việt Nam, đặc biệt hỗ trợ tối đa khu vực Đồng bằng sông Cửu Long.
                </p>

                <hr class="my-4 border-light">

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-truck text-success me-2"></i>1. Các phương thức vận chuyển</h3>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li><strong>Đội xe vận tải EcoFarm (Vận chuyển số lượng lớn):</strong> Áp dụng cho các đơn hàng cồng kềnh (từ 500kg phân bón hoặc 50 chai thuốc trở lên) tại khu vực miền Tây. Xe tải chuyên dụng của chúng tôi sẽ giao thẳng tới tận bờ ruộng hoặc kho bãi của hợp tác xã.</li>
                    <li><strong>Giao hàng nhanh qua đối tác liên kết (GHN, Viettel Post):</strong> Áp dụng cho các đơn hàng nhỏ, lẻ đóng gói tiêu chuẩn. Hỗ trợ tra cứu hành trình trực tiếp thông qua hệ thống của EcoFarm.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-clock text-success me-2"></i>2. Thời gian giao hàng dự kiến</h3>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle text-center small text-secondary">
                        <thead class="table-light text-dark fw-bold">
                            <tr>
                                <th>Khu vực giao hàng</th>
                                <th>Phương thức giao</th>
                                <th>Thời gian dự kiến</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nội thành Cần Thơ</td>
                                <td>Giao nhanh trong ngày</td>
                                <td>4 - 8 giờ làm việc</td>
                            </tr>
                            <tr>
                                <td>Các tỉnh miền Tây (ĐBSCL)</td>
                                <td>Đội xe EcoFarm / Đối tác</td>
                                <td>1 - 2 ngày làm việc</td>
                            </tr>
                            <tr>
                                <td>Khu vực miền Đông & Tây Nguyên</td>
                                <td>Đối tác vận chuyển</td>
                                <td>2 - 4 ngày làm việc</td>
                            </tr>
                            <tr>
                                <td>Khu vực miền Bắc & miền Trung</td>
                                <td>Đối tác chuyển phát</td>
                                <td>3 - 5 ngày làm việc</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-hand-holding-dollar text-success me-2"></i>3. Biểu phí vận chuyển & Hỗ trợ Hợp tác xã</h3>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li><strong>Miễn phí vận chuyển:</strong> Áp dụng cho tất cả các đơn hàng có giá trị từ <strong>5.000.000đ</strong> trở lên hoặc các hợp tác xã liên kết chính thức trong chương trình khuyến nông của tỉnh.</li>
                    <li><strong>Phí giao hàng thông thường:</strong> Được tính tự động dựa trên khoảng cách địa lý và khối lượng đơn hàng từ API của đối tác giao vận GHN tại trang Thanh toán.</li>
                </ul>

                <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 18px;"><i class="fa-solid fa-shield-halved text-success me-2"></i>4. Quy trình đồng kiểm và nhận hàng</h3>
                <p class="text-secondary mb-4" style="font-size: 13.5px; line-height: 1.7;">
                    Khi nhận vật tư từ nhân viên giao hàng hoặc đội xe của EcoFarm, bà con nông dân có quyền và nghĩa vụ đồng kiểm chất lượng sản phẩm trước khi ký nhận:
                </p>
                <ul class="text-secondary ps-4 mb-4" style="font-size: 13.5px; line-height: 1.8;">
                    <li>Kiểm tra tính nguyên vẹn của bao bì, tem nhãn của nhà sản xuất (Syngenta, Bayer, Phú Mỹ,...).</li>
                    <li>Đối chiếu số lượng, thể tích thực và chủng loại sản phẩm so với hóa đơn xuất kho đính kèm.</li>
                    <li>Nếu phát hiện bao bì móp méo, rò rỉ hóa chất hoặc sai lệch chủng loại, vui lòng từ chối nhận hàng và gọi ngay hotline chăm sóc khách hàng <strong>0398 037 435</strong> để được đổi trả khẩn cấp.</li>
                </ul>

                <div class="p-3 bg-light rounded-3 border border-success border-opacity-25 mt-4">
                    <h5 class="fw-bold text-success mb-2" style="font-size: 14.5px;"><i class="fa-solid fa-wheat-awn me-2"></i>Cam kết đồng hành cùng nhà nông</h5>
                    <p class="text-muted small mb-0">Hệ thống tổng đài và kỹ sư nông học hỗ trợ 24/7. Hotline hỗ trợ khẩn cấp: <strong>0398 037 435</strong> (Miễn phí cước cuộc gọi).</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
