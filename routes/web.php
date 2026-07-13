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

// 🌟 [HỆ THỐNG]: ĐƯỜNG DẪN ĐĂNG NHẬP CHÍNH THỨC
// Chuyển hướng /login về form đăng nhập gốc của Filament
Route::redirect('/login', '/admin/login')->name('login');
Route::get('/register', [\App\Http\Controllers\Frontend\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Frontend\RegisterController::class, 'register']);

// 🌟 1. PHÂN HỆ TRANG CHỦ (PRD mục 7.1)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🌟 2. PHÂN HỆ QUẢN LÝ VẬT TƯ & SẢN PHẨM (PRD mục 7.1)
Route::get('/gioi-thieu', function () {
    return view('frontend.about');
})->name('about');
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
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

// 🌟 4. NGHIỆP VỤ TRA CỨU VẬN ĐƠN & LỊCH SỬ MUA HÀNG (UC-03)
Route::get('/tra-cuu-don-hang', [CartController::class, 'trackOrder'])->name('orders.track');

// ĐỒNG BỘ: Đổi tên thành cart.history để khớp 100% với file success.blade.php bên ngoài
Route::get('/lich-su-don-hang', [CartController::class, 'orderHistory'])->name('cart.history');



// 🌟 5. LIÊN HỆ & TƯ VẤN KỸ THUẬT (BI-DIRECTIONAL CONTACT)
Route::get('/lien-he', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he/gui', [\App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store');

// 🌟 6. TUYẾN ĐƯỜNG ĐĂNG XUẤT AN TOÀN CHO FRONTEND
Route::post('/logout-frontend', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Đã đăng xuất tài khoản an toàn!');
})->name('frontend.logout');

// 🌟 7. KHỐI BẢO MẬT: CHỈ TÀI KHOẢN ADMIN ĐƯỢC PHÉP TRUY CẬP (UC-09)
Route::middleware(['admin.role'])->group(function () {
    // Trang xem báo cáo tổng hợp nội bộ bãi kho của Admin
    Route::get('/admin/bao-cao-doanh-thu', [\App\Http\Controllers\Backend\ReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/orders/{id}/print', [\App\Http\Controllers\Frontend\CartController::class, 'printOrder'])->name('admin.orders.print');

    // 🌟 PHÂN HỆ GIẢ LẬP SANDBOX (KIỂM THỬ TỰ ĐỘNG HÓA LOCAL - CHỈ ADMIN TRUY CẬP)
    Route::get('/sandbox/debug', [\App\Http\Controllers\Frontend\SandboxController::class, 'index'])->name('sandbox.index');
    Route::post('/sandbox/pay-simulate', [\App\Http\Controllers\Frontend\SandboxController::class, 'paySimulate'])->name('sandbox.paySimulate');
    Route::post('/sandbox/ship-simulate', [\App\Http\Controllers\Frontend\SandboxController::class, 'shipSimulate'])->name('sandbox.shipSimulate');
});


Route::middleware(['auth'])->group(function () {
    // Tuyến đường cho khách tự hủy đơn hàng khi chưa xác nhận
    Route::post('/don-hang/{id}/huy-don', [CartController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/thong-bao/danh-dau-da-doc', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc!');
    })->name('notifications.readAll');
    
    // Quản lý thông tin tài khoản cá nhân và lưu địa chỉ mặc định
    Route::get('/tai-khoan', [\App\Http\Controllers\Frontend\UserController::class, 'profile'])->name('profile.index');
    Route::post('/tai-khoan/cap-nhat', [\App\Http\Controllers\Frontend\UserController::class, 'updateProfile'])->name('profile.update');
});


// 🌟 8. PHÂN HỆ CẨM NĂNG KỸ THUẬT CANH TÁC & LỊCH MÙA VỤ (PRD mục 7.1)
Route::get('/cam-nang', [\App\Http\Controllers\Frontend\PostController::class, 'index'])->name('posts.index');
Route::get('/cam-nang/{slug}', [\App\Http\Controllers\Frontend\PostController::class, 'show'])->name('posts.show');

// 🌟 9. TỰ ĐỘNG HÓA WEBHOOKS (DÒNG TIỀN & VẬN CHUYỂN)
Route::post('/api/payment/sepay-webhook', [\App\Http\Controllers\Api\PaymentWebhookController::class, 'sepayWebhook']);
Route::post('/api/shipping/ghn-webhook', [\App\Http\Controllers\Api\ShippingWebhookController::class, 'ghnWebhook']);

// 🌟 11. ĐƯỜNG DẪN YÊU CẦU GỌI ĐIỆN TƯ VẤN (AJAX CALL SIMULATOR)
Route::post('/lien-he/yeu-cau-goi-dien', [\App\Http\Controllers\Frontend\ContactController::class, 'storeCallRequest'])->name('contact.storeCallRequest');