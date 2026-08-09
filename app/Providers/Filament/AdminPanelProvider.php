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

                    /* 🌟 FRESH BRIGHT BODY BACKGROUND */
                    body, .fi-body, .fi-main {
                        background-color: #f8fafc !important;
                    }

                    /* 🌟 TOPBAR SOLID WHITE & BRANDED GREEN BAR */
                    .fi-topbar {
                        background-color: #ffffff !important;
                        backdrop-filter: none !important;
                        contain: none !important;
                        transform: none !important;
                        border-top: 4px solid #10b981 !important;
                        border-bottom: 1px solid #e2e8f0 !important;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02) !important;
                    }
                    .fi-dropdown-panel {
                        z-index: 99999 !important;
                        border-radius: 14px !important;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
                    }

                    /* 🌟 MODERN SEARCH BAR STYLE */
                    .fi-global-search input,
                    .fi-global-search-input input {
                        border-radius: 0.75rem !important;
                        background-color: #f1f5f9 !important;
                        border: 1px solid #cbd5e1 !important;
                        transition: all 0.2s ease-in-out !important;
                        font-size: 13px !important;
                    }
                    .fi-global-search input:focus,
                    .fi-global-search-input input:focus {
                        background-color: #ffffff !important;
                        border-color: #10b981 !important;
                        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
                    }

                    /* 🌟 SIDEBAR CLEAN PURE WHITE STYLE */
                    .fi-sidebar {
                        background-color: #ffffff !important;
                        border-right: 1px solid #e2e8f0 !important;
                    }
                    .fi-sidebar-header {
                        background-color: #ffffff !important;
                        border-bottom: 1px solid #f1f5f9 !important;
                    }

                    /* 🌟 MODERN ACTIVE SIDEBAR MENU ITEM STYLE (VIBRANT EMERALD) */
                    .fi-sidebar-item-button.fi-active,
                    .fi-sidebar-item-button[data-active="1"],
                    .fi-active,
                    [data-active="1"],
                    .fi-sidebar-item-active > a,
                    .fi-sidebar-item-active > div {
                        background: linear-gradient(90deg, rgba(16, 185, 129, 0.12) 0%, rgba(16, 185, 129, 0.02) 100%) !important;
                        color: #047857 !important;
                        border-left: 4px solid #10b981 !important;
                        border-radius: 0 0.75rem 0.75rem 0 !important;
                        font-weight: 700 !important;
                        box-shadow: none !important;
                    }

                    .fi-sidebar-item-button.fi-active svg,
                    .fi-active svg,
                    .fi-sidebar-item-active svg {
                        color: #10b981 !important;
                    }

                    .fi-sidebar-item-button:not(.fi-active):hover {
                        background-color: #f8fafc !important;
                        border-radius: 0.75rem !important;
                    }

                    /* 🌟 QUICK FILTER TAB PILLS (FRESH BRIGHT BADGES) */
                    .fi-tabs-item-active {
                        background-color: #10b981 !important;
                        color: #ffffff !important;
                        border-radius: 12px !important;
                        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;
                        font-weight: 800 !important;
                    }

                    /* 🌟 CARDS & SECTIONS BRIGHT BORDERS */
                    .fi-section {
                        border-radius: 20px !important;
                        border: 1px solid #e2e8f0 !important;
                        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03) !important;
                        background: #ffffff !important;
                    }

                    /* 🌟 TABLE HOVER EFFECTS & CARD STYLING */
                    .fi-ta-ctn {
                        border: 1px solid #e2e8f0 !important;
                        border-radius: 20px !important;
                        overflow: hidden !important;
                        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03) !important;
                        background: #ffffff !important;
                    }
                    .fi-ta-header-cell {
                        background-color: #f8fafc !important;
                        border-bottom: 1px solid #e2e8f0 !important;
                    }
                    .fi-ta-row:hover {
                        background-color: rgba(16, 185, 129, 0.03) !important;
                    }
                </style>'
            )
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => '
                    <div class="flex items-center gap-x-2 me-3">
                        <!-- Seasonal Badge (Agriculture signature) -->
                        <span class="hidden xl:inline-flex items-center gap-x-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200/60 shadow-sm">
                            <i class="fa-solid fa-wheat-awn text-amber-600"></i>
                            <span>Vụ Hè Thu 2026</span>
                        </span>

                        <!-- Sync Status Badge -->
                        <span class="hidden md:inline-flex items-center gap-x-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/50 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                            <span>Đã đồng bộ</span>
                        </span>

                        <!-- User Role Badge -->
                        <span class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                            ' . (auth()->user()?->role === 'admin' ? 'Quản trị viên' : (auth()->user()?->role === 'engineer' ? 'Kỹ sư Nông nghiệp' : 'Nhân viên')) . '
                        </span>

                        <!-- View Frontend Website Button -->
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