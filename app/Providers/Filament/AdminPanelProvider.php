<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login() // 🌟 GIỮ NGUYÊN dòng này để Filament tự tạo form đăng nhập gốc
            ->authGuard('web') 
            ->homeUrl('/')
            ->databaseNotifications()
            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()
                    ->label('Tài khoản cá nhân')
                    ->url('/tai-khoan')
                    ->icon('heroicon-o-user-circle'),
            ])
            
            ->brandName('EcoFarm Admin')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('5.5rem')
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Danh mục & Sản phẩm',
                'Vận hành & Kho bãi',
                'Khách hàng & Tư vấn',
                'Truyền thông & Marketing',
            ])
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->assets([
                \Filament\Support\Assets\Css::make('admin-custom', asset('css/admin-custom.css?v=' . time())),
            ])
            ->renderHook(
                'panels::head.end',
                fn (): string => '<style>
                    /* Ẩn triệt để tất cả các thanh cuộn dọc/ngang trên mọi trình duyệt */
                    * {
                        scrollbar-width: none !important;
                        -ms-overflow-style: none !important;
                    }
                    *::-webkit-scrollbar {
                        display: none !important;
                        width: 0 !important;
                        height: 0 !important;
                    }
                    html, body, div, section, aside, nav, table, main {
                        scrollbar-width: none !important;
                        -ms-overflow-style: none !important;
                    }
                    html::-webkit-scrollbar, body::-webkit-scrollbar, div::-webkit-scrollbar, section::-webkit-scrollbar, aside::-webkit-scrollbar, nav::-webkit-scrollbar, table::-webkit-scrollbar, main::-webkit-scrollbar {
                        display: none !important;
                        width: 0 !important;
                        height: 0 !important;
                    }
                </style>'
            )
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => '
                    <div class="flex items-center gap-x-3 me-3">
                        <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                            Vai trò: ' . (auth()->user()?->role === 'admin' ? 'Quản trị viên' : (auth()->user()?->role === 'engineer' ? 'Kỹ sư Nông nghiệp' : 'Nhân viên')) . '
                        </span>
                        <a href="/" class="inline-flex items-center gap-x-1.5 px-3.5 py-1.5 rounded-lg border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all text-xs font-bold shadow-sm bg-white">
                            <i class="fa-solid fa-house"></i>
                            <span>Xem trang chủ</span>
                        </a>
                    </div>
                '
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                // 🌟 KÍCH HOẠT MIDDLEWARE CHẶN QUYỀN ĐÃ ĐƯỢC TỐI ƯU CỦA BẠN TẠI ĐÂY
                \App\Http\Middleware\CheckAdminRole::class,
            ]);
    }
}