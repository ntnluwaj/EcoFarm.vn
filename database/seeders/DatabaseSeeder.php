<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo tài khoản mẫu để xác thực hệ thống công việc (PRD - UC-09)
        User::create([
            'name' => 'Nguyễn Ngọc Admin',
            'email' => 'ngocadmin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'phone' => '0912345478',
        ]);

        // 2. Tạo các Thương hiệu/Nhà sản xuất vật tư mẫu
        $brandSyngenta = Brand::create([
            'name' => 'Syngenta Việt Nam',
            'slug' => 'syngenta-viet-nam',
            'description' => 'Tập đoàn toàn cầu về sản xuất giải pháp bảo vệ thực vật và hạt giống chất lượng cao.',
        ]);

        $brandBinhDien = Brand::create([
            'name' => 'Phân bón Bình Điền',
            'slug' => 'phan-bon-binh-dien',
            'description' => 'Thương hiệu phân bón Đầu Trâu hàng đầu Việt Nam, đồng hành cùng nhà nông.',
        ]);

        // 3. Tạo các Danh mục phân loại gốc mẫu
        $catThuoc = Category::create([
            'name' => 'Thuốc Trừ Sâu & Bệnh',
            'slug' => 'thuoc-tru-sau-va-benh',
            'parent_id' => null,
        ]);

        $catPhanBon = Category::create([
            'name' => 'Phân Bón Hữu Cơ & NPK',
            'slug' => 'phan-bon-huu-co-va-npk',
            'parent_id' => null,
        ]);

        // 4. Khởi tạo danh sách Sản phẩm vật tư mẫu trực quan (Đồng bộ mảng nhiều hình ảnh Slide)
        
        // Mặt hàng 1: Thuốc trừ bệnh Anvil
        $prodAnvil = Product::create([
            'name' => 'Thuốc trừ bệnh Anvil 5SC Syngenta',
            'slug' => 'thuoc-tru-benh-anvil-5sc-syngenta',
            'category_id' => $catThuoc->id,
            'brand_id' => $brandSyngenta->id,
            'price' => 210000,          // Giá bán lẻ cho nông dân vãng lai
            'unit' => 'Chai',
            'packaging' => 'Thùng 24 chai 1 Lít',
            'stock' => 120, // Số lượng hàng tồn kho thực tế tại kho bãi Cần Thơ
            'status' => true,
            'description' => '<p><strong>Anvil 5SC</strong> là thuốc trừ bệnh nội hấp, lưu dẫn mạnh, chuyên trị rỉ sắt, lở cổ rễ trên cây ăn trái và lem lép hạt trên lúa khu vực miền Tây.</p>',
            'usage_guide' => '<p>Pha 20ml cho bình 16 Lít nước. Phun đều tán lá khi vết bệnh mới xuất hiện đầu mùa vụ để bảo vệ cây toàn diện.</p>',
            // 🌟 CẬP NHẬT: Thêm mảng chứa danh sách nhiều ảnh mẫu chạy Slide Frontend
            'images' => [
                'products/anvil_front.jpg',
                'products/anvil_back.jpg',
                'products/anvil_label.jpg'
            ],
        ]);

        $prodAnvil->variants()->createMany([
            ['capacity' => '250ml', 'price' => 75000, 'stock' => 50],
            ['capacity' => '500ml', 'price' => 125000, 'stock' => 80],
            ['capacity' => '1 Lít', 'price' => 210000, 'stock' => 120],
        ]);

        // Mặt hàng 2: Phân bón NPK Đầu Trâu
        $prodNPK = Product::create([
            'name' => 'Phân bón NPK Đầu Trâu 20-20-15 Cao Cấp',
            'slug' => 'phan-bon-npk-dau-trau-20-20-15-cao-cap',
            'category_id' => $catPhanBon->id,
            'brand_id' => $brandBinhDien->id,
            'price' => 850000,
            'unit' => 'Bao',
            'packaging' => 'Bao 50kg chính hãng',
            'stock' => 500,
            'status' => true,
            'description' => '<p><strong>NPK Đầu Trâu 20-20-15</strong> cung cấp nguồn dinh dưỡng Đa - Trung - Vi lượng cân đối giúp cây đâm chồi mạnh, nở bụi nhanh, tăng năng suất mùa vụ.</p>',
            'usage_guide' => '<p>Bón thúc định kỳ vào gốc từ 150 - 250kg/ha tùy theo chu kỳ sinh trưởng của cây trồng và điều kiện thổ nhưỡng.</p>',
            'images' => [
                'products/dautrau_front.jpg',
                'products/dautrau_detail.jpg'
            ],
        ]);

        $prodNPK->variants()->createMany([
            ['capacity' => 'Bao 10kg', 'price' => 180000, 'stock' => 200],
            ['capacity' => 'Bao 25kg', 'price' => 430000, 'stock' => 150],
            ['capacity' => 'Bao 50kg', 'price' => 850000, 'stock' => 500],
        ]);

        // 5. Khởi tạo danh sách bài viết cẩm nang mẫu
        if (\App\Models\Post::count() === 0) {
            \App\Models\Post::create([
                'title' => 'Kỹ thuật bón phân NPK Đầu Trâu cho lúa đạt năng suất cao đầu vụ',
                'slug' => 'ky-thuat-bon-phan-npk-dau-trau-cho-lua-dat-nang-suat-cao-dau-vu',
                'category' => 'Kỹ thuật canh tác',
                'thumbnail' => 'posts/bon_phan_npk_lua.jpg',
                'content' => '<p>Bón phân NPK cân đối là yếu tố quyết định hàng đầu giúp lúa đẻ nhánh khỏe, nở bụi nhanh và đạt số hạt trên bông cao. Dưới đây là quy trình chi tiết:</p><h5>1. Giai đoạn bón lót</h5><p>Bón lót trước khi sạ lúa từ 1-2 ngày để cung cấp dinh dưỡng kích rễ phát triển sâu vào lòng đất. Sử dụng phân bón hữu cơ kết hợp phân lân super.</p><h5>2. Bón thúc đợt 1 (7-10 ngày sau sạ)</h5><p>Bón thúc đẻ nhánh giúp lúa phục hồi nhanh sau sạ. Sử dụng NPK Đầu Trâu 20-20-15 với liều lượng 100-150kg/ha.</p><h5>3. Bón thúc đợt 2 (20-25 ngày sau sạ)</h5><p>Bón thúc giúp lúa đẻ nhánh tối đa và phân hóa mầm hoa tốt. Tăng cường phân đạm và kali.</p><p>Hy vọng quy trình này giúp bà con đạt vụ mùa bội thu!</p>',
                'published_at' => now(),
            ]);

            \App\Models\Post::create([
                'title' => 'Lịch xuống giống mùa vụ Thu Đông 2026 khu vực miền Tây',
                'slug' => 'lich-xuong-giong-mua-vu-thu-dong-2026-khu-vuc-mien-tay',
                'category' => 'Lịch mùa vụ',
                'thumbnail' => 'posts/lich_xuong_giong.jpg',
                'content' => '<p>Sở Nông nghiệp và Phát triển nông thôn các tỉnh Đồng bằng sông Cửu Long vừa ban hành khung lịch thời vụ xuống giống lúa Thu Đông 2026 bám sát triều cường và hạn mặn:</p><h5>1. Đợt 1 (Từ ngày 10/08 - 25/08/2026)</h5><p>Áp dụng cho các vùng đất cao, chủ động được nguồn nước tưới tiêu và thoát nước triệt để khi mưa lũ tràn về.</p><h5>2. Đợt 2 (Từ ngày 05/09 - 20/09/2026)</h5><p>Đây là đợt xuống giống tập trung và quy mô lớn nhất cho toàn vùng Đồng bằng sông Cửu Long. Khuyến cáo bà con sạ đồng loạt để phòng tránh dịch rầy nâu truyền bệnh.</p><h5>3. Các lưu ý phòng trừ sâu hại đầu vụ</h5><p>Bà con cần làm đất kỹ, vệ sinh đồng ruộng sạch cỏ rác và sử dụng các loại thuốc bảo vệ thực vật chính hãng như Anvil 5SC để xử lý hạt giống trước khi gieo sạ.</p>',
                'published_at' => now(),
            ]);

            \App\Models\Post::create([
                'title' => 'Giải pháp phòng ngừa nấm bệnh rỉ sắt trên cây sầu riêng mùa mưa lũ',
                'slug' => 'giai-phap-phong-ngua-nam-benh-ri-sat-tren-cay-sau-rieng-mua-mua-lu',
                'category' => 'Tin thị trường',
                'thumbnail' => 'posts/ri_sat_sau_rieng.jpg',
                'content' => '<p>Bệnh rỉ sắt do nấm Phakopsora ampelopsidis gây ra là nỗi ám ảnh lớn của các nhà vườn trồng sầu riêng tại miền Tây mỗi khi bước vào mùa mưa dầm bão lũ.</p><h5>1. Triệu chứng nhận biết</h5><p>On mặt lá xuất hiện các đốm nhỏ màu vàng nhạt, sau đó chuyển sang màu nâu đỏ như màu rỉ sắt ở mặt dưới lá. Bệnh nặng làm lá khô cháy và rụng đồng loạt, khiến cây suy kiệt nghiêm trọng.</p><h5>2. Biện pháp canh tác phòng ngừa</h5><p>Thường xuyên cắt tỉa cành tạo tán thông thoáng, dọn sạch cỏ dại quanh gốc để tránh đọng ẩm. Bón phân hữu cơ vi sinh kết hợp lân và kali đầy đủ để tăng sức đề kháng cho cây.</p><h5>3. Biện pháp hóa học</h5><p>Khi bệnh chớm xuất hiện, bà con cần phun ngay thuốc trừ nấm nội hấp mạnh như <strong>Anvil 5SC của Syngenta</strong>. Phun đều 2 mặt lá định kỳ 7-10 ngày/lần để bảo vệ cây toàn diện.</p>',
                'published_at' => now(),
            ]);
        }

        // 6. Khởi tạo danh sách slide banner động mẫu chủ đề Nông nghiệp tươi sáng
        if (\App\Models\Banner::count() === 0) {
            \App\Models\Banner::create([
                'title' => 'Cung Ứng Phân Bón & Thuốc Bảo Vệ Thực Vật Chính Hãng',
                'subtitle' => 'VẬT TƯ NÔNG NGHIỆP CHẤT LƯỢNG CAO',
                'image_path' => 'banners/banner_phanbon.png',
                'link_url' => '/san-pham',
                'sort_order' => 1,
                'is_active' => true,
            ]);

            \App\Models\Banner::create([
                'title' => 'Giải Pháp Canh Tác Sạch Đạt Chuẩn GlobalGAP',
                'subtitle' => 'NÂNG TẦM NÔNG SẢN VIỆT',
                'image_path' => 'banners/banner_canhtac.png',
                'link_url' => '/cam-nang',
                'sort_order' => 2,
                'is_active' => true,
            ]);
        }
    }
}