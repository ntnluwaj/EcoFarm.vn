<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Str;

class BambooProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tìm hoặc tạo Thương hiệu Bamboo Việt Nam
        $brand = Brand::firstOrCreate(
            ['name' => 'Bamboo Việt Nam'],
            ['slug' => Str::slug('Bamboo Việt Nam')]
        );

        $products = [
            [
                'name' => 'Thuốc trừ bệnh Oxycin Bamboo',
                'category_id' => 1,
                'price' => 195000,
                'unit' => 'Chai',
                'packaging' => 'Chai 500ml',
                'stock' => 200,
                'description' => '<p><strong>Oxycin</strong> là thuốc trừ bệnh thế hệ mới bảo vệ cây trồng cực mạnh. Hỗ trợ đắc lực trong quản lý bệnh xơ đen, nứt thân xì mủ trên cây mít và thối rễ cây ăn trái miền Tây.</p>',
                'usage_guide' => '<ul><li><strong>Đối tượng phòng trừ:</strong> Xơ đen trên mít, nứt thân xì mủ sầu riêng, thối rễ cam sành.</li><li><strong>Liều lượng:</strong> Pha 25ml thuốc cho bình 25 Lít nước. Phun đều tán lá hoặc quét trực tiếp vào vết xì mủ.</li></ul>',
                'images' => ['products/bamboo_oxycin.jpg']
            ],
            [
                'name' => 'Thuốc trừ bệnh Bamboo Chloronil 75WP',
                'category_id' => 1,
                'price' => 160000,
                'unit' => 'Gói',
                'packaging' => 'Gói 500g',
                'stock' => 180,
                'description' => '<p><strong>Bamboo Chloronil 75WP</strong> là thuốc trừ nấm bệnh phổ rộng thế hệ mới có tác dụng tiếp xúc và bảo vệ hoàn hảo. Chuyên đặc trị sương mai, phấn trắng hại dưa hấu, rau màu và thán thư trên xoài.</p>',
                'usage_guide' => '<ul><li><strong>Đối tượng phòng trừ:</strong> Thán thư, phấn trắng, sương mai, giả sương mai.</li><li><strong>Liều lượng:</strong> Pha 30-40g cho bình 25 Lít nước. Phun khi vết bệnh chớm xuất hiện.</li></ul>',
                'images' => ['products/bamboo_chloronil.jpg']
            ],
            [
                'name' => 'Thuốc trừ bệnh Bamboo Hexa 5SC',
                'category_id' => 1,
                'price' => 145000,
                'unit' => 'Chai',
                'packaging' => 'Chai 1 Lít',
                'stock' => 150,
                'description' => '<p><strong>Bamboo Hexa 5SC</strong> chứa hoạt chất Hexaconazole lưu dẫn sâu, chuyên trị nấm bệnh khô vằn, lem lép hạt trên lúa, nấm hồng trên cao su và rỉ sắt hại cà phê.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 40-50ml cho bình 25 Lít nước. Phun ướt đều tán lá khi lúa chuẩn bị trổ bông và sau khi trổ đều.</li></ul>',
                'images' => ['products/bamboo_hexa.jpg']
            ],
            [
                'name' => 'Thuốc trừ bệnh Bamboo Metalaxyl 35WP',
                'category_id' => 1,
                'price' => 135000,
                'unit' => 'Gói',
                'packaging' => 'Gói 100g',
                'stock' => 300,
                'description' => '<p><strong>Bamboo Metalaxyl 35WP</strong> là thuốc đặc trị các bệnh do nấm Phytophthora hại rễ và thân cây ăn quả. Thuốc lưu dẫn hai chiều cực nhanh từ rễ lên lá và ngược lại.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 20g cho bình 20 Lít nước, tưới gốc hoặc phun đẫm quanh tán và cổ rễ cây ăn quả.</li></ul>',
                'images' => ['products/bamboo_metalaxyl.jpg']
            ],
            [
                'name' => 'Phân bón hữu cơ Bamboo Organic',
                'category_id' => 2,
                'price' => 350000,
                'unit' => 'Bao',
                'packaging' => 'Bao 25kg',
                'stock' => 400,
                'description' => '<p><strong>Bamboo Organic</strong> cung cấp chất hữu cơ hoạt hóa giúp cải tạo đất bạc màu, kích thích bộ rễ phát triển cực mạnh, đẻ nhánh nhanh, mập đọt và phục hồi cây suy sau thu hoạch.</p>',
                'usage_guide' => '<ul><li><strong>Đối tượng bón tưới:</strong> Sầu riêng, cây ăn trái và hoa kiểng các loại.</li><li><strong>Cách bón:</strong> Rải gốc từ 1 - 3kg/gốc tùy theo độ tuổi của cây trồng. Bón kết hợp tưới đủ nước.</li></ul>',
                'images' => ['products/bamboo_organic.jpg']
            ],
            [
                'name' => 'Phân bón vi lượng Bamboo Magie Fulvic',
                'category_id' => 2,
                'price' => 120000,
                'unit' => 'Chai',
                'packaging' => 'Chai 1 Lít',
                'stock' => 250,
                'description' => '<p><strong>Bamboo Magie Fulvic</strong> bổ sung nguồn Magie và Axit Fulvic đậm đặc giúp lá cây xanh dày, bóng mượt, khắc phục hoàn tượng vàng lá gân xanh do thiếu hụt vi lượng.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 20-30ml cho bình 25 Lít nước, phun định kỳ 10-15 ngày/lần trong giai đoạn phát triển cành lá.</li></ul>',
                'images' => ['products/bamboo_magie.jpg']
            ],
            [
                'name' => 'Phân bón lá Bamboo Magie Kẽm',
                'category_id' => 2,
                'price' => 95000,
                'unit' => 'Chai',
                'packaging' => 'Chai 500ml',
                'stock' => 350,
                'description' => '<p><strong>Bamboo MG Kẽm</strong> tăng cường hàm lượng Kẽm vi lượng giúp cây cứng cáp, chống rụng hoa và rụng quả non, thúc đẩy quá trình tổng hợp chất diệp lục hiệu quả.</p>',
                'usage_guide' => '<ul><li><strong>Liều lượng:</strong> Pha 25ml cho bình 25 Lít nước, phun trước khi ra hoa và sau khi đậu trái non định kỳ 7-10 ngày.</li></ul>',
                'images' => ['products/bamboo_mgkem.jpg']
            ]
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'name' => $p['name'],
                    'category_id' => $p['category_id'],
                    'brand_id' => $brand->id,
                    'price' => $p['price'],
                    'unit' => $p['unit'],
                    'packaging' => $p['packaging'],
                    'stock' => $p['stock'],
                    'description' => $p['description'],
                    'usage_guide' => $p['usage_guide'],
                    'status' => 1,
                    'images' => $p['images']
                ]
            );
        }
    }
}
