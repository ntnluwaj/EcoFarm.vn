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
                        border-top: 3px solid #10b981 !important; /* Branded green top indicator line */
                        border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.01) !important;
                    }

                    /* 🌟 MODERN SEARCH BAR STYLE */
                    .fi-global-search input,
                    .fi-global-search-input input {
                        border-radius: 0.5rem !important;
                        background-color: #f9fafb !important;
                        border: 1px solid rgba(0, 0, 0, 0.08) !important;
                        transition: all 0.2s ease-in-out !important;
                        font-size: 13px !important;
                        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.01) !important;
                    }
                    .fi-global-search input:focus,
                    .fi-global-search-input input:focus {
                        background-color: #ffffff !important;
                        border-color: #10b981 !important;
                        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12) !important;
                    }

                    /* 🌟 DARK SLEEK SIDEBAR STYLE (MATCHING USER SCREENSHOTS) */
                    .fi-sidebar {
                        background-color: #111827 !important;
                        border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
                    }
                    .fi-sidebar-header {
                        background-color: #111827 !important;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
                    }
                    .fi-sidebar-group,
                    .fi-sidebar-nav-group {
                        border: none !important;
                        box-shadow: none !important;
                        outline: none !important;
                        background: transparent !important;
                    }
                    .fi-sidebar-nav-group-label,
                    .fi-sidebar-group-label,
                    .fi-sidebar-header * {
                        color: #9ca3af !important;
                    }
                    .fi-sidebar-group-label {
                        color: #6b7280 !important;
                        font-size: 10.5px !important;
                        font-weight: 700 !important;
                        letter-spacing: 0.8px !important;
                        text-transform: uppercase !important;
                    }
                    .fi-sidebar-item-button {
                        color: #9ca3af !important;
                        border-radius: 0.5rem !important;
                        border: 1px solid transparent !important;
                        transition: all 0.15s ease-in-out !important;
                    }
                    .fi-sidebar-item-button:hover {
                        color: #ffffff !important;
                        background-color: rgba(255, 255, 255, 0.05) !important;
                    }

                    /* 🌟 ACTIVE NAVIGATION BUTTON (STRICTLY APPLIED TO INNER ITEM BUTTON ONLY) */
                    a.fi-sidebar-item-button.fi-active,
                    a.fi-sidebar-item-button[aria-current="page"],
                    li.fi-sidebar-item-active > a.fi-sidebar-item-button {
                        background-color: #1f2937 !important;
                        color: #ffffff !important;
                        border: 1.5px solid #f97316 !important;
                        box-shadow: 0 0 10px rgba(249, 115, 22, 0.25) !important;
                        font-weight: 600 !important;
                        border-radius: 0.5rem !important;
                    }

                    a.fi-sidebar-item-button.fi-active svg,
                    a.fi-sidebar-item-button[aria-current="page"] svg,
                    li.fi-sidebar-item-active > a.fi-sidebar-item-button svg {
                        color: #f97316 !important;
                    }

                    /* 🌟 TOPBAR SOLID WHITE MINIMALIST STYLE */
                    .fi-topbar {
                        background-color: #ffffff !important;
                        border-bottom: 1px solid #e5e7eb !important;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
                    }

                    /* 🌟 MODERN SEARCH BAR STYLE */
                    .fi-global-search input,
                    .fi-global-search-input input {
                        border-radius: 0.5rem !important;
                        background-color: #f9fafb !important;
                        border: 1px solid rgba(0, 0, 0, 0.08) !important;
                        transition: all 0.2s ease-in-out !important;
                        font-size: 13px !important;
                    }
                    .fi-global-search input:focus,
                    .fi-global-search-input input:focus {
                        background-color: #ffffff !important;
                        border-color: #f97316 !important;
                        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15) !important;
                    }

                    /* 🌟 STATS OVERVIEW CARDS */
                    .fi-wi-stats-overview-stat {
                        transition: all 0.2s ease-in-out !important;
                        border: 1px solid #e5e7eb !important;
                        border-radius: 0.85rem !important;
                        background: #ffffff !important;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02) !important;
                    }
                    .fi-wi-stats-overview-stat:hover {
                        transform: translateY(-2px) !important;
                        border-color: rgba(249, 115, 22, 0.3) !important;
                        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05) !important;
                    }

                    /* 🌟 TABLE HOVER EFFECTS & COMPACT RESPONSIVE CELL PADDING FOR PERFECT FIT */
                    .fi-ta-ctn {
                        border: 1px solid #e5e7eb !important;
                        border-radius: 1rem !important;
                        overflow-x: auto !important;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
                        background-color: #ffffff !important;
                    }
                    .fi-ta-table {
                        table-layout: auto !important;
                        width: 100% !important;
                    }
                    .fi-ta-cell,
                    .fi-ta-header-cell {
                        padding-top: 10px !important;
                        padding-bottom: 10px !important;
                        padding-left: 10px !important;
                        padding-right: 10px !important;
                    }
                    .fi-ta-header-cell {
                        background-color: #f8fafc !important;
                        border-bottom: 1px solid #e2e8f0 !important;
                        font-size: 11px !important;
                        font-weight: 700 !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.5px !important;
                        color: #475569 !important;
                    }
                    .fi-ta-row {
                        transition: all 0.15s ease-in-out !important;
                    }
                    .fi-ta-row:hover {
                        background-color: #f8fafc !important;
                    }
                    /* 🌟 QUICK FILTER PILLS TABS STYLING (MATCHING SCREENSHOT 2 EXACTLY) */
                    .fi-tabs {
                        border-bottom: none !important;
                        margin-bottom: 1rem !important;
                        gap: 0.5rem !important;
                    }
                    .fi-tabs-item {
                        border-radius: 9999px !important;
                        padding: 6px 16px !important;
                        font-size: 12.5px !important;
                        font-weight: 600 !important;
                        border: 1px solid #e2e8f0 !important;
                        background-color: #ffffff !important;
                        color: #475569 !important;
                        transition: all 0.15s ease-in-out !important;
                    }
                    .fi-tabs-item:hover {
                        background-color: #f8fafc !important;
                    }
                    .fi-tabs-item[aria-selected="true"],
                    .fi-tabs-item.fi-active,
                    .fi-tabs-item[data-active="1"] {
                        background-color: #111827 !important;
                        color: #ffffff !important;
                        border-color: #111827 !important;
                        box-shadow: 0 2px 8px rgba(17, 24, 39, 0.2) !important;
                    }
                    .fi-tabs-item-badge {
                        border-radius: 9999px !important;
                        font-size: 11px !important;
                        font-weight: 700 !important;
                    }

                    /* 🌟 CHARTS CARD STYLING */
                    .fi-wi-widget > .fi-section {
                        border: 1px solid #e5e7eb !important;
                        border-radius: 0.85rem !important;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02) !important;
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