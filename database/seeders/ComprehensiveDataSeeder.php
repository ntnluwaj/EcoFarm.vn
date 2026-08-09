<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Post;
use Illuminate\Support\Str;

class ComprehensiveDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Đảm bảo có danh mục & thương hiệu cơ bản
        $catThuoc = Category::firstOrCreate(
            ['slug' => 'thuoc-tru-sau-va-benh'],
            ['name' => 'Thuốc Trừ Sâu & Bệnh', 'parent_id' => null]
        );

        $catPhanBon = Category::firstOrCreate(
            ['slug' => 'phan-bon-huu-co-va-npk'],
            ['name' => 'Phân Bón Hữu Cơ & NPK', 'parent_id' => null]
        );

        $catHatGiong = Category::firstOrCreate(
            ['slug' => 'hat-giong-va-cay-giong'],
            ['name' => 'Hạt Giống & Cây Giống', 'parent_id' => null]
        );

        $catKichThich = Category::firstOrCreate(
            ['slug' => 'chat-kich-thich-sinh-truong'],
            ['name' => 'Chất Kích Thích Sinh Trưởng', 'parent_id' => null]
        );

        $brandSyngenta = Brand::firstOrCreate(
            ['slug' => 'syngenta-viet-nam'],
            ['name' => 'Syngenta Việt Nam', 'description' => 'Tập đoàn bảo vệ thực vật & hạt giống toàn cầu.']
        );

        $brandBinhDien = Brand::firstOrCreate(
            ['slug' => 'phan-bon-binh-dien'],
            ['name' => 'Phân bón Bình Điền', 'description' => 'Thương hiệu phân bón Đầu Trâu uy tín.']
        );

        $brandBayer = Brand::firstOrCreate(
            ['slug' => 'bayer-cropscience'],
            ['name' => 'Bayer CropScience', 'description' => 'Tập đoàn Bayer chuyên nông hóa.']
        );

        $brandLocTroi = Brand::firstOrCreate(
            ['slug' => 'tap-doan-loc-troi'],
            ['name' => 'Tập đoàn Lộc Trời', 'description' => 'Tập đoàn dịch vụ nông nghiệp hàng đầu Việt Nam.']
        );

        // =========================================================================
        // 🛍️ 10 SẢN PHẨM VẬT TƯ NÔNG NGHIỆP ĐẦY ĐỦ THÔNG TIN DỮ LIỆU
        // =========================================================================
        $productsData = [
            [
                'name' => 'Thuốc trừ bệnh Tilt Super 300EC Syngenta',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandSyngenta->id,
                'price' => 240000,
                'unit' => 'Chai',
                'packaging' => 'Chai 250ml chính hãng',
                'stock' => 350,
                'description' => '<p><strong>Tilt Super 300EC</strong> là thuốc trừ bệnh nội hấp cực mạnh, thấm sâu nhanh và lưu dẫn 2 chiều bảo vệ cây trồng.</p><p>Đặc trị hiệu quả cao các bệnh lem lép hạt, vàng lá chín sớm, đốm vằn trên lúa và rỉ sắt trên cà phê, cây ăn trái.</p>',
                'usage_guide' => '<ul><li><strong>Lúa:</strong> Pha 10-15ml cho bình 25 Lít nước. Phun lót giai đoạn lúa trổ xẹt và trổ đều.</li><li><strong>Cà phê & Cây ăn trái:</strong> Pha 200ml cho phuy 200 Lít nước, phun đẫm tán lá khi bệnh mới xuất hiện.</li><li><strong>PHI:</strong> Ngưng phun trước thu hoạch 14 ngày.</li></ul>',
                'images' => ['products/tilt_super.jpg'],
                'variants' => [
                    ['capacity' => 'Chai 100ml', 'price' => 105000, 'stock' => 150],
                    ['capacity' => 'Chai 250ml', 'price' => 240000, 'stock' => 200],
                ]
            ],
            [
                'name' => 'Thuốc trừ sâu Voliam Targo 063SC Syngenta',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandSyngenta->id,
                'price' => 185000,
                'unit' => 'Chai',
                'packaging' => 'Chai 100ml',
                'stock' => 280,
                'description' => '<p><strong>Voliam Targo 063SC</strong> kết hợp 2 hoạt chất tiên tiến Chlorantraniliprole và Abamectin giúp diệt sạch cả sâu đục thân, sâu cuốn lá và nhện đỏ di chuyển.</p>',
                'usage_guide' => '<ul><li><strong>Đối tượng phòng trừ:</strong> Sâu cuốn lá lúa, nhện đỏ hại cam sành, sâu vẽ bùa hại bưởi.</li><li><strong>Liều lượng:</strong> Pha 15ml cho bình 25 Lít nước. Phun ướt đều 2 mặt lá.</li></ul>',
                'images' => ['products/voliam_targo.jpg'],
                'variants' => [
                    ['capacity' => 'Chai 100ml', 'price' => 185000, 'stock' => 280],
                ]
            ],
            [
                'name' => 'Phân bón NPK Đầu Trâu 16-16-8+TE Đẻ Nhánh Khỏe',
                'category_id' => $catPhanBon->id,
                'brand_id' => $brandBinhDien->id,
                'price' => 790000,
                'unit' => 'Bao',
                'packaging' => 'Bao 50kg cao cấp',
                'stock' => 600,
                'description' => '<p><strong>Phân bón NPK Đầu Trâu 16-16-8+TE</strong> cung cấp đạm, lân, kali cân đối bổ sung vi lượng TE giúp cây đẻ nhánh mạnh, ra rễ khỏe, tăng sức đề kháng mùa ngập mặn.</p>',
                'usage_guide' => '<ul><li><strong>Bón thúc đợt 1 & 2:</strong> Liều lượng từ 120 - 180kg/ha cho lúa và hoa màu.</li><li><strong>Bảo quản:</strong> Để nơi khô ráo, thoáng mát, đậy kín miệng bao sau khi dùng.</li></ul>',
                'images' => ['products/npk_dautrau_16168.jpg'],
                'variants' => [
                    ['capacity' => 'Bao 25kg', 'price' => 410000, 'stock' => 200],
                    ['capacity' => 'Bao 50kg', 'price' => 790000, 'stock' => 400],
                ]
            ],
            [
                'name' => 'Phân bón lá Humic Mỹ Kích Rễ Bung Đọt',
                'category_id' => $catPhanBon->id,
                'brand_id' => $brandLocTroi->id,
                'price' => 165000,
                'unit' => 'Gói',
                'packaging' => 'Gói 1kg đậm đặc',
                'stock' => 450,
                'description' => '<p><strong>Humic Mỹ Kích Rễ</strong> chứa Axit Humic 80% hòa tan hoàn toàn, giúp giải độc hạ phèn, tái tạo bộ rễ lúa và cây ăn trái suy kiệt sau thu hoạch.</p>',
                'usage_guide' => '<ul><li><strong>Pha tưới gốc:</strong> Pha 1kg Humic cho 800 - 1000 Lít nước tưới quanh gốc cây ăn trái.</li><li><strong>Trộn phân bón:</strong> Trộn 1kg Humic với 50kg NPK rải đều mặt ruộng.</li></ul>',
                'images' => ['products/humic_my.jpg'],
                'variants' => [
                    ['capacity' => 'Gói 1kg', 'price' => 165000, 'stock' => 450],
                ]
            ],
            [
                'name' => 'Thuốc điều hòa sinh trưởng Atonik 1.8SL',
                'category_id' => $catKichThich->id,
                'brand_id' => $brandLocTroi->id,
                'price' => 110000,
                'unit' => 'Hộp',
                'packaging' => 'Hộp 10 gói x 10ml',
                'stock' => 800,
                'description' => '<p><strong>Atonik 1.8SL</strong> là chất kích thích sinh trưởng cây trồng hàng đầu Nhật Bản, gia tăng khả năng nảy mầm, Kích rễ và giải độc hữu cơ cho cây.</p>',
                'usage_guide' => '<ul><li><strong>Ngâm hạt giống:</strong> Pha 10ml Atonik cho 20 Lít nước ngâm hạt giống trước khi gieo sạ.</li><li><strong>Phun lá:</strong> Pha 10ml cho bình 25 Lít nước phun định kỳ 10-15 ngày/lần.</li></ul>',
                'images' => ['products/atonik_18sl.jpg'],
                'variants' => [
                    ['capacity' => 'Hộp 10 gói', 'price' => 110000, 'stock' => 800],
                ]
            ],
            [
                'name' => 'Thuốc trừ cỏ Nominee 10SC Lộc Trời',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandLocTroi->id,
                'price' => 135000,
                'unit' => 'Chai',
                'packaging' => 'Chai 100ml',
                'stock' => 300,
                'description' => '<p><strong>Nominee 10SC</strong> là thuốc trừ cỏ hậu nảy mầm chọn lọc cực kỳ an toàn cho lúa. Đặc trị cỏ lồng vực, cỏ đuôi phụng và các loại cỏ chác lồng.</p>',
                'usage_guide' => '<ul><li><strong>Thời điểm phun:</strong> Phun từ 8 - 14 ngày sau khi sạ lúa (khi cỏ có từ 2-4 lá).</li><li><strong>Liều lượng:</strong> Pha 30-40ml cho bình 25 Lít nước. Giữ nước trong ruộng sau khi phun 1-2 ngày.</li></ul>',
                'images' => ['products/nominee_10sc.jpg'],
                'variants' => [
                    ['capacity' => 'Chai 100ml', 'price' => 135000, 'stock' => 300],
                ]
            ],
            [
                'name' => 'Phân bón Hữu Cơ Vi Sinh Japan Bio Cải Tạo Đất',
                'category_id' => $catPhanBon->id,
                'brand_id' => $brandBinhDien->id,
                'price' => 320000,
                'unit' => 'Bao',
                'packaging' => 'Bao 25kg công nghệ Nhật',
                'stock' => 500,
                'description' => '<p><strong>Japan Bio Organic</strong> bổ sung các bào tử nấm đối kháng Trichoderma và vi sinh vật giải độc đất. Giúp đất tơi xốp, phòng rễ thối.</p>',
                'usage_guide' => '<ul><li><strong>Bón lót:</strong> Bón 300-500kg/ha trước khi gieo trồng hoặc bón quanh gốc cây ăn trái 2-5kg/gốc.</li></ul>',
                'images' => ['products/japan_bio.jpg'],
                'variants' => [
                    ['capacity' => 'Bao 25kg', 'price' => 320000, 'stock' => 500],
                ]
            ],
            [
                'name' => 'Thuốc trừ rầy Chess 50WG Syngenta',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandSyngenta->id,
                'price' => 140000,
                'unit' => 'Gói',
                'packaging' => 'Gói 15g đặc trị rầy',
                'stock' => 600,
                'description' => '<p><strong>Chess 50WG</strong> có cơ chế chích hút làm chán ăn lập tức. Đặc trị các thế hệ rầy nâu, rầy chổng cánh kháng thuốc hại lúa và cây ăn trái.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 15g cho bình 25 Lít nước. Phun rẽ lối rải đều chân rậm lúa khi rầy cám xuất hiện rộ.</li></ul>',
                'images' => ['products/chess_50wg.jpg'],
                'variants' => [
                    ['capacity' => 'Gói 15g', 'price' => 140000, 'stock' => 600],
                ]
            ],
            [
                'name' => 'Hạt giống Lúa Thơm ST25 Nguyên Chủng Lộc Trời',
                'category_id' => $catHatGiong->id,
                'brand_id' => $brandLocTroi->id,
                'price' => 280000,
                'unit' => 'Bao',
                'packaging' => 'Bao 10kg hạt giống chuẩn',
                'stock' => 400,
                'description' => '<p><strong>Hạt giống Lúa ST25 Nguyên Chủng</strong> đạt tỷ lệ nảy mầm >95%. Gạo hạt dài, thơm ngon đặc sản top 1 thế giới, khả năng chống chịu sâu bệnh khá tốt.</p>',
                'usage_guide' => '<ul><li><strong>Ngâm ủ:</strong> Ngâm nước sạch 24-36 giờ, đãi chua rồi đem ủ ấm 24-30 giờ cho nảy mầm đều trước khi gieo sạ.</li></ul>',
                'images' => ['products/st25_seed.jpg'],
                'variants' => [
                    ['capacity' => 'Bao 10kg', 'price' => 280000, 'stock' => 400],
                ]
            ],
            [
                'name' => 'Thuốc trừ bệnh Nativo 750WG Bayer',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandBayer->id,
                'price' => 215000,
                'unit' => 'Hộp',
                'packaging' => 'Hộp 10 gói x 6g',
                'stock' => 320,
                'description' => '<p><strong>Nativo 750WG Bayer</strong> là thuốc phòng trừ nấm bệnh thế hệ mới với hiệu ứng xanh lá, đặc trị thán thư xoài, sầu riêng, đốm lá và lem lép hạt lúa.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 1 gói 6g cho bình 25 Lít nước. Phun phòng trước hoặc khi bệnh vừa chớm xuất hiện.</li></ul>',
                'images' => ['products/nativo_750wg.jpg'],
                'variants' => [
                    ['capacity' => 'Hộp 10 gói', 'price' => 215000, 'stock' => 320],
                ]
            ]
        ];

        foreach ($productsData as $pData) {
            $variants = $pData['variants'];
            unset($pData['variants']);

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($pData['name'])],
                array_merge($pData, ['status' => 1])
            );

            if ($product->variants()->count() === 0) {
                $product->variants()->createMany($variants);
            }
        }

        // =========================================================================
        // 📚 5 BÀI VIẾT CẨM NĂNG NÔNG NGHIỆP
        // =========================================================================
        $camNangPosts = [
            [
                'title' => 'Cẩm nang hướng dẫn nhận biết và xử lý mặn xâm nhập cho vườn cây ăn trái',
                'slug' => 'cam-nang-huong-dan-nhan-biet-va-xu-ly-man-xam-nhap-cho-vuon-cay-an-trai',
                'category' => 'Cẩm nang nông nghiệp',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Thực trạng mặn xâm nhập tại Đồng bằng sông Cửu Long</h3><p>Mặn xâm nhập mùa khô là thách thức lớn đối với bà con trồng sầu riêng, chôm chôm, măng cụt. Độ mặn trên 1‰ đã có thể gây cháy lá và rụng quả non.</p><h3>2. Các bước xử lý cấp bách</h3><ul><li>Thường xuyên đo độ mặn nguồn nước trước khi bơm tưới vào mương vườn.</li><li>Sử dụng các chế phẩm Humic Mỹ kết hợp phân bón hữu cơ vi sinh để nâng cao sức đề kháng cho bộ rễ.</li><li>Phủ gốc bằng rơm rạ hoặc cỏ khô để hạn chế bốc thoát hơi nước.</li></ul>'
            ],
            [
                'title' => 'Cẩm nang quản lý dinh dưỡng đa trung vi lượng cho lúa vụ Đông Xuân',
                'slug' => 'cam-nang-quan-ly-dinh-duong-da-trung-vi-luong-cho-lua-vu-dong-xuan',
                'category' => 'Cẩm nang nông nghiệp',
                'thumbnail' => 'products/ure_phumy_field.png',
                'content' => '<h3>1. Tầm quan trọng của cân đối dinh dưỡng</h3><p>Đông Xuân là vụ lúa quan trọng nhất trong năm. Việc bón thừa đạm dễ dẫn đến sụp mặt gặt và sâu bệnh bùng phát.</p><h3>2. Công thức bón phân chuẩn</h3><p>Áp dụng công thức bón thúc 3 đợt đúng thời điểm kết hợp bổ sung Kẽm và Canxi giúp cứng cây, đứng lá và bông lúa sáng chắc.</p>'
            ],
            [
                'title' => 'Cẩm nang bảo quản và lưu trữ phân bón vật tư nông nghiệp đúng kỹ thuật',
                'slug' => 'cam-nang-bao-quan-va-luu-tru-phan-bon-vat-tu-nong-nghiep-dung-ky-thuat',
                'category' => 'Cẩm nang nông nghiệp',
                'thumbnail' => 'banners/banner_phanbon.png',
                'content' => '<h3>1. Nguyên tắc xếp chồng kho bãi</h3><p>Không xếp bao phân bón trực tiếp xuống nền xi măng. Phải dùng pallet gỗ cách đất ít nhất 10cm để tránh hút ẩm vón cục.</p><h3>2. Bảo quản thuốc BVTV</h3><p>Để thuốc bảo vệ thực vật nơi khô ráo, xa tầm tay trẻ em, cách ly hoàn toàn khỏi khu vực chứa nông sản và thực phẩm gia đình.</p>'
            ],
            [
                'title' => 'Cẩm nang xử lý ra hoa nghịch vụ trên cây sầu riêng và măng cụt',
                'slug' => 'cam-nang-xu-ly-ra-hoa-nghich-vu-tren-cay-sau-rieng-va-mang-cut',
                'category' => 'Cẩm nang nông nghiệp',
                'thumbnail' => 'products/regent_spraying.png',
                'content' => '<h3>1. Kỹ thuật tạo mầm hoa</h3><p>Sau khi xiết nước phân hóa mầm hoa, tiến hành phun phân bón lá có hàm lượng Lân và Kali cao (MKP, 10-60-10) để kích thích mắt cua ra đồng loạt.</p><h3>2. Chăm sóc giai đoạn xả nhụy</h3><p>Bổ sung Canxi Boron giúp tăng khả năng thụ phấn, giảm thiểu tỷ lệ rụng trái non rộn ràng sau xả nhụy.</p>'
            ],
            [
                'title' => 'Cẩm nang nguyên tắc 4 đúng trong sử dụng thuốc bảo vệ thực vật',
                'slug' => 'cam-nang-nguyen-tac-4-dung-trong-su-dung-thuoc-bao-ve-thuc-vat',
                'category' => 'Cẩm nang nông nghiệp',
                'thumbnail' => 'products/regent_front.png',
                'content' => '<h3>1. Đúng thuốc - Đúng lúc - Đúng liều lượng - Đúng cách</h3><p>Áp dụng nghiêm ngặt nguyên tắc 4 đúng giúp nâng cao hiệu quả diệt trừ sâu bệnh hại up to 95% đồng thời giảm thiểu dư lượng hóa chất trên nông sản xuất khẩu.</p>'
            ]
        ];

        foreach ($camNangPosts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['published_at' => now()])
            );
        }

        // =========================================================================
        // 🌾 5 BÀI VIẾT KỸ THUẬT CANH TÁC
        // =========================================================================
        $canhTacPosts = [
            [
                'title' => 'Kỹ thuật sạ hàng sạ thưa kết hợp bón phân thông minh tiết kiệm 30% chi phí',
                'slug' => 'ky-thuat-sa-hang-sa-thua-ket-hop-bon-phan-thong-minh-tiet-kiem-chi-phi',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'products/ure_phumy_field.png',
                'content' => '<h3>1. Giảm lượng hạt giống gieo sạ</h3><p>Giảm lượng giống sạ xuống 80-100kg/ha giúp ruộng lúa thông thoáng, rễ bám sâu, giảm tỷ lệ đổ ngã và sâu bệnh tấn công.</p><h3>2. Quản lý nước thông minh (AWD)</h3><p>Áp dụng kỹ thuật ngập khô xen kẽ giúp tiết kiệm nước tưới và kích thích rễ lúa ăn sâu vào lòng đất.</p>'
            ],
            [
                'title' => 'Quy trình kỹ thuật chăm sóc cây sầu riêng giai đoạn nuôi trái non',
                'slug' => 'quy-trinh-ky-thuat-cham-soc-cay-sau-rieng-giai-doan-nuoi-trai-non',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Tỉa trái chọn lọc</h3><p>Chỉ giữ lại những trái tròn đều, cuống khỏe trên cành lớn. Tỉa bỏ trái méo, trái sâu bệnh để tập trung dinh dưỡng nuôi trái chất lượng cao.</p><h3>2. Chế độ phân bón</h3><p>Bổ sung NPK 3 số bằng nhau (17-17-17 hoặc 15-15-15) kết hợp phân bón vi lượng giúp cơm sầu riêng vàng dẻo, không bị cháy hộc.</p>'
            ],
            [
                'title' => 'Kỹ thuật xen canh cây công nghiệp và cây ăn trái nâng cao thu nhập',
                'slug' => 'ky-thuat-xen-canh-cay-cong-nghiep-va-cay-an-trai-nang-cao-thu-nhap',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'banners/banner_phanbon.png',
                'content' => '<h3>1. Mô hình xen canh bền vững</h3><p>Xen canh sầu riêng trong vườn cà phê hoặc hồ tiêu giúp che bóng, chắn gió và đa dạng hóa nguồn thu nhập cho nhà nông.</p><h3>2. Lưu ý về mật độ và khoảng cách</h3><p>Đảm bảo khoảng cách hàng cách hàng tối thiểu 9m x 9m để các loại cây không cạnh tranh ánh sáng và chất dinh dưỡng.</p>'
            ],
            [
                'title' => 'Quy trình ủ phân hữu cơ vi sinh từ phụ phẩm nông nghiệp tại nhà',
                'slug' => 'quy-trinh-u-phan-huu-co-vi-sinh-tu-phu-pham-nong-nghiep-tai-nha',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'products/ure_phumy_granules.png',
                'content' => '<h3>1. Chuẩn bị nguyên liệu</h3><p>Sử dụng rơm rạ, vỏ cà phê, phân chuồng hoai mục kết hợp nấm đối kháng Trichoderma.</p><h3>2. Các bước đảo trộn và duy trì độ ẩm</h3><p>Duy trì độ ẩm đống ủ từ 50-60%, đảo trộn định kỳ 10-15 ngày/lần. Sau 45-60 ngày phân ủ mục hoàn toàn có thể đem bón cho cây.</p>'
            ],
            [
                'title' => 'Kỹ thuật tưới tiết kiệm nước tự động cho vườn cây ăn trái vùng đồi dốc',
                'slug' => 'ky-thuat-tuoi-tiet-kiem-nuoc-tu-dong-cho-vuon-cay-an-trai-vung-doi-doc',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Hệ thống tưới bù áp</h3><p>Bố trí béc tưới bù áp giúp lưu lượng nước ra đồng đều tại mọi vị trí từ chân đồi lên đỉnh đồi.</p><h3>2. Tích hợp châm phân tự động (Fertigation)</h3><p>Đưa trực tiếp phân bón hòa tan qua hệ thống tưới giúp tiết kiệm 50% công lao động bón phân thủ công.</p>'
            ]
        ];

        foreach ($canhTacPosts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['published_at' => now()])
            );
        }

        // =========================================================================
        // 🐛 5 BÀI VIẾT QUẢN LÝ SÂU BỆNH
        // =========================================================================
        $sauBenhPosts = [
            [
                'title' => 'Biện pháp phòng trừ tổng hợp (IPM) rầy nâu hại lúa mùa mưa',
                'slug' => 'bien-phap-phong-tru-tong-hop-ipm-ray-nau-hai-lua-mua-mua',
                'category' => 'Quản lý sâu bệnh hại',
                'thumbnail' => 'products/regent_spraying.png',
                'content' => '<h3>1. Nhận biết lứa rầy cám</h3><p>Thường xuyên thăm ruộng, vạch gốc lúa kiểm tra rầy cám nở rộ để đưa ra quyết định phun thuốc kịp thời.</p><h3>2. Sử dụng thuốc đặc trị lưu dẫn</h3><p>Sử dụng các loại thuốc trừ rầy thế hệ mới như Chess 50WG hoặc Regent 800WG phun tập trung vào gốc lúa.</p>'
            ],
            [
                'title' => 'Nhận diện và dập dịch bệnh xơ đen nứt thân xì mủ trên cây mít Thái',
                'slug' => 'nhan-dien-va-dap-dich-benh-xo-den-nut-than-xi-mu-tren-cay-mit-thai',
                'category' => 'Quản lý sâu bệnh hại',
                'thumbnail' => 'products/regent_front.png',
                'content' => '<h3>1. Nguyên nhân gây bệnh</h3><p>Bệnh xơ đen do vi khuẩn Pantoea agglomerans tấn công qua vi phẫu nụ hoa trong mùa mưa.</p><h3>2. Biện pháp quản lý</h3><p>Phun phòng định kỳ bằng các dòng thuốc gốc Đồng hoặc Oxycin từ giai đoạn cựa gà đến trước xả nhụy.</p>'
            ],
            [
                'title' => 'Quản lý bệnh thán thư và sương mai trên cây rau màu mùa lạnh',
                'slug' => 'quan-ly-benh-than-thu-va-suong-mai-tren-cay-rau-mau-mua-lanh',
                'category' => 'Quản lý sâu bệnh hại',
                'thumbnail' => 'products/atonik_front.jpg',
                'content' => '<h3>1. Triệu chứng gây hại</h3><p>Vết bệnh thán thư làm lá rau bị thâm đen, thối nhũn và đốm vòng. Sương mai tạo lớp phấn trắng mặt dưới lá dưa hấu, cà chua.</p><h3>2. Phun phòng hóa học</h3><p>Sử dụng thuốc trừ bệnh phổ rộng Chloronil 75WP hoặc Nativo 750WG để bảo vệ lá rau luôn xanh mượt.</p>'
            ],
            [
                'title' => 'Kỹ thuật diệt trừ sâu cuốn lá nhỏ và sâu đục thân hại lúa triệt để',
                'slug' => 'ky-thuat-diet-tru-sau-cuon-la-nho-va-sau-duc-than-hai-lua-triet-de',
                'category' => 'Quản lý sâu bệnh hại',
                'thumbnail' => 'products/regent_spraying.png',
                'content' => '<h3>1. Vòng đời sâu cuốn lá</h3><p>Xác định đỉnh bướm rộ sau 5-7 ngày để tiến hành phun thuốc khi sâu tuổi 1-2 còn nhỏ chưa bao lá.</p><h3>2. Thuốc đặc trị hiệu lực kéo dài</h3><p>Phun Voliam Targo hoặc Regent để cắt lứa sâu triệt để, bảo vệ bộ lá đòng quang hợp nuôi hạt.</p>'
            ],
            [
                'title' => 'Phương pháp khống chế nấm bệnh Phytophthora gây thối rễ cây ăn trái',
                'slug' => 'phuong-phap-khong-che-nam-benh-phytophthora-gay-thoi-re-cay-an-trai',
                'category' => 'Quản lý sâu bệnh hại',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Tác hại của nấm Phytophthora</h3><p>Nấm Phytophthora gây thối rễ tơ, làm vàng lá rụng lá hàng loạt trên cây sầu riêng, cam, bưởi.</p><h3>2. Xử lý quét gốc và tưới rễ</h3><p>Sử dụng thuốc lưu dẫn 2 chiều Metalaxyl 35WP kết hợp cạo sạch vết xì mủ trên thân và quét trực tiếp thuốc nguyên chất.</p>'
            ]
        ];

        foreach ($sauBenhPosts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['published_at' => now()])
            );
        }

        // =========================================================================
        // 📰 5 BÀI VIẾT TIN TỨC NÔNG NGHIỆP
        // =========================================================================
        $tinTucPosts = [
            [
                'title' => 'Dự báo thị trường xuất khẩu lúa gạo Việt Nam đạt kỷ lục trong quý III/2026',
                'slug' => 'du-bao-thi-truong-xuat-khau-lua-gao-viet-nam-dat-ky-luc-trong-quy-iii-2026',
                'category' => 'Tin tức nông nghiệp',
                'thumbnail' => 'banners/banner_phanbon.png',
                'content' => '<h3>1. Nhu cầu lương thực toàn cầu gia tăng</h3><p>Các thị trường truyền thống như Philippines, Indonesia và Trung Đông tiếp tục tăng cường nhập khẩu gạo thơm ST25 và lúa chất lượng cao từ Việt Nam.</p><h3>2. Cơ hội cho bà con nông dân ĐBSCL</h3><p>Giá lúa tươi tại ruộng duy trì mức cao kỷ lục giúp bà con an tâm đầu tư vật tư nông nghiệp chính hãng cho mùa vụ tiếp theo.</p>'
            ],
            [
                'title' => 'Cập nhật chính sách hỗ trợ nông dân chuyển đổi số và canh tác xanh',
                'slug' => 'cap-nhat-chinh-sach-ho-tro-nong-dan-chuyen-doi-so-va-canh-tac-xanh',
                'category' => 'Tin tức nông nghiệp',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Gói tín dụng ưu đãi 1 triệu ha lúa chất lượng cao</h3><p>Bộ Nông nghiệp & PTNT vừa công bố gói hỗ trợ lãi suất vay vốn cho các hợp tác xã áp dụng quy trình giảm phát thải carbon.</p><h3>2. Ứng dụng công nghệ nhật ký sản xuất điện tử</h3><p>Giúp truy xuất nguồn gốc nông sản phục vụ xuất khẩu đạt chuẩn GlobalGAP và VietGAP.</p>'
            ],
            [
                'title' => 'Đồng bằng sông Cửu Long nhân rộng mô hình lúa - tôm thông minh',
                'slug' => 'dong-bang-song-cuu-long-nhan-rong-mo-hinh-lua-tom-thong-minh',
                'category' => 'Tin tức nông nghiệp',
                'thumbnail' => 'products/ure_phumy_field.png',
                'content' => '<h3>1. Mô hình thích ứng biến đổi khí hậu</h3><p>Mô hình 1 vụ lúa - 1 vụ tôm tại Kiên Giang, Cà Mau mang lại hiệu quả kinh tế kép gấp 2-3 lần so với độc canh cây lúa.</p><h3>2. Sử dụng vật tư sinh học an toàn cho tôm</h3><p>Khuyến khích nhà nông ưu tiên dùng phân bón hữu cơ vi sinh và thuốc sinh học để bảo vệ môi trường nước nuôi tôm.</p>'
            ],
            [
                'title' => 'Giá phân bón và vật tư nông nghiệp biến động nhẹ đầu mùa vụ Thu Đông',
                'slug' => 'gia-phan-bon-va-vat-tu-nong-nghiep-bien-dong-nhe-dau-mua-vu-thu-dong',
                'category' => 'Tin tức nông nghiệp',
                'thumbnail' => 'banners/banner_phanbon.png',
                'content' => '<h3>1. Diễn biến thị trường phân bón trong nước</h3><p>Giá phân bón Ure Phú Mỹ và NPK Đầu Trâu duy trì ổn định nhờ nguồn cung dồi dào từ các nhà máy trong nước.</p><h3>2. EcoFarm cam kết bình ổn giá vật tư</h3><p>Hệ thống đại lý EcoFarm triển khai nhiều chương trình khuyến mãi chiết khấu hấp dẫn hỗ trợ bà con xuống giống vụ mới.</p>'
            ],
            [
                'title' => 'Hội thảo quốc tế về giải pháp thích ứng biến đổi khí hậu khu vực ĐBSCL',
                'slug' => 'hoi-thao-quoc-te-ve-giai-phap-thich-ung-bien-doi-khi-hau-khu-vuc-dbscl',
                'category' => 'Tin tức nông nghiệp',
                'thumbnail' => 'banners/banner_canhtac.png',
                'content' => '<h3>1. Đánh giá tác động của hạn mặn</h3><p>Các chuyên gia quốc tế đề xuất giải pháp quy hoạch lại vùng sản xuất nông nghiệp bám sát nguồn nước ngọt sông Tiền và sông Hậu.</p><h3>2. Chuyển giao tiến bộ kỹ thuật mới</h3><p>Giới thiệu các giống cây trồng chịu mặn và quy trình dinh dưỡng phân bón thông minh bảo vệ hệ sinh thái ĐBSCL.</p>'
            ]
        ];

        foreach ($tinTucPosts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['published_at' => now()])
            );
        }
    }
}
