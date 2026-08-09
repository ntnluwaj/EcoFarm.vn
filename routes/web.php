<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Hệ Thống Định Tuyến Đồ Án Vật Tư Nông Nghiệp Mekong B2B
|--------------------------------------------------------------------------
*/

// 🌟 [HỆ THỐNG]: ĐƯỜNG DẪN XÁC THỰC TÀI KHOẢN (ĐĂNG NHẬP / ĐĂNG KÝ)
Route::get('/login', [\App\Http\Controllers\Frontend\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Frontend\LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [\App\Http\Controllers\Frontend\LoginController::class, 'logout'])->name('frontend.logout');
Route::get('/register', [\App\Http\Controllers\Frontend\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Frontend\RegisterController::class, 'register']);

// 🌟 1. PHÂN HỆ TRANG CHỦ (PRD mục 7.1)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🌟 2. PHÂN HỆ QUẢN LÝ VẬT TƯ & SẢN PHẨM (PRD mục 7.1)
Route::get('/gioi-thieu', function () {
    return view('frontend.about');
})->name('about');
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/so-sanh', [ProductController::class, 'compare'])->name('products.compare');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/san-pham/{slug}/danh-gia', [ProductController::class, 'storeReview'])->name('products.storeReview');
Route::post('/san-pham/{slug}/hoi-dap', [ProductController::class, 'storeQuestion'])->name('products.storeQuestion');

