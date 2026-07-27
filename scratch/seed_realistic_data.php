<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\ProductReview;
use App\Models\ProductQuestion;
use App\Models\Contact;
use Carbon\Carbon;

echo "Bat dau khoi tao du lieu thuc te cho toan bo he thong...\n";

// 1. Chay seeder goc de dam bao co du lieu nen
$seeder = new \Database\Seeders\DatabaseSeeder();
$seeder->run();

// 1b. Them Thuong hieu va San pham moi
$brandCaMau = \App\Models\Brand::firstOrCreate(
    ['slug' => 'phan-bon-ca-mau'],
    ['name' => 'Phan bon Ca Mau', 'description' => 'Thuong hieu phan bon cao cap cua Cong ty Co phan Phan bon Dau khi Ca Mau.']
);

$brandLocTroi = \App\Models\Brand::firstOrCreate(
    ['slug' => 'tap-doan-loc-troi'],
    ['name' => 'Tap doan Loc Troi', 'description' => 'Tap doan dich vu nong nghiep hang dau Viet Nam ve hat giong va bao ve thuc vat.']
);

$catPhanBon = \App\Models\Category::where('slug', 'phan-bon-huu-co-va-npk')->first();
$catThuoc = \App\Models\Category::where('slug', 'thuoc-tru-sau-va-benh')->first();
$brandSyngenta = \App\Models\Brand::where('slug', 'syngenta-viet-nam')->first();

// San pham 5: Phan bon NPK Ca Mau
$prodNPKCM = \App\Models\Product::updateOrCreate(
    ['slug' => 'phan-bon-npk-ca-mau-20-20-15-cao-cap'],
    [
        'name' => 'Phan bon NPK Ca Mau 20-20-15 Cao Cap',
        'category_id' => $catPhanBon->id,
        'brand_id' => $brandCaMau->id,
        'price' => 830000,
        'unit' => 'Bao',
        'packaging' => 'Bao 50kg chinh hang',
        'stock' => 400,
        'status' => true,
        'description' => '<p><strong>NPK Ca Mau 20-20-15</strong> cung cap dinh duong Da luong can doi giup lua de nhanh khoe, tang suc de khang va han he do nga mua mua.</p>',
        'usage_guide' => '<p>Bon thuc dot 2 va dot 3 voi luong 150-200 kg/ha tuy tho nhuong.</p>',
        'images' => ['products/ure_phumy_front.png']
    ]
);
if ($prodNPKCM->variants()->count() === 0) {
    $prodNPKCM->variants()->create([
        'capacity' => 'Bao 50kg', 'price' => 830000, 'stock' => 400
    ]);
}

// San pham 6: Hat giong lua OM 5451 Loc Troi
$prodLuaOM = \App\Models\Product::updateOrCreate(
    ['slug' => 'hat-giong-lua-om-5451-loc-troi'],
    [
        'name' => 'Hat giong lua OM 5451 Loc Troi',
        'category_id' => $catPhanBon->id,
        'brand_id' => $brandLocTroi->id,
        'price' => 620000,
        'unit' => 'Bao',
        'packaging' => 'Bao 40kg nguyen dai',
        'stock' => 250,
        'status' => true,
        'description' => '<p><strong>Hat giong lua OM 5451</strong> do Loc Troi cung ung co ty le nay mam cao, de nhanh khoe, khang ray nau va dao on tot, cho chat luong gao xuat khau hat dai trong suot.</p>',
        'usage_guide' => '<p>Ngam u 24-36 gio truoc khi gieo sa. Mat do gieo sa khuyen cao 80-100 kg/ha.</p>',
        'images' => ['products/ure_phumy_granules.png']
    ]
);
if ($prodLuaOM->variants()->count() === 0) {
    $prodLuaOM->variants()->create([
        'capacity' => 'Bao 40kg', 'price' => 620000, 'stock' => 250
    ]);
}

