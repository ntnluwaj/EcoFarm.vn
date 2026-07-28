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
                ->color($unansweredQuestions > 0 ? 'warning' : 'success');

            $stats[] = Stat::make('Yêu cầu tư vấn mới', $pendingConsultations . ' cuộc gọi')
                ->description('Cần liên hệ hỗ trợ nông dân')
                ->descriptionIcon('heroicon-m-phone', IconPosition::Before)
                ->color($pendingConsultations > 0 ? 'danger' : 'success');

            $stats[] = Stat::make('Bài viết cẩm nang', $publishedPosts . ' bài viết')
                ->description('Đã xuất bản trên EcoFarm')
                ->descriptionIcon('heroicon-m-book-open', IconPosition::Before)
                ->color('success');
        } else {
            // 1. Doanh thu hệ thống - Chỉ dành cho admin
            if ($role === 'admin') {
                $revenue = Order::where('status', 'completed')->sum('total_amount');
                $stats[] = Stat::make('Doanh thu hệ thống', number_format($revenue, 0, ',', '.') . ' VND')
                    ->description('Tổng tiền từ đơn hàng hoàn tất')
                    ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                    ->color('success');
            }

            // 2. Đơn hàng chờ duyệt - Admin và Staff đều xem được
            if (in_array($role, ['admin', 'staff'])) {
                $pendingOrders = Order::where('status', 'pending')->count();
                $stats[] = Stat::make('Đơn hàng chờ duyệt', $pendingOrders . ' đơn')
                    ->description('Cần bốc xếp & đóng gói gấp')
                    ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                    ->color($pendingOrders > 0 ? 'warning' : 'gray');
            }

            // 3. Nhà vườn đăng ký - Chỉ dành cho admin
            if ($role === 'admin') {
                $customerCount = User::where('role', 'customer')->count();
                $stats[] = Stat::make('Nhà vườn đăng ký', $customerCount . ' thành viên')
                    ->description('Hệ thống khách mua lẻ')
                    ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                    ->color('info');
            }
        }

        return $stats;
    }
}