// 🌟 3. PHÂN HỆ GIỎ HÀNG, ÁP GIÁ SỈ & ĐẶT HÀNG (PRD mục 5 & 7.1)
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::get('/thanh-toan', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/thanh-toan/dat-hang', [CartController::class, 'storeOrder'])->name('cart.storeOrder');
Route::post('/cart/add/{slug}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/api/vouchers/apply', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// 🌟 4. NGHIỆP VỤ TRA CỨU VẬN ĐƠN & LỊCH SỬ MUA HÀNG (UC-03)
Route::get('/tra-cuu-don-hang', [CartController::class, 'trackOrder'])->name('orders.track');

// ĐỒNG BỘ: Đổi tên thành cart.history để khớp 100% với file success.blade.php bên ngoài
Route::get('/lich-su-don-hang', [CartController::class, 'orderHistory'])->name('cart.history');



// 🌟 5. LIÊN HỆ & TƯ VẤN KỸ THUẬT (BI-DIRECTIONAL CONTACT)
Route::get('/lien-he', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he/gui', [\App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store');

// 🌟 7. KHỐI BẢO MẬT: CHỈ TÀI KHOẢN ADMIN ĐƯỢC PHÉP TRUY CẬP (UC-09)
Route::middleware(['admin.role'])->group(function () {
    // Trang xem báo cáo tổng hợp nội bộ bãi kho của Admin
    Route::get('/admin/bao-cao-doanh-thu', [\App\Http\Controllers\Backend\ReportController::class, 'index'])->name('admin.reports');

    // 🌟 PHÂN HỆ HỆ THỐNG QUẢN LÝ CRM CAO CẤP (KHỚP 100% ẢNH MẪU 1, 2, 3)
    Route::get('/admin/crm/tong-quan', [\App\Http\Controllers\Backend\CRMManagementController::class, 'dashboard'])->name('admin.crm.dashboard');
    Route::get('/admin/crm/khach-hang', [\App\Http\Controllers\Backend\CRMManagementController::class, 'customers'])->name('admin.crm.customers');
    Route::get('/admin/crm/deal-da-chot', [\App\Http\Controllers\Backend\CRMManagementController::class, 'deals'])->name('admin.crm.deals');
    Route::get('/admin/orders/{id}/print', [\App\Http\Controllers\Frontend\CartController::class, 'printOrder'])->name('admin.orders.print');
    Route::get('/admin/orders/report/print', [\App\Http\Controllers\Frontend\CartController::class, 'printRevenueReport'])->name('admin.reports.print');
    Route::get('/admin/debug/logs', function() {
        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) {
            return "No log file found.";
        }
        $logs = file_get_contents($logPath);
        return '<pre>' . htmlspecialchars(substr($logs, -10000)) . '</pre>';
    });

    // 🌟 PHÂN HỆ GIẢ LẬP SANDBOX (KIỂM THỬ TỰ ĐỘNG HÓA LOCAL - CHỈ ADMIN TRUY CẬP)
    Route::get('/sandbox/debug', [\App\Http\Controllers\Frontend\SandboxController::class, 'index'])->name('sandbox.index');
    Route::post('/sandbox/pay-simulate', [\App\Http\Controllers\Frontend\SandboxController::class, 'paySimulate'])->name('sandbox.paySimulate');
    Route::post('/sandbox/pay-custom-simulate', [\App\Http\Controllers\Frontend\SandboxController::class, 'payCustomSimulate'])->name('sandbox.payCustomSimulate');
    Route::post('/sandbox/ship-simulate', [\App\Http\Controllers\Frontend\SandboxController::class, 'shipSimulate'])->name('sandbox.shipSimulate');
});


Route::middleware(['auth'])->group(function () {
    // Tuyến đường cho khách tự hủy đơn hàng khi chưa xác nhận
    Route::post('/don-hang/{id}/huy-don', [CartController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/don-hang/{id}/cap-nhat-thong-tin', [CartController::class, 'updateOrderInfo'])->name('orders.updateInfo');
    Route::get('/thong-bao/danh-dau-da-doc', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc!');
    })->name('notifications.readAll');
    Route::get('/thong-bao/{id}', [\App\Http\Controllers\Frontend\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/thong-bao/{id}/unread', [\App\Http\Controllers\Frontend\NotificationController::class, 'markAsUnread'])->name('notifications.markAsUnread');
    
    // Quản lý thông tin tài khoản cá nhân và lưu địa chỉ mặc định
    Route::get('/tai-khoan', [\App\Http\Controllers\Frontend\UserController::class, 'profile'])->name('profile.index');
    Route::post('/tai-khoan/cap-nhat', [\App\Http\Controllers\Frontend\UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/tai-khoan/voucher', [\App\Http\Controllers\Frontend\UserController::class, 'vouchers'])->name('profile.vouchers');

    // Phân hệ Tích điểm & Đổi quà cho Nhà nông
    Route::get('/tich-diem', [\App\Http\Controllers\Frontend\RewardController::class, 'index'])->name('rewards.index');
    Route::post('/tich-diem/redeem', [\App\Http\Controllers\Frontend\RewardController::class, 'redeem'])->name('rewards.redeem');
});


// 🌟 8. PHÂN HỆ CẨM NĂNG KỸ THUẬT CANH TÁC & LỊCH MÙA VỤ (PRD mục 7.1)
Route::get('/cam-nang', [\App\Http\Controllers\Frontend\PostController::class, 'index'])->name('posts.index');
Route::get('/quan-ly-sau-benh', [\App\Http\Controllers\Frontend\PostController::class, 'pestManagement'])->name('posts.pestManagement');
Route::get('/ky-thuat-canh-tac', [\App\Http\Controllers\Frontend\PostController::class, 'farmingTechniques'])->name('posts.farmingTechniques');
Route::get('/tin-tuc-nong-nghiep', [\App\Http\Controllers\Frontend\PostController::class, 'news'])->name('posts.news');
Route::get('/cam-nang/{slug}', [\App\Http\Controllers\Frontend\PostController::class, 'show'])->name('posts.show');

// 🌟 9. TỰ ĐỘNG HÓA WEBHOOKS (DÒNG TIỀN & VẬN CHUYỂN)
Route::post('/api/payment/sepay-webhook', [\App\Http\Controllers\Api\PaymentWebhookController::class, 'sepayWebhook']);
Route::post('/api/shipping/ghn-webhook', [\App\Http\Controllers\Api\ShippingWebhookController::class, 'ghnWebhook']);

// 🌟 11. ĐƯỜNG DẪN YÊU CẦU GỌI ĐIỆN TƯ VẤN (AJAX CALL SIMULATOR)
Route::post('/lien-he/yeu-cau-goi-dien', [\App\Http\Controllers\Frontend\ContactController::class, 'storeCallRequest'])->name('contact.storeCallRequest');

// 🌟 12. ĐƯỜNG DẪN TRỢ LÝ ẢO AI ECOBOT TƯ VẤN NÔNG HỌC
Route::post('/api/ai/chat', [\App\Http\Controllers\Frontend\AIAdvisorController::class, 'chat'])->name('ai.chat');

// 🌟 13. CÁC TRANG CHÍNH SÁCH VÀ ĐIỀU KHOẢN
Route::view('/chinh-sach-giao-hang', 'frontend.policies.shipping')->name('policies.shipping');
Route::view('/chinh-sach-doi-tra', 'frontend.policies.returns')->name('policies.returns');
Route::view('/chinh-sach-bao-mat', 'frontend.policies.privacy')->name('policies.privacy');
Route::view('/dieu-khoan-dich-vu', 'frontend.policies.terms')->name('policies.terms');

// 🌟 14. KHÔI PHỤC BẢNG SESSIONS NẾU BỊ THIẾU
Route::get('/fix-database-sessions', function () {
    if (!\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
        \Illuminate\Support\Facades\Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        return "Bảng sessions đã được tạo lại thành công!";
    }
    return "Bảng sessions đã tồn tại sẵn!";
});