// San pham 7: Thuoc tru ray Chess 50WG Syngenta
$prodChess = \App\Models\Product::updateOrCreate(
    ['slug' => 'thuoc-tru-ray-chess-50wg-syngenta'],
    [
        'name' => 'Thuoc tru ray Chess 50WG Syngenta',
        'category_id' => $catThuoc->id,
        'brand_id' => $brandSyngenta ? $brandSyngenta->id : 1,
        'price' => 180000,
        'unit' => 'Hop',
        'packaging' => 'Hop 10 goi x 7.5g',
        'stock' => 350,
        'status' => true,
        'description' => '<p><strong>Chess 50WG</strong> ngan chan ray nau chich hut lap tuc nho co che tac dong doc dao. Ray ngung an va chet doi sau do.</p>',
        'usage_guide' => '<p>Pha 1 goi 7.5g cho binh 25 Lit nuoc. Phun khi ray cam chom xuat hien.</p>',
        'images' => ['products/regent_front.png']
    ]
);
if ($prodChess->variants()->count() === 0) {
    $prodChess->variants()->create([
        'capacity' => 'Hop 10 goi', 'price' => 180000, 'stock' => 350
    ]);
}
// San pham 8: Thuoc kich thich sinh truong Atonik 1.8SL
$prodAtonik = \App\Models\Product::updateOrCreate(
    ['slug' => 'thuoc-kich-thich-sinh-truong-atonik-1-8sl'],
    [
        'name' => 'Thuoc kich thich sinh truong Atonik 1.8SL',
        'category_id' => $catThuoc->id,
        'brand_id' => $brandLocTroi->id,
        'price' => 95000,
        'unit' => 'Chai',
        'packaging' => 'Hop 10 chai x 10ml',
        'stock' => 500,
        'status' => true,
        'description' => '<p><strong>Atonik 1.8SL</strong> la thuoc kich thich sinh truong cay trong the he moi, giup tang kha nang nay mam, ra re, nang cao suc de khang va chat luong nong san.</p>',
        'usage_guide' => '<p>Pha 10ml cho binh 16-25 Lit nuoc, phun deu len la o cac giai doan sinh truong cua cay.</p>',
        'images' => [
            'products/atonik_front.jpg',
            'products/atonik_pack.jpg',
            'products/01KVPMJYZ4359ADFXMGTPSV690.jpg'
        ]
    ]
);
if ($prodAtonik->variants()->count() === 0) {
    $prodAtonik->variants()->createMany([
        ['capacity' => 'Chai 10ml', 'price' => 12000, 'stock' => 200],
        ['capacity' => 'Hop 10 chai', 'price' => 95000, 'stock' => 300],
    ]);
}

// San pham 9: Phan huu co vi sinh Tricho-Mix
$prodTricho = \App\Models\Product::updateOrCreate(
    ['slug' => 'phan-huu-co-vi-sinh-tricho-mix'],
    [
        'name' => 'Phan huu co vi sinh Tricho-Mix',
        'category_id' => $catPhanBon->id,
        'brand_id' => \App\Models\Brand::where('slug', 'phan-bon-binh-dien')->first()->id ?? 2,
        'price' => 120000,
        'unit' => 'Bao',
        'packaging' => 'Bao 10kg nguyen tem',
        'stock' => 600,
        'status' => true,
        'description' => '<p><strong>Phan huu co vi sinh Tricho-Mix</strong> chua nam doi khang Trichoderma giup phan huy nhanh xac ba thuc vat, cai tao dat va ngua nam benh thoi re.</p>',
        'usage_guide' => '<p>Bon lot hoac bon thuc quanh goc 1-2kg cho moi cay an trai, hoac 500-1000kg/ha cho ruong lua.</p>',
        'images' => [
            'products/01KVPMJZ06P8VG3AR82WYTT19C.jpg',
            'products/01KVPMJZ0A0CFQ28EBWV622VZT.png',
            'products/ure_phumy_field.png'
        ]
    ]
);
if ($prodTricho->variants()->count() === 0) {
    $prodTricho->variants()->create([
        'capacity' => 'Bao 10kg', 'price' => 120000, 'stock' => 600
    ]);
}

// San pham 10: Thuoc tru nam benh Coc 85
$prodCoc85 = \App\Models\Product::updateOrCreate(
    ['slug' => 'thuoc-tru-nam-benh-coc-85'],
    [
        'name' => 'Thuoc tru nam benh Coc 85',
        'category_id' => $catThuoc->id,
        'brand_id' => \App\Models\Brand::where('slug', 'bayer-cropscience')->first()->id ?? 4,
        'price' => 35000,
        'unit' => 'Goi',
        'packaging' => 'Goi 20g tien dung',
        'stock' => 800,
        'status' => true,
        'description' => '<p><strong>Coc 85</strong> la thuoc phong tru nam benh va diet khuan tu goc dong, co tac dung noi hap, tieu diet mam benh than thu, suong mai va ri sat tren cay an trai.</p>',
        'usage_guide' => '<p>Pha 20g cho binh 16 Lit nuoc, phun uot deu than la khi benh moi xuat hien.</p>',
        'images' => [
            'products/01KVPNA4YH6B1BGPC8A0NWTHD3.png',
            'products/regent_spraying.png',
            'products/regent_front.png'
        ]
    ]
);
if ($prodCoc85->variants()->count() === 0) {
    $prodCoc85->variants()->create([
        'capacity' => 'Goi 20g', 'price' => 35000, 'stock' => 800
    ]);
}

