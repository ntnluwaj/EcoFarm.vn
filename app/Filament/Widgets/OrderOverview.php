<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    // Cài đặt thời gian tự động làm mới số liệu (sau mỗi 10 giây)
    protected static ?string $pollingInterval = '10s';

    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff', 'engineer']);
    }

    protected function getStats(): array
    {
        $role = auth()->user()?->role;
        $stats = [];

        // Nếu là Kỹ sư nông nghiệp -> Hiển thị số liệu nghiệp vụ chuyên môn
        if ($role === 'engineer') {
            $unansweredQuestions = \App\Models\ProductQuestion::whereNull('answer')->count();
            $pendingConsultations = \App\Models\Contact::where('status', 'pending')->count();
            $publishedPosts = \App\Models\Post::whereNotNull('published_at')->where('published_at', '<=', now())->count();

            $stats[] = Stat::make('Câu hỏi chưa trả lời', $unansweredQuestions . ' câu hỏi')
                ->description('Giải đáp kỹ thuật sản phẩm')
                ->descriptionIcon('heroicon-m-question-mark-circle', IconPosition::Before)
                ->color($unansweredQuestions > 0 ? 'warning' : 'success')
                ->url(\App\Filament\Resources\ProductQuestionResource::getUrl('index'));

            $stats[] = Stat::make('Yêu cầu tư vấn mới', $pendingConsultations . ' cuộc gọi')
                ->description('Cần liên hệ hỗ trợ nông dân')
                ->descriptionIcon('heroicon-m-phone', IconPosition::Before)
                ->color($pendingConsultations > 0 ? 'danger' : 'success')
                ->url(\App\Filament\Resources\ContactResource::getUrl('index'));

            $stats[] = Stat::make('Bài viết cẩm nang', $publishedPosts . ' bài viết')
                ->description('Đã xuất bản trên EcoFarm')
                ->descriptionIcon('heroicon-m-book-open', IconPosition::Before)
                ->color('success')
                ->url(\App\Filament\Resources\PostResource::getUrl('index'));
        } else {
            // 1. Doanh thu hệ thống - Chỉ dành cho admin
            if ($role === 'admin') {
                $revenue = Order::where('status', 'completed')->sum('total_amount');
                $stats[] = Stat::make('Doanh thu hệ thống', number_format($revenue, 0, ',', '.') . ' VND')
                    ->description('Tổng tiền từ đơn hàng hoàn tất')
                    ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                    ->color('success')
                    ->url('/admin/bao-cao-doanh-thu');
            }

            // 2. Đơn hàng chờ duyệt - Admin và Staff đều xem được
            if (in_array($role, ['admin', 'staff'])) {
                $pendingOrders = Order::where('status', 'pending')->count();
                $stats[] = Stat::make('Đơn hàng chờ duyệt', $pendingOrders . ' đơn')
                    ->description('Cần bốc xếp & đóng gói gấp')
                    ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                    ->color($pendingOrders > 0 ? 'warning' : 'gray')
                    ->url(\App\Filament\Resources\OrderResource::getUrl('index'));
            }

            // 3. Đơn hàng đang giao - Chỉ dành cho staff
            if ($role === 'staff') {
                $shippingOrders = Order::where('status', 'shipping')->count();
                $stats[] = Stat::make('Đơn hàng đang giao', $shippingOrders . ' đơn')
                    ->description('Đang vận chuyển đến khách')
                    ->descriptionIcon('heroicon-m-truck', IconPosition::Before)
                    ->color('info')
                    ->url(\App\Filament\Resources\OrderResource::getUrl('index'));
            }

            // 4. Nhà vườn đăng ký - Chỉ dành cho admin
            if ($role === 'admin') {
                $customerCount = User::where('role', 'customer')->count();
                $stats[] = Stat::make('Nhà vườn đăng ký', $customerCount . ' thành viên')
                    ->description('Hệ thống khách mua lẻ')
                    ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                    ->color('info')
                    ->url(\App\Filament\Resources\CustomerResource::getUrl('index'));
            }

            // 4b. Bài viết cẩm nang nông nghiệp chờ duyệt - Chỉ dành cho admin
            if ($role === 'admin') {
                $pendingPostsCount = \App\Models\Post::whereNull('published_at')->count();
                $stats[] = Stat::make('Cẩm nang chờ duyệt', $pendingPostsCount . ' bài viết')
                    ->description('Bài viết kỹ thuật đang đợi duyệt')
                    ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
                    ->color($pendingPostsCount > 0 ? 'warning' : 'success')
                    ->url(\App\Filament\Resources\PostResource::getUrl('index'));
            }

            // 4c. Mã giảm giá / Quà tặng chờ duyệt - Chỉ dành cho admin
            if ($role === 'admin') {
                $pendingVouchersCount = \App\Models\Voucher::where('is_active', false)->count();
                $stats[] = Stat::make('Ưu đãi chờ duyệt', $pendingVouchersCount . ' mã/quà')
                    ->description('Mã giảm giá & Quà tích điểm')
                    ->descriptionIcon('heroicon-m-ticket', IconPosition::Before)
                    ->color($pendingVouchersCount > 0 ? 'warning' : 'success')
                    ->url(\App\Filament\Resources\VoucherResource::getUrl('index'));
            }

            // 4d. Doanh thu COD chờ đối soát - Chỉ dành cho admin
            if ($role === 'admin') {
                $pendingCodAmount = Order::where('payment_method', 'COD')
                    ->where('status', 'completed')
                    ->where('cod_reconciled', false)
                    ->sum('total_amount');
                $stats[] = Stat::make('COD chờ đối soát', number_format($pendingCodAmount, 0, ',', '.') . ' VND')
                    ->description('Tiền thu hộ chưa nhận')
                    ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                    ->color($pendingCodAmount > 0 ? 'warning' : 'success')
                    ->url(\App\Filament\Resources\OrderResource::getUrl('index'));
            }

            // 5. Cảnh báo tồn kho thấp - Chỉ dành cho staff
            if ($role === 'staff') {
                $lowStockCount = \App\Models\Product::where('stock', '<=', 10)
                    ->orWhereHas('variants', fn($q) => $q->where('stock', '<=', 10))
                    ->count();
                $stats[] = Stat::make('Sản phẩm sắp hết hàng', $lowStockCount . ' mặt hàng')
                    ->description('Cần bổ sung kho bãi gấp')
                    ->descriptionIcon('heroicon-m-exclamation-triangle', IconPosition::Before)
                    ->color($lowStockCount > 0 ? 'danger' : 'success')
                    ->url(\App\Filament\Resources\StockResource::getUrl('index'));
            }
        }

        return $stats;
    }
}