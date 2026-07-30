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

                    /* 🌟 TOPBAR SOLID WHITE MINIMALIST STYLE */
                    .fi-topbar {
                        background-color: #ffffff !important;
                        border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
                        box-shadow: none !important;
                    }

                    /* 🌟 SIDEBAR CLEAN PURE WHITE STYLE */
                    .fi-sidebar {
                        background-color: #ffffff !important;
                        border-right: 1px solid rgba(0, 0, 0, 0.06) !important;
                    }
                    .fi-sidebar-header {
                        background-color: #ffffff !important;
                        border-bottom: 1px solid rgba(0, 0, 0, 0.04) !important;
                    }

                    /* 🌟 MODERN ACTIVE SIDEBAR MENU ITEM STYLE (SOFT GREEN + LEFT BORDER) */
                    .fi-sidebar-item-button.fi-active,
                    .fi-sidebar-item-button[data-active="1"],
                    .fi-active,
                    [data-active="1"],
                    .fi-sidebar-item-active > a,
                    .fi-sidebar-item-active > div {
                        background-color: rgba(16, 185, 129, 0.08) !important;
                        color: #047857 !important;
                        border-left: 4px solid #10b981 !important;
                        border-radius: 0 0.5rem 0.5rem 0 !important;
                        font-weight: 600 !important;
                        box-shadow: none !important;
                    }

                    /* Keep icons green in active items */
                    .fi-sidebar-item-button.fi-active svg,
                    .fi-active svg,
                    .fi-sidebar-item-active svg {
                        color: #10b981 !important;
                    }

                    /* Inactive items hover styling */
                    .fi-sidebar-item-button:not(.fi-active):hover {
                        background-color: rgba(0, 0, 0, 0.02) !important;
                        border-radius: 0.5rem !important;
                    }

                    /* 🌟 STATS OVERVIEW CARDS */
                    .fi-wi-stats-overview-stat {
                        transition: all 0.2s ease-in-out !important;
                        border: 1px solid rgba(0, 0, 0, 0.04) !important;
                        border-radius: 0.75rem !important;
                        background: #ffffff !important;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
                    }
                    .fi-wi-stats-overview-stat:hover {
                        transform: translateY(-2px) !important;
                        border-color: rgba(16, 185, 129, 0.2) !important;
                        box-shadow: 0 4px 12px 0 rgba(16, 185, 129, 0.08) !important;
                    }

                    /* 🌟 TABLE HOVER EFFECTS & CARD STYLING */
                    .fi-ta-ctn {
                        border: 1px solid rgba(0, 0, 0, 0.05) !important;
                        border-radius: 0.75rem !important;
                        overflow: hidden !important;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
                    }
                    .fi-ta-header-cell {
                        background-color: #fafafa !important;
                        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
                    }
                    .fi-ta-row:hover {
                        background-color: #fdfdfd !important;
                    }

                    /* 🌟 CHARTS CARD STYLING */
                    .fi-wi-widget > .fi-section {
                        border: 1px solid rgba(0, 0, 0, 0.05) !important;
                        border-radius: 0.75rem !important;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
                    }
                </style>'
            )
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => '
                    <div class="flex items-center gap-x-2 me-3">
                        <span class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                            Vai trò: ' . (auth()->user()?->role === 'admin' ? 'Quản trị viên' : (auth()->user()?->role === 'engineer' ? 'Kỹ sư Nông nghiệp' : 'Nhân viên')) . '
                        </span>
                        <a href="/" class="inline-flex items-center gap-x-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/50 hover:bg-emerald-100 transition-all text-xs font-bold shadow-sm">
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