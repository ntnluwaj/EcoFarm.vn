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
        User::updateOrCreate(
            ['email' => 'ngocadmin@gmail.com'],
            [
                'name' => 'Nguyễn Ngọc Admin',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'phone' => '0912345478',
            ]
        );

        User::updateOrCreate(
            ['email' => 'nongdanhailua@gmail.com'],
            [
                'name' => 'Bà con Hai Lúa',
                'password' => bcrypt('12345678'),
                'role' => 'customer',
                'phone' => '0987654321',
                'address' => 'Hợp tác xã lúa chín, Huyện Cờ Đỏ, Cần Thơ',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dailymekong@gmail.com'],
            [
                'name' => 'Đại lý Vật tư Mekong',
                'password' => bcrypt('12345678'),
                'role' => 'agency',
                'phone' => '0909123456',
                'address' => '456 Đường 30/4, Quận Ninh Kiều, Cần Thơ',
            ]
        );

        // 2. Tạo các Thương hiệu/Nhà sản xuất vật tư mẫu
        $brandSyngenta = Brand::firstOrCreate(
            ['slug' => 'syngenta-viet-nam'],
            ['name' => 'Syngenta Việt Nam', 'description' => 'Tập đoàn toàn cầu về sản xuất giải pháp bảo vệ thực vật và hạt giống chất lượng cao.']
        );

        $brandBinhDien = Brand::firstOrCreate(
            ['slug' => 'phan-bon-binh-dien'],
            ['name' => 'Phân bón Bình Điền', 'description' => 'Thương hiệu phân bón Đầu Trâu hàng đầu Việt Nam, đồng hành cùng nhà nông.']
        );

        $brandPhuMy = Brand::firstOrCreate(
            ['slug' => 'dam-phu-my'],
            ['name' => 'Đạm Phú Mỹ', 'description' => 'Tổng công ty Phân bón và Hóa chất Dầu khí.']
        );

        $brandBayer = Brand::firstOrCreate(
            ['slug' => 'bayer-cropscience'],
            ['name' => 'Bayer CropScience', 'description' => 'Tập đoàn Bayer chuyên về nông hóa và hạt giống.']
        );

        // 3. Tạo các Danh mục phân loại gốc mẫu
        $catThuoc = Category::firstOrCreate(
            ['slug' => 'thuoc-tru-sau-va-benh'],
            ['name' => 'Thuốc Trừ Sâu & Bệnh', 'parent_id' => null]
        );

        $catPhanBon = Category::firstOrCreate(
            ['slug' => 'phan-bon-huu-co-va-npk'],
            ['name' => 'Phân Bón Hữu Cơ & NPK', 'parent_id' => null]
        );

        // 4. Khởi tạo danh sách Sản phẩm vật tư mẫu trực quan (Đồng bộ mảng hình ảnh thực tế)
        
        // Mặt hàng 1: Thuốc trừ bệnh Anvil
        $prodAnvil = Product::updateOrCreate(
            ['slug' => 'thuoc-tru-benh-anvil-5sc-syngenta'],
            [
                'name' => 'Thuốc trừ bệnh Anvil 5SC Syngenta',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandSyngenta->id,
                'price' => 210000,
                'unit' => 'Chai',
                'packaging' => 'Thùng 24 chai 1 Lít',
                'stock' => 120,
                'status' => true,
                'description' => '<p><strong>Anvil 5SC</strong> là thuốc trừ bệnh nội hấp, lưu dẫn mạnh, chuyên trị rỉ sắt, lở cổ rễ trên cây ăn trái và lem lép hạt trên lúa khu vực miền Tây.</p>',
                'usage_guide' => '<p>Pha 20ml cho bình 16 Lít nước. Phun đều tán lá khi vết bệnh mới xuất hiện đầu mùa vụ để bảo vệ cây toàn diện.</p>',
                'images' => [
                    'products/regent_front.png' // Sử dụng ảnh thực tế có sẵn làm template tránh lỗi vỡ hình
                ],
            ]
        );

        if ($prodAnvil->variants()->count() === 0) {
            $prodAnvil->variants()->createMany([
                ['capacity' => '250ml', 'price' => 75000, 'stock' => 50],
                ['capacity' => '500ml', 'price' => 125000, 'stock' => 80],
                ['capacity' => '1 Lít', 'price' => 210000, 'stock' => 120],
            ]);
        }

        // Mặt hàng 2: Phân bón NPK Đầu Trâu
        $prodNPK = Product::updateOrCreate(
            ['slug' => 'phan-bon-npk-dau-trau-20-20-15-cao-cap'],
            [
                'name' => 'Phân bón NPK Đầu Trâu 20-20-15 Cao Cấp',
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
                    'products/ure_phumy_front.png'
                ],
            ]
        );

        if ($prodNPK->variants()->count() === 0) {
            $prodNPK->variants()->createMany([
                ['capacity' => 'Bao 10kg', 'price' => 180000, 'stock' => 200],
                ['capacity' => 'Bao 25kg', 'price' => 430000, 'stock' => 150],
                ['capacity' => 'Bao 50kg', 'price' => 850000, 'stock' => 500],
            ]);
        }

        // Mặt hàng 3: Phân bón Ure Phú Mỹ
        $prodUre = Product::updateOrCreate(
            ['slug' => 'phan-bon-ure-phu-my-hat-trong'],
            [
                'name' => 'Phân bón Ure Phú Mỹ hạt trong',
                'category_id' => $catPhanBon->id,
                'brand_id' => $brandPhuMy->id,
                'price' => 680000,
                'unit' => 'Bao',
                'packaging' => 'Bao 50kg chính hãng',
                'stock' => 300,
                'status' => true,
                'description' => '<p><strong>Phân bón Ure Phú Mỹ hạt trong</strong> là sản phẩm phân đạm cao cấp hàng đầu Việt Nam, giúp bổ sung Nitơ thiết yếu thúc đẻ nhánh mạnh, nở bụi nhanh và phục hồi cây trồng xanh tốt.</p>',
                'usage_guide' => '<p>Bón thúc 100 - 150kg/ha cho lúa, rau màu và cây ăn trái. Bảo quản nơi khô ráo thoáng mát, đậy kín bao tránh ẩm.</p>',
                'images' => [
                    'products/ure_phumy_front.png',
                    'products/ure_phumy_granules.png',
                    'products/ure_phumy_field.png'
                ],
            ]
        );

        if ($prodUre->variants()->count() === 0) {
            $prodUre->variants()->createMany([
                ['capacity' => 'Bao 25kg', 'price' => 350000, 'stock' => 100],
                ['capacity' => 'Bao 50kg', 'price' => 680000, 'stock' => 300],
            ]);
        }

        // Mặt hàng 4: Thuốc trừ sâu Regent 800WG
        $prodRegent = Product::updateOrCreate(
            ['slug' => 'thuoc-tru-sau-regent-800wg-bayer'],
            [
                'name' => 'Thuốc trừ sâu Regent 800WG Bayer',
                'category_id' => $catThuoc->id,
                'brand_id' => $brandBayer->id,
                'price' => 150000,
                'unit' => 'Hộp',
                'packaging' => 'Hộp 10 gói x 1.6g',
                'stock' => 1000,
                'status' => true,
                'description' => '<p><strong>Regent 800WG</strong> là thuốc trừ sâu phổ rộng cực mạnh của hãng Bayer, đặc trị sâu cuốn lá, rầy nâu trên lúa và các côn trùng chích hút hại cây trồng vườn.</p>',
                'usage_guide' => '<p>Pha 1 gói 1.6g cho bình 16 - 25 Lít nước, phun ướt đều tán lá. Ngưng phun thuốc 7 ngày trước khi thu hoạch.</p>',
                'images' => [
                    'products/regent_front.png',
                    'products/regent_spraying.png'
                ],
            ]
        );

        if ($prodRegent->variants()->count() === 0) {
            $prodRegent->variants()->createMany([
                ['capacity' => 'Hộp 10 gói', 'price' => 150000, 'stock' => 1000],
            ]);
        }

        // 5. Khởi tạo danh sách bài viết cẩm nang mẫu
        if (\App\Models\Post::count() === 0) {
            \App\Models\Post::updateOrCreate(
                ['slug' => 'ky-thuat-bon-phan-npk-dau-trau-cho-lua-dat-nang-suat-cao-dau-vu'],
                [
                    'title' => 'Kỹ thuật bón phân NPK Đầu Trâu cho lúa đạt năng suất cao đầu vụ',
                    'category' => 'Kỹ thuật canh tác',
                    'thumbnail' => 'products/ure_phumy_field.png',
                    'content' => '<p>Bón phân NPK cân đối là yếu tố quyết định hàng đầu giúp lúa đẻ nhánh khỏe, nở bụi nhanh và đạt số hạt trên bông cao. Dưới đây là quy trình chi tiết:</p><h5>1. Giai đoạn bón lót</h5><p>Bón lót trước khi sạ lúa từ 1-2 ngày để cung cấp dinh dưỡng kích rễ phát triển sâu vào lòng đất. Sử dụng phân bón hữu cơ kết hợp phân lân super.</p><h5>2. Bón thúc đợt 1 (7-10 ngày sau sạ)</h5><p>Bón thúc đẻ nhánh giúp lúa phục hồi nhanh sau sạ. Sử dụng NPK Đầu Trâu 20-20-15 với liều lượng 100-150kg/ha.</p><h5>3. Bón thúc đợt 2 (20-25 ngày sau sạ)</h5><p>Bón thúc giúp lúa đẻ nhánh tối đa và phân hóa mầm hoa tốt. Tăng cường phân đạm và kali.</p><p>Hy vọng quy trình này giúp bà con đạt vụ mùa bội thu!</p>',
                    'published_at' => now(),
                ]
            );

            \App\Models\Post::updateOrCreate(
                ['slug' => 'lich-xuong-giong-mua-vu-thu-dong-2026-khu-vuc-mien-tay'],
                [
                    'title' => 'Lịch xuống giống mùa vụ Thu Đông 2026 khu vực miền Tây',
                    'category' => 'Lịch mùa vụ',
                    'thumbnail' => 'banners/banner_canhtac.png',
                    'content' => '<p>Sở Nông nghiệp và Phát triển nông thôn các tỉnh Đồng bằng sông Cửu Long vừa ban hành khung lịch thời vụ xuống giống lúa Thu Đông 2026 bám sát triều cường và hạn mặn:</p><h5>1. Đợt 1 (Từ ngày 10/08 - 25/08/2026)</h5><p>Áp dụng cho các vùng đất cao, chủ động được nguồn nước triệt tiêu và thoát nước triệt để khi mưa lũ tràn về.</p><h5>2. Đợt 2 (Từ ngày 05/09 - 20/09/2026)</h5><p>Đây là đợt xuống giống tập trung và quy mô lớn nhất cho toàn vùng Đồng bằng sông Cửu Long. Khuyến cáo bà con sạ đồng loạt để phòng tránh dịch rầy nâu truyền bệnh.</p><h5>3. Các lưu ý phòng trừ sâu hại đầu vụ</h5><p>Bà con cần làm đất kỹ, vệ sinh đồng ruộng sạch cỏ rác và sử dụng các loại thuốc bảo vệ thực vật chính hãng như Anvil 5SC để xử lý hạt giống trước khi gieo sạ.</p>',
                    'published_at' => now(),
                ]
            );

            \App\Models\Post::updateOrCreate(
                ['slug' => 'giai-phap-phong-ngua-nam-benh-ri-sat-tren-cay-sau-rieng-mua-mua-lu'],
                [
                    'title' => 'Giải pháp phòng ngừa nấm bệnh rỉ sắt trên cây sầu riêng mùa mưa lũ',
                    'category' => 'Tin thị trường',
                    'thumbnail' => 'products/regent_spraying.png',
                    'content' => '<p>Bệnh rỉ sắt do nấm Phakopsora ampelopsidis gây ra là nỗi ám ảnh lớn của các nhà vườn trồng sầu riêng tại miền Tây mỗi khi bước vào mùa mưa dầm bão lũ.</p><h5>1. Triệu chứng nhận nhận biết</h5><p>On mặt lá xuất hiện các đốm nhỏ màu vàng nhạt, sau đó chuyển sang màu nâu đỏ như màu rỉ sắt ở mặt dưới lá. Bệnh nặng làm lá khô cháy và rụng đồng loạt, khiến cây suy kiệt nghiêm trọng.</p><h5>2. Biện pháp canh tác phòng ngừa</h5><p>Thường xuyên cắt tỉa cành tạo tán thông thoáng, dọn sạch cỏ dại quanh gốc để tránh đọng ẩm. Bón phân hữu cơ vi sinh kết hợp lân và kali đầy đủ để tăng sức đề kháng cho cây.</p><h5>3. Biện pháp hóa học</h5><p>Khi bệnh chớm xuất hiện, bà con cần phun ngay thuốc trừ nấm nội hấp mạnh như <strong>Anvil 5SC của Syngenta</strong>. Phun đều 2 mặt lá định kỳ 7-10 ngày/lần để bảo vệ cây toàn diện.</p>',
                    'published_at' => now(),
                ]
            );
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

        // 🌟 BỔ SUNG: Khởi tạo thông báo mẫu cho cả Admin và Nhân viên (staff) để hiển thị chuông thông báo ngay sau khi deploy
        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
            foreach ($recipients as $recipient) {
                $hasNotifs = \Illuminate\Support\Facades\DB::table('notifications')->where('notifiable_id', $recipient->id)->exists();
                if (!$hasNotifs) {
                    \Filament\Notifications\Notification::make()
                        ->title('Hệ thống thông báo tác nghiệp đã kích hoạt!')
                        ->body('EcoFarm chúc bạn một ngày làm việc hiệu quả. Các thông báo đơn hàng và yêu cầu tư vấn mới sẽ hiển thị tại đây.')
                        ->icon('heroicon-o-bell')
                        ->color('success')
                        ->sendToDatabase($recipient);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi tạo thông báo mẫu: " . $e->getMessage());
        }
    }
}