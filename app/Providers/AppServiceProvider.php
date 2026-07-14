<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Redirect;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production' || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // 🌟 TẠM THỜI: Ép buộc bật debug mode để xem chi tiết lỗi 500 của trang Dashboard quản trị
        config(['app.debug' => true]);
    }
}