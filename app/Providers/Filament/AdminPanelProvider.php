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
                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.01) !important;
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

                    /* 🌟 DEEP FOREST DARK SIDEBAR STYLE */
                    .fi-sidebar {
                        background-color: #0b110f !important; /* Deep forest dark charcoal */
                        border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
                    }
                    .fi-sidebar-header {
                        background-color: #070d0b !important; /* Slightly darker top section */
                        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
                    }

                    /* Sidebar Brand Name text */
                    .fi-sidebar-header a span {
                        color: #ffffff !important;
                    }

                    /* Sidebar Section Headers (Group titles) */
                    .fi-sidebar-group-label {
                        color: #4b5e57 !important; /* Muted greenish gray */
                        font-weight: 700 !important;
                        font-size: 11px !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.05em !important;
                    }

                    /* Sidebar Navigation Links */
                    .fi-sidebar-item-button {
                        color: #8fa099 !important; /* Soft gray-green */
                        transition: all 0.2s ease-in-out !important;
                        border-radius: 0.5rem !important;
                        margin: 2px 0 !important;
                    }
                    .fi-sidebar-item-button svg {
                        color: #62776f !important;
                        transition: all 0.2s ease-in-out !important;
                    }

                    /* Sidebar Link Hover */
                    .fi-sidebar-item-button:not(.fi-active):hover {
                        background-color: rgba(255, 255, 255, 0.03) !important;
                        color: #ffffff !important;
                    }
                    .fi-sidebar-item-button:not(.fi-active):hover svg {
                        color: #10b981 !important;
                    }

                    /* 🌟 ACTIVE SIDEBAR MENU ITEM STYLE (STUNNING EMERALD GRADIENT) */
                    .fi-sidebar-item-button.fi-active,
                    .fi-sidebar-item-button[data-active="1"],
                    .fi-active,
                    [data-active="1"],
                    .fi-sidebar-item-active > a,
                    .fi-sidebar-item-active > div {
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                        color: #ffffff !important;
                        font-weight: 600 !important;
                        border-radius: 0.5rem !important;
                        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2) !important;
                        border-left: none !important;
                    }
                    .fi-sidebar-item-button.fi-active svg,
                    .fi-active svg,
                    .fi-sidebar-item-active svg {
                        color: #ffffff !important;
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
                    <a href="/" class="inline-flex items-center gap-x-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/50 hover:bg-emerald-100 transition-all text-xs font-bold shadow-sm me-3">
                        <i class="fa-solid fa-house"></i>
                        <span>Xem trang chủ</span>
                    </a>
                '
            )
            ->renderHook(
                'panels::sidebar.nav.start',
                fn (): string => '
                    <div class="px-4 py-2 mx-3 mb-2 rounded-lg bg-amber-950/20 border border-amber-900/30 flex items-center gap-x-2 text-[11px] font-semibold text-amber-300 shadow-sm">
                        <i class="fa-solid fa-wheat-awn text-amber-500 text-xs"></i>
                        <span>Vụ Hè Thu 2026</span>
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    </div>
                '
            )
            ->renderHook(
                'panels::sidebar.footer',
                fn (): string => '
                    <div class="px-4 py-3.5 border-t border-white/5 bg-black/20 flex items-center gap-x-3">
                        ' . (auth()->user()?->avatar ? 
                            '<img src="' . asset('storage/' . auth()->user()->avatar) . '" alt="' . auth()->user()->name . '" class="w-9 h-9 rounded-full object-cover border border-emerald-500/30 shadow-sm">' : 
                            '<div class="w-9 h-9 rounded-full bg-emerald-950/50 text-emerald-400 flex items-center justify-center font-bold text-sm border border-emerald-800/30">
                                ' . substr(auth()->user()?->name ?? 'U', 0, 1) . '
                            </div>'
                        ) . '
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-white truncate" style="margin-bottom: 2px;">' . auth()->user()?->name . '</p>
                            <span class="inline-flex items-center gap-x-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950/60 text-emerald-400 border border-emerald-800/30">
                                <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                ' . (auth()->user()?->role === 'admin' ? 'Quản trị viên' : (auth()->user()?->role === 'engineer' ? 'Kỹ sư Nông nghiệp' : 'Nhân viên')) . '
                            </span>
                        </div>
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