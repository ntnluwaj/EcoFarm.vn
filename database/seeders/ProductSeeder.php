<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Sản phẩm 1: Thuốc trừ bệnh Anvil 5SC (Syngenta)
        Product::create([
            'name' => 'Thuốc trừ bệnh Anvil 5SC Syngenta',
            'slug' => Str::slug('Thuốc trừ bệnh Anvil 5SC Syngenta'),
            'category_id' => 1, // Đảm bảo ID danh mục Thuốc trừ bệnh đã tồn tại
            'brand_id' => 1,    // Đảm bảo ID thương hiệu Syngenta đã tồn tại
            'price' => 220000,   // Giá bán lẻ niêm yết
            'price_wholesale' => 185000, // Giá sỉ cho đại lý
            'unit' => 'Chai',
            'packaging' => 'Thùng 24 chai x 1 Lít',
            'stock' => 150,
            'status' => true,
            'description' => '<p><strong>Anvil 5SC</strong> là thuốc trừ bệnh nội hấp và lưu dẫn mạnh, chuyên trị các loại nấm bệnh phổ biến gây hại nghiêm trọng trên cây trồng.</p><p>Thuốc có khả năng thấm sâu nhanh vào mô cây, cô lập ổ bệnh và bảo vệ phần non mới mọc của cây trồng một cách toàn diện.</p>',
            'usage_guide' => '<ul><li><strong>Đối tượng phòng trừ:</strong> Rỉ sắt, lở cổ rễ trên cà phê; khô vằn, lem lép hạt trên lúa.</li><li><strong>Liều lượng phun tưới:</strong> Pha 20 - 30ml thuốc cho bình 25 Lít nước. Phun ướt đều tán lá khi bệnh mới xuất hiện đầu vụ.</li><li><strong>Thời gian cách ly (PHI):</strong> Ngưng phun thuốc trước khi thu hoạch nông sản ít nhất 14 ngày.</li></ul>',
            // Giả lập mảng chứa nhiều ảnh Slide lưu trong thư mục storage/products/
            'images' => [
                'products/anvil_front.jpg',
                'products/anvil_back.jpg',
                'products/anvil_label.jpg'
            ],
        ]);

        // 2. Sản phẩm 2: Phân bón NPK Đầu Trâu 20-20-15
        Product::create([
            'name' => 'Phân bón NPK Đầu Trâu 20-20-15 Cao Cấp',
            'slug' => Str::slug('Phân bón NPK Đầu Trâu 20-20-15 Cao Cấp'),
            'category_id' => 2, // Đảm bảo ID danh mục Phân bón đã tồn tại
            'brand_id' => 2,    // Đảm bảo ID thương hiệu Bình Điền đã tồn tại
            'price' => 850000,
            'price_wholesale' => 780000,
            'unit' => 'Bao',
            'packaging' => 'Bao 50kg chính hãng',
            'stock' => 500,
            'status' => true,
            'description' => '<p><strong>Phân bón NPK Đầu Trâu 20-20-15</strong> cung cấp nguồn dinh dưỡng Đa - Trung - Vi lượng cân đối và tột đỉnh cho mọi giai đoạn sinh trưởng của cây trồng.</p><p>Giúp cây đâm chồi mạnh, xanh lá, nở bụi nhanh và tăng khả năng chống chịu sâu bệnh thời tiết khắc nghiệt miền Tây.</p>',
            'usage_guide' => '<ul><li><strong>Đối tượng áp dụng:</strong> Cây ăn trái (Sầu riêng, Xoài, Cam sành), lúa vụ Đông Xuân và Hè Thu.</li><li><strong>Cách bón tưới:</strong> Bón thúc định kỳ vào gốc từ 150 - 250kg/ha tùy theo tuổi đời của cây.</li><li><strong>Bảo quản:</strong> Để nơi khô ráo, thoáng mát, bọc kín miệng bao sau khi sử dụng dang dở.</li></ul>',
            'images' => [
                'products/dautrau_front.jpg',
                'products/dautrau_detail.jpg'
            ],
        ]);
    }
}