// 2. Them cac tai khoan nong dan va dai ly bo sung voi thong tin dia chi cu the
$farmerNames = [
    'Tran Van Muoi', 'Le Thi Ut', 'Phan Van Sau', 'Nguyen Thi Hoa', 'Huynh Van Bay', 'Dang Thi Lan'
];
$farmerPhones = [
    '0939123456', '0949123456', '0919123456', '0989123456', '0979123456', '0969123456'
];
$farmerEmails = [
    'tranvanmuoi@gmail.com', 'lethiut@gmail.com', 'phanvansau@gmail.com', 'nguyenthihoa@gmail.com', 'huynhvanbay@gmail.com', 'dangthilan@gmail.com'
];
$farmerAddresses = [
    'Ap 1, Xa Trung An, Co Do, Can Tho',
    'Khu vuc Thoi Hoa, Phuong Thoi An, O Mon, Can Tho',
    'Xa Vinh Binh, Huyen Chau Thanh, An Giang',
    'Ap My Loc, Xa My Khanh, Phong Dien, Can Tho',
    'Xa Hoa Tu 1, Huyen My Xuyen, Soc Trang',
    'Thi tran Bay Ngan, Huyen Chau Thanh A, Hau Giang'
];

$createdFarmers = [];
foreach ($farmerNames as $index => $name) {
    $createdFarmers[] = User::updateOrCreate(
        ['email' => $farmerEmails[$index]],
        [
            'name' => $name,
            'password' => bcrypt('12345678'),
            'role' => 'customer',
            'phone' => $farmerPhones[$index],
            'address' => $farmerAddresses[$index],
            'reward_points' => rand(100, 300)
        ]
    );
}

// 3. Tao mot so Don hang thuc te voi cac lua chon thanh toan va trang thai van don phan loai
$products = Product::all();
$paymentMethods = ['cod', 'vietqr'];

// Xoa sach don hang cu de tranh trung lap rac du lieu
Order::query()->delete();
\Illuminate\Support\Facades\DB::table('order_items')->truncate();
\Illuminate\Support\Facades\DB::table('order_logs')->truncate();
PointTransaction::query()->delete();

echo "Bat dau sinh don hang mau...\n";

// Tao 12 don hang rai rac trong 15 ngay qua de bieu do doanh thu hien thi dep mat
for ($i = 1; $i <= 12; $i++) {
    $farmer = $createdFarmers[array_rand($createdFarmers)];
    $date = Carbon::now()->subDays(15 - $i)->subHours(rand(1, 10));
    
    $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
    
    // Phan bo cac trang thai don hang theo ty le phu hop
    if ($i <= 6) {
        $status = 'completed';
        $paymentStatus = 'paid';
    } elseif ($i <= 8) {
        $status = 'shipping';
        $paymentStatus = $paymentMethod === 'vietqr' ? 'paid' : 'unpaid';
    } elseif ($i <= 10) {
        $status = 'processing';
        $paymentStatus = $paymentMethod === 'vietqr' ? 'paid' : 'unpaid';
    } elseif ($i === 11) {
        $status = 'pending';
        $paymentStatus = 'unpaid';
    } else {
        $status = 'cancelled';
        $paymentStatus = 'unpaid';
    }
    
    $order = Order::create([
        'user_id' => $farmer->id,
        'customer_name' => $farmer->name,
        'customer_phone' => $farmer->phone,
        'customer_email' => $farmer->email,
        'shipping_address' => $farmer->address,
        'total_amount' => 0, // se cap nhat o phia duoi
        'coupon_code' => null,
        'discount_amount' => 0,
        'payment_method' => $paymentMethod,
        'payment_status' => $paymentStatus,
        'status' => $status,
        'created_at' => $date,
        'updated_at' => $date
    ]);
    
    // Them tu 1 den 3 san pham vat tu vao tung hoa don
    $numItems = rand(1, 3);
    $selectedProducts = $products->random($numItems);
    $total = 0;
    
    foreach ($selectedProducts as $prod) {
        $variant = $prod->variants->first();
        $qty = rand(1, 5);
        $price = $variant ? $variant->price : $prod->price;
        $subtotal = $price * $qty;
        $total += $subtotal;
        
        $order->items()->create([
            'product_id' => $prod->id,
            'product_variant_id' => $variant ? $variant->id : null,
            'quantity' => $qty,
            'unit_price' => $price,
            'price_type' => 'retail',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
    
    // Cap nhat lai tong tien don hang thuc te
    $order->update(['total_amount' => $total]);
    
    // Ghi nhan lich su tien do don hang vao bang order_logs
    $order->orderLogs()->create([
        'status' => 'pending',
        'created_at' => $date->copy()->subMinutes(30)
    ]);
    
    if ($status !== 'pending') {
        $order->orderLogs()->create([
            'status' => 'processing',
            'created_at' => $date->copy()->subMinutes(15)
        ]);
    }
    if (in_array($status, ['shipping', 'completed'])) {
        $order->orderLogs()->create([
            'status' => 'shipping',
            'created_at' => $date->copy()->subMinutes(5)
        ]);
    }
    if ($status === 'completed') {
        $order->orderLogs()->create([
            'status' => 'completed',
            'created_at' => $date
        ]);
        
        // Tu dong tich diem thuong va viet nhat ky giao dich diem cho khach hang
        $pointsEarned = floor($total / 10000);
        if ($pointsEarned > 0) {
            $farmer->increment('reward_points', $pointsEarned);
            $farmer->pointTransactions()->create([
                'points' => $pointsEarned,
                'transaction_type' => 'earn',
                'description' => "Tich diem tu don hang ECF" . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'created_at' => $date
            ]);
        }
    }
    if ($status === 'cancelled') {
        $order->orderLogs()->create([
            'status' => 'cancelled',
            'created_at' => $date
        ]);
    }
}
echo "Da tao xong 12 don hang mau voi day du nhat ky giao dich va tich diem thuong.\n";

// 4. Khoi tao Danh gia san pham mau tu ba con (Product Reviews)
ProductReview::query()->delete();
$reviewsData = [
    [
        'product_slug' => 'thuoc-tru-benh-anvil-5sc-syngenta',
        'reviews' => [
            ['name' => 'Chu Bay Doi', 'rating' => 5, 'comment' => 'Thuoc Anvil cua Syngenta xit rat em, tri lem lep hat va vang la lua cuc ky hieu qua. Lua nam nay chac hat, dat nang suat cao.'],
            ['name' => 'Ut Tich', 'rating' => 4, 'comment' => 'Hang chinh hang bayer va syngenta, dong goi rat ky cang, bưu ta giao hang rat le phep va nhiet tinh. Se ung ho lau dai.'],
        ]
    ],
    [
        'product_slug' => 'phan-bon-npk-dau-trau-20-20-15-cao-cap',
        'reviews' => [
            ['name' => 'Nam Ruong', 'rating' => 5, 'comment' => 'Phan dau trau 20-20-15 rat chat luong, hat tron deu mau, lua no bui nhanh la xanh muot ben lau.'],
            ['name' => 'Anh Ba Khia', 'rating' => 4, 'comment' => 'Dung de bon phan cho cay sau rieng vuon nha dam choi non rat khoe, cay nhanh lon phat trien tot.'],
        ]
    ],
    [
        'product_slug' => 'phan-bon-ure-phu-my-hat-trong',
        'reviews' => [
            ['name' => 'Chu Chin Co', 'rating' => 5, 'comment' => 'Dam Phu My hat trong nhanh tan, rat thich hop de bon thuc lua xanh nhanh sau mua bao bi ngap ung.'],
        ]
    ],
    [
        'product_slug' => 'thuoc-tru-sau-regent-800wg-bayer',
        'reviews' => [
            ['name' => 'Tu Sach', 'rating' => 5, 'comment' => 'Thuoc tri sau cuon la va ray nau cuc ky hieu qua. Xit mot dot la sach bong sau hai.'],
        ]
    ]
];

foreach ($reviewsData as $data) {
    $prod = Product::where('slug', $data['product_slug'])->first();
    if ($prod) {
        foreach ($data['reviews'] as $rev) {
            ProductReview::create([
                'product_id' => $prod->id,
                'reviewer_name' => $rev['name'],
                'rating' => $rev['rating'],
                'comment' => $rev['comment'],
                'created_at' => Carbon::now()->subDays(rand(1, 10))
            ]);
        }
    }
}
echo "Da tao xong danh sach danh gia san pham tu khach hang.\n";

// 5. Khoi tao cac cau hoi dap ky thuat nong hoc (Product Q&As)
ProductQuestion::query()->delete();
$qaData = [
    [
        'product_slug' => 'thuoc-tru-benh-anvil-5sc-syngenta',
        'question' => 'Thuoc nay phun giai doan lua dang tro deu co anh huong gi khong ky su?',
        'answer' => 'Chao ba con, Anvil 5SC hoan toan an toan khi phun o giai doan lua lam dong tro xet hoac tro deu. Ba con chu y xit dung lieu luong huong dan de dat hieu qua bao ve hat gieo tot nhat nhe.'
    ],
    [
        'product_slug' => 'phan-bon-npk-dau-trau-20-20-15-cao-cap',
        'question' => 'Loai phan bon nay dung cho cay sau rieng giai doan dang nuoi trai co tot khong?',
        'answer' => 'Chao ba con, phan boun NPK 20-20-15 rat phu hop cho giai doan kien thiet co ban hoac phuc hoi sau thu hoach. Doi voi giai doan dang nuoi trai lon, ba con nen su dung dong phan bon co kali cao hon nhu dau trau nuoi trai de dat nang suat tot nhat.'
    ]
];

foreach ($qaData as $qa) {
    $prod = Product::where('slug', $qa['product_slug'])->first();
    if ($prod) {
        ProductQuestion::create([
            'product_id' => $prod->id,
            'asker_name' => 'Nha vuon mien Tay',
            'question' => $qa['question'],
            'answer' => $qa['answer'],
            'created_at' => Carbon::now()->subDays(rand(1, 5))
        ]);
    }
}
echo "Da tao xong danh sach hoi dap ky thuat nong nghiep.\n";

// 6. Khoi tao tin nhan lien he tu van tu khach hang (Contacts)
Contact::query()->delete();
$contacts = [
    [
        'name' => 'Phan Van Ut',
        'phone' => '0939121212',
        'email' => 'phanvanut@gmail.com',
        'subject' => 'Hoi ve giai phap cải tao dat nhiem phen nang',
        'message' => 'Chao ky su, dat ruong o mien tay nha toi dang bi nhiem phen sat rat nang, vu lua vua roi bi nghet re va vang la dong loat. Xin hoi co loai phan bon nao giup ha phen khong?',
        'reply_content' => 'Chao chu Ut, de ha phen dat ruong chú nen bon rai voi bot va lam dat thong thoang truoc khi gieo, sau do tang cuong bon thuc lan super hoac phan huu co sinh hoc. Ky su da chu dong lien he dien thoai cua chu de tu van truc tiep chi tiet hon.',
        'status' => 'replied'
    ],
    [
        'name' => 'Le Thi Mo',
        'phone' => '0949151515',
        'email' => 'lethimo@gmail.com',
        'subject' => 'Hoi ve benh than thu o cay sau rieng',
        'message' => 'La cay sau rieng vuon nha toi xuat hien nhieu dom chay kho mau xam lan rong, xin hoi co phai bi benh than thu khong va cach phun thuoc nao hieu qua?',
        'reply_content' => null,
        'status' => 'pending'
    ]
];

foreach ($contacts as $c) {
    Contact::create(array_merge($c, [
        'created_at' => Carbon::now()->subDays(rand(1, 4))
    ]));
}
echo "Da tao xong danh sach lien he tu van.\n";

// 7. Them cam nang va tin tuc moi
\App\Models\Post::updateOrCreate(
    ['slug' => 'ky-thuat-phong-tru-sau-duc-than-hai-lua-mua-thu-dong'],
    [
        'title' => 'Ky thuat phong tru sau duc than hai lua mua Thu Dong',
        'category' => 'Quan ly sau benh hai',
        'thumbnail' => 'products/regent_spraying.png',
        'content' => '<p>Sau duc than la dich hai nguy hiem anh huong truc tiep toi nang suat bong lua. Ky su khuyen cao ba con theo doi sat buom sau duc than no ro de phun phong tru bang Regent 800WG kip thoi.</p>',
        'published_at' => now(),
    ]
);

\App\Models\Post::updateOrCreate(
    ['slug' => 'huong-dan-bon-phan-ca-mau-cho-cay-an-trai-giai-doan-ra-hoa-ket-trai'],
    [
        'title' => 'Huong dan bon phan Ca Mau cho cay an trai giai doan ra hoa ket trai',
        'category' => 'Ky thuat canh tac',
        'thumbnail' => 'products/ure_phumy_field.png',
        'content' => '<p>Bon phan NPK Ca Mau giup cay an trai ra hoa dong loat, tang ty le dau qua va nuoi duong trai to tron, han che rung qua sinh ly hieu qua.</p>',
        'published_at' => now(),
    ]
);

\App\Models\Post::updateOrCreate(
    ['slug' => 'bien-phap-quan-ly-dich-ray-phan-trang-hai-san-khoai-mi'],
    [
        'title' => 'Bien phap quan ly dich ray phan trang hai san khoai mi',
        'category' => 'Quan ly sau benh hai',
        'thumbnail' => 'banners/banner_canhtac.png',
        'content' => '<p>Ray phan trang truyen benh kham la hai san gay that thu nghiem trong. Ba con can phun tru ray bang Chess 50WG cua Syngenta quanh vung trong de tieu diet triet de nguon benh.</p>',
        'published_at' => now(),
    ]
);

// Cap nhat cac bai viet tu DatabaseSeeder sang category moi phu hop
\App\Models\Post::where('slug', 'giai-phap-phong-ngua-nam-benh-ri-sat-tren-cay-sau-rieng-mua-mua-lu')
    ->update(['category' => 'Quan ly sau benh hai']);

\App\Models\Post::where('slug', 'lich-xuong-giong-mua-vu-thu-dong-2026-khu-vuc-mien-tay')
    ->update(['category' => 'Tin tuc nong nghiep']);

echo "Da tao xong cam nang va tin tuc moi.\n";

// 8. Tao cac ma giam gia cong cong (Vouchers)
$prodLuaOM = \App\Models\Product::where('slug', 'hat-giong-lua-om-5451-loc-troi')->first();
$prodNPKCM = \App\Models\Product::where('slug', 'phan-bon-npk-ca-mau-20-20-15-cao-cap')->first();

\App\Models\Voucher::updateOrCreate(
    ['code' => 'GIAMGIATUDONG'],
    [
        'type' => 'percent',
        'value' => 5,
        'min_order_amount' => 100000,
        'max_uses' => 500,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => null,
        'user_id' => null,
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

\App\Models\Voucher::updateOrCreate(
    ['code' => 'CHAOHE2026'],
    [
        'type' => 'fixed',
        'value' => 30000,
        'min_order_amount' => 150000,
        'max_uses' => 300,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => null,
        'user_id' => null,
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

if ($prodLuaOM) {
    \App\Models\Voucher::updateOrCreate(
        ['code' => 'LOCATROIFAN'],
        [
            'type' => 'percent',
            'value' => 10,
            'min_order_amount' => 200000,
            'max_uses' => 200,
            'uses' => 0,
            'is_active' => true,
            'points_cost' => null,
            'user_id' => null,
            'product_id' => $prodLuaOM->id,
            'expires_at' => '2027-12-31 00:00:00',
        ]
    );
}
echo "Da tao xong cac ma giam gia cong cong.\n";

// 9. Tao them cac qua tang doi diem (Kho qua tang)
\App\Models\Voucher::updateOrCreate(
    ['code' => 'GIFT-20K'],
    [
        'type' => 'fixed',
        'value' => 20000,
        'min_order_amount' => 100000,
        'max_uses' => 100,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => 40,
        'user_id' => null,
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

\App\Models\Voucher::updateOrCreate(
    ['code' => 'GIFT-150K'],
    [
        'type' => 'fixed',
        'value' => 150000,
        'min_order_amount' => 500000,
        'max_uses' => 50,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => 250,
        'user_id' => null,
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

if ($prodNPKCM) {
    \App\Models\Voucher::updateOrCreate(
        ['code' => 'GIFT-NPKCM'],
        [
            'type' => 'percent',
            'value' => 15,
            'min_order_amount' => 300000,
            'max_uses' => 80,
            'uses' => 0,
            'is_active' => true,
            'points_cost' => 120,
            'user_id' => null,
            'product_id' => $prodNPKCM->id,
            'expires_at' => '2027-12-31 00:00:00',
        ]
    );
}
echo "Da tao xong cac qua tang doi diem (Kho qua tang).\n";

echo "Hoan tat! He thong da duoc sinh du lieu thuc te giong het mot trang web dang kinh doanh.\n";
