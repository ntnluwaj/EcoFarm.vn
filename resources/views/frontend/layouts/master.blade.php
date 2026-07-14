<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Công Ty Vật Tư Nông Nghiệp')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: bold; color: #2e7d32 !important; }
        .bg-green-footer { background-color: #1b5e20; color: #ffffff; }
        .text-xs { font-size: 13px !important; }
        .hover-success:hover { background-color: #e8f5e9 !important; color: #2e7d32 !important; }
        
        /* 🌟 HIỆU ỨNG NỔI BẬT NÚT ĐĂNG KÝ ĐẠI LÝ TRÊN NAVBAR HEADER */
        .highlight-agency {
            color: #2e7d32 !important;
            transition: all 0.2s ease-in-out;
        }
        .highlight-agency:hover {
            color: #1b5e20 !important;
            transform: translateY(-1px);
        }
        .hover-logo:hover {
            transform: scale(1.05);
        }
        
        /* 🌟 RESPONSIVE NAVBAR: Tránh rớt dòng trên màn hình trung bình và lớn */
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-nav .nav-link {
                padding-right: 0.65rem !important;
                padding-left: 0.65rem !important;
                font-size: 13.5px !important;
            }
            .search-input-custom {
                max-width: 155px !important;
                font-size: 13px !important;
            }
            .nav-btn-custom {
                padding: 6px 12px !important;
                font-size: 12.5px !important;
            }
        }

        /* 🌟 HIỆU ỨNG HOVER & GIỮ ACTIVE CHO NAV LINK */
        .navbar-nav .nav-link {
            position: relative;
            color: #333333 !important;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #2e7d32 !important;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: #2e7d32;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 70%;
        }
    </style>
</head>
<body>

    @if(!request()->routeIs('login', 'register'))
    <!-- Floating Glassmorphic Navbar -->
    <div class="container sticky-top px-0" style="z-index: 1050; margin-top: 15px; margin-bottom: 5px;">
        <nav class="navbar navbar-expand-lg navbar-light mx-2 mx-md-0 px-4 py-2.5 rounded-pill shadow-sm" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.5);">
            <div class="container-fluid px-0 d-flex align-items-center justify-content-between">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}" style="padding: 0;">
                    <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 85px; margin-top: -18px; margin-bottom: -18px; object-fit: contain; transition: transform 0.3s ease;" class="hover-logo">
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="padding: 0;">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm vật tư</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Cẩm nang nông nghiệp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">Liên hệ tư vấn</a>
                    </li>
                </ul>
                
                <form class="d-flex me-2" action="{{ route('products.index') }}" method="GET">
                    <input class="form-control me-2 search-input-custom" type="search" name="search" placeholder="Tìm kiếm vật tư..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                
                <div class="navbar-nav align-items-center">
                    @auth
                        @php
                            $unreadNotifications = auth()->user()->unreadNotifications;
                            $readNotifications = auth()->user()->readNotifications()->take(8)->get();
                            $unreadCount = $unreadNotifications->count();
                            
                            $userNotifications = [];
                            
                            foreach ($unreadNotifications as $n) {
                                $data = $n->data;
                                $faIcon = match($data['icon'] ?? '') {
                                    'heroicon-o-shopping-bag' => 'fa-box-open',
                                    'heroicon-o-chat-bubble-left-right' => 'fa-user-doctor',
                                    default => 'fa-bell'
                                };
                                $userNotifications[] = [
                                    'icon' => $faIcon,
                                    'color' => $data['color'] ?? 'success',
                                    'title' => $data['title'] ?? 'Thông báo',
                                    'body' => $data['body'] ?? '',
                                    'time' => $n->created_at->diffForHumans(),
                                    'is_unread' => true,
                                    'url' => route('cart.history')
                                ];
                            }
                            
                            foreach ($readNotifications as $n) {
                                $data = $n->data;
                                $faIcon = match($data['icon'] ?? '') {
                                    'heroicon-o-shopping-bag' => 'fa-box-open',
                                    'heroicon-o-chat-bubble-left-right' => 'fa-user-doctor',
                                    default => 'fa-bell'
                                };
                                $userNotifications[] = [
                                    'icon' => $faIcon,
                                    'color' => $data['color'] ?? 'success',
                                    'title' => $data['title'] ?? 'Thông báo',
                                    'body' => $data['body'] ?? '',
                                    'time' => $n->created_at->diffForHumans(),
                                    'is_unread' => false,
                                    'url' => route('cart.history')
                                ];
                            }
                            
                            $totalCount = count($userNotifications);
                        @endphp

                        <div class="dropdown me-3">
                            <a class="nav-link text-dark position-relative" href="#" role="button" id="notificationMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell fs-5"></i>
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">Thông báo mới</span>
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2 py-2" aria-labelledby="notificationMenu" style="width: 320px; max-height: 400px; overflow-y: auto; font-size: 13px; z-index: 9999;">
                                <li class="px-3 py-1.5 border-bottom fw-bold text-dark d-flex justify-content-between align-items-center">
                                    <span>Thông báo gần đây</span>
                                    @if($unreadCount > 0)
                                        <a href="{{ route('notifications.readAll') }}" class="text-success text-decoration-none" style="font-size: 11px; font-weight: 600;">Đánh dấu đã đọc</a>
                                    @endif
                                </li>
                                @if($totalCount > 0)
                                    @foreach($userNotifications as $notif)
                                        <li>
                                            <a class="dropdown-item py-2 px-3 d-flex gap-2.5 border-bottom border-light-subtle text-wrap" href="{{ $notif['url'] }}" style="{{ $notif['is_unread'] ? 'background-color: rgba(46, 125, 50, 0.04); font-weight: 500;' : '' }}">
                                                <div class="rounded-circle bg-{{ $notif['color'] }}-subtle text-{{ $notif['color'] }} d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px;">
                                                    <i class="fa-solid {{ $notif['icon'] }} fs-6"></i>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <strong class="text-dark d-block" style="font-size: 12px; {{ $notif['is_unread'] ? 'font-weight: 700;' : 'font-weight: 500;' }}">{{ $notif['title'] }}</strong>
                                                    <span class="text-secondary d-block mt-0.5" style="font-size: 11px; line-height: 1.3;">{{ $notif['body'] }}</span>
                                                    <span class="text-muted d-block mt-1" style="font-size: 10px;">{{ $notif['time'] }}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="px-3 py-4 text-center text-muted">
                                        <i class="fa-regular fa-bell-slash fs-3 mb-2 d-block text-secondary opacity-50"></i>
                                        Không có thông báo mới
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endauth

                    <a class="nav-link text-dark position-relative me-3" href="{{ route('cart.index') }}">
                        <i class="fa-solid fa-basket-shopping fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ session()->has('cart') ? count(session()->get('cart')) : 0 }}
                        </span>
                    </a>
                    
                    @if(auth()->check())
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-success dropdown-toggle fw-bold rounded-3 text-xs d-inline-flex align-items-center gap-1" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #2e7d32; border: none; padding: 8px 16px;">
                                <i class="fa-solid fa-circle-user"></i> {{ auth()->user()->name }}
                            </button>
                            
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="userMenu" style="font-size: 13px; min-width: 195px; z-index: 9999;">
                                @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                    <li>
                                        <a class="dropdown-item py-2 text-dark fw-semibold" href="/admin">
                                            <i class="fa-solid fa-gauge-high me-2 text-success"></i>Vào trang quản trị
                                        </a>
                                    </li>
                                    @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item py-2 text-dark fw-semibold" href="{{ route('admin.reports') }}">
                                            <i class="fa-solid fa-chart-line me-2 text-success"></i>Báo cáo bãi kho
                                        </a>
                                    </li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                

                                
                                <li>
                                    <a class="dropdown-item py-2 text-dark hover-success" href="{{ route('profile.index') }}">
                                        <i class="fa-solid fa-user-gear me-2 text-muted"></i>Tài khoản cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark hover-success" href="{{ route('cart.history') }}">
                                        <i class="fa-solid fa-clock-rotate-left me-2 text-muted"></i>Đơn hàng của tôi
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('frontend.logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger fw-bold border-0 bg-transparent w-100 text-start m-0 p-2 ps-3">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="d-flex gap-2">
                            <a href="/login" class="btn btn-success fw-bold rounded-3 d-inline-flex align-items-center gap-1 nav-btn-custom text-xs" style="background-color: #2e7d32; border: none; padding: 8px 16px;">
                                <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-success fw-bold rounded-3 d-inline-flex align-items-center gap-1 nav-btn-custom text-xs" style="border: 2px solid #2e7d32; color: #2e7d32; padding: 8px 16px; background: transparent;">
                                <i class="fa-solid fa-user-plus"></i> Đăng ký
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </div>
    @endif

    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fw-semibold small border-0 shadow-sm" role="alert" style="background-color: #e8f5e9; color: #2e7d32;">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show fw-semibold small border-0 shadow-sm" role="alert" style="background-color: #ffebee; color: #c62828;">
                <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    @if(!request()->routeIs('login', 'register'))
    <footer class="bg-green-footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3 d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="EcoFarm Logo" style="height: 75px; filter: brightness(0) invert(1); margin-top: -10px; margin-bottom: -10px; object-fit: contain;"> 
                    </h5>
                    <p class="small text-white-50">Chuyên cung ứng phân bón hữu cơ, thuốc bảo vệ thực vật chính hãng, chất lượng cao, đồng hành cùng nhà vườn nâng cao sản lượng mùa vụ tại khu vực Đồng bằng sông Cửu Long.</p>
                    <p class="small"><i class="fa-solid fa-location-dot me-2"></i>Khu vực Cần Thơ, Việt Nam</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none small">Danh mục vật tư</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-white-50 text-decoration-none small">Bài viết kỹ thuật canh tác</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-white-50 text-decoration-none small">Liên hệ tư vấn</a></li>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <li class="pt-2"><a href="{{ route('sandbox.index') }}" class="text-warning text-decoration-none small fw-bold"><i class="fa-solid fa-flask me-1"></i>Trang Giả lập Webhook (Sandbox)</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Liên hệ với EcoFarm</h5>
                    <p class="small text-white-50">Hãy liên hệ với chúng tôi để được hỗ trợ kỹ thuật canh tác và tư vấn cung ứng vật tư tốt nhất:</p>
                    <ul class="list-unstyled text-white-50 small d-flex flex-column gap-2">
                        <li><i class="fa-solid fa-phone text-warning me-2"></i><strong>Hotline:</strong> 1900 888 999 - (0292) 3 888 999</li>
                        <li><i class="fa-solid fa-envelope text-warning me-2"></i><strong>Email:</strong> contact@ecofarm.vn</li>
                        <li><i class="fa-solid fa-clock text-warning me-2"></i><strong>Làm việc:</strong> T2 - CN (7:00 - 21:00)</li>
                        <li class="pt-2">
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-brands fa-youtube"></i></a>
                                <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-solid fa-comment-dots"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="bg-white-50">
            <div class="text-center small text-white-50">
                © {{ date('Y') }} Dự án thực tập Hệ thống thông tin - Sinh viên thực hiện: Nguyễn Thị Ngọc Lựa.
            </div>
        </div>
    </footer>
    @endif

    @if(!request()->routeIs('login', 'register'))
    <!-- ========================================== -->
    <!-- FLOATING CHATBOX WIDGET (PRD HIGH AESTHETIC) -->
    <!-- ========================================== -->
    <div id="ecofarm-chatbox-container" style="position: fixed; bottom: 25px; right: 25px; z-index: 99999; font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- Chat Toggle Button -->
        <button id="chatbox-toggle-btn" class="btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%); border: none; transition: all 0.3s ease-in-out; position: relative;">
            <i class="fa-solid fa-comments text-white fs-4" id="chatbox-toggle-icon"></i>
            <span class="position-absolute p-1 bg-danger border border-light rounded-circle" style="top: 0; right: 0; display: block;" id="chatbox-unread-dot"></span>
        </button>

        <!-- Chat Window -->
        <div id="chatbox-window" class="card border-0 shadow-lg d-none" style="position: absolute; bottom: 70px; right: 0; width: 330px; height: 420px; border-radius: 16px; overflow: hidden; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
            <!-- Chat Header -->
            <div class="card-header border-0 text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="position-relative">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; color: #2e7d32;">
                            <i class="fa-solid fa-robot fs-5"></i>
                        </div>
                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" style="transform: translate(25%, 25%);"></span>
                    </div>
                    <div>
                        <strong class="d-block" style="font-size: 13.5px; line-height: 1.2;">Trợ lý EcoBot</strong>
                        <span style="font-size: 10px; opacity: 0.85;">Đang trực tuyến (Hỗ trợ 24/7)</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white btn-sm" id="chatbox-close-btn" style="box-shadow: none;"></button>
            </div>

            <!-- Chat Messages -->
            <div class="card-body p-3" id="chatbox-messages" style="height: 290px; overflow-y: auto; background-color: #f8fafc; font-size: 12.5px; display: flex; flex-direction: column; gap: 10px;">
                <!-- Welcoming message -->
                <div class="d-flex flex-column align-items-start gap-1" style="max-width: 85%;">
                    <div class="p-2.5 rounded-3 text-dark bg-white border border-light-subtle" style="border-radius: 0 12px 12px 12px !important; line-height: 1.4;">
                        Xin chào bà con! Tôi là Trợ lý Nông nghiệp **EcoBot**. Bà con cần tư vấn về kỹ thuật canh tác, liều lượng sử dụng hay giá sỉ vật tư nào?
                    </div>
                    <span class="text-muted text-xs ms-1" style="font-size: 9px;">Vừa xong</span>
                </div>
            </div>

            <!-- Chat Footer Input -->
            <div class="card-footer p-2 bg-white border-top border-light-subtle">
                <form id="chatbox-form" class="d-flex gap-1.5 align-items-center">
                    <input type="text" id="chatbox-input" class="form-control form-control-sm border-0 bg-light rounded-3 px-3 py-2" placeholder="Nhập câu hỏi của bà con..." autocomplete="off" style="font-size: 12.5px; box-shadow: none;">
                    <button type="submit" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #2e7d32; border: none;">
                        <i class="fa-solid fa-paper-plane text-white" style="font-size: 11px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Styles and Script -->
    <style>
        #chatbox-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.4) !important;
        }
        .user-msg {
            background-color: #e8f5e9 !important;
            color: #1b5e20 !important;
            border-radius: 12px 0 12px 12px !important;
            border: 1px solid rgba(46, 125, 50, 0.15) !important;
            align-self: flex-end;
            max-width: 85%;
            padding: 8px 12px;
            line-height: 1.4;
        }
        .bot-msg {
            background-color: #ffffff !important;
            color: #212529 !important;
            border-radius: 0 12px 12px 12px !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            align-self: flex-start;
            max-width: 85%;
            padding: 8px 12px;
            line-height: 1.4;
        }
        #chatbox-messages::-webkit-scrollbar {
            width: 4px;
        }
        #chatbox-messages::-webkit-scrollbar-thumb {
            background-color: rgba(46, 125, 50, 0.2);
            border-radius: 4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('chatbox-toggle-btn');
            const closeBtn = document.getElementById('chatbox-close-btn');
            const windowEl = document.getElementById('chatbox-window');
            const toggleIcon = document.getElementById('chatbox-toggle-icon');
            const unreadDot = document.getElementById('chatbox-unread-dot');
            const form = document.getElementById('chatbox-form');
            const input = document.getElementById('chatbox-input');
            const messagesContainer = document.getElementById('chatbox-messages');

            // Open / Close Toggle
            toggleBtn.addEventListener('click', function () {
                windowEl.classList.toggle('d-none');
                if (!windowEl.classList.contains('d-none')) {
                    toggleIcon.className = 'fa-solid fa-xmark text-white fs-4';
                    unreadDot.style.display = 'none'; // Clear unread badge
                    input.focus();
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    toggleIcon.className = 'fa-solid fa-comments text-white fs-4';
                }
            });

            closeBtn.addEventListener('click', function () {
                windowEl.classList.add('d-none');
                toggleIcon.className = 'fa-solid fa-comments text-white fs-4';
            });

            // Handle Send Message
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                // Add User Message
                addMessage(text, 'user-msg');
                input.value = '';

                // Typing indicator
                const typingId = addTypingIndicator();
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                // Bot Response Simulation
                setTimeout(function () {
                    removeTypingIndicator(typingId);
                    const botReply = getBotResponse(text);
                    addMessage(botReply, 'bot-msg');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 1000);
            });

            function addMessage(text, className) {
                const msgDiv = document.createElement('div');
                msgDiv.className = className;
                // Parse simple markdown-like bold text **text** to HTML strong tags
                let htmlContent = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                // Replace newlines with break tags
                htmlContent = htmlContent.replace(/\n/g, '<br>');
                msgDiv.innerHTML = htmlContent;
                messagesContainer.appendChild(msgDiv);
            }

            function addTypingIndicator() {
                const div = document.createElement('div');
                div.className = 'bot-msg text-muted d-flex align-items-center gap-1';
                div.id = 'typing-indicator-' + Date.now();
                div.innerHTML = `<span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 6px; height: 6px;"></span><span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 6px; height: 6px; animation-delay: 0.2s;"></span><span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 6px; height: 6px; animation-delay: 0.4s;"></span>`;
                messagesContainer.appendChild(div);
                return div.id;
            }

            function removeTypingIndicator(id) {
                const indicator = document.getElementById(id);
                if (indicator) {
                    indicator.remove();
                }
            }

            function getBotResponse(input) {
                const lowerInput = input.toLowerCase();

                if (lowerInput.includes('npk') || lowerInput.includes('phân bón')) {
                    return "EcoFarm đang có phân bón **NPK Đầu Trâu** dạng bao 10kg, 25kg, 50kg cực tốt cho việc kích rễ và nuôi trái. Bà con nên bón thúc vào giai đoạn cây chuẩn bị ra bông và nuôi trái non nhé!";
                }
                if (lowerInput.includes('anvil') || lowerInput.includes('bệnh') || lowerInput.includes('sâu') || lowerInput.includes('rầy') || lowerInput.includes('nấm')) {
                    return "Để xử lý nấm hại và rỉ sắt, thuốc trừ bệnh **Anvil 5SC Syngenta** (chai 250ml, 500ml, 1L) là giải pháp tốt nhất. Liều dùng khuyên dùng: 20-30ml cho bình 16 lít nước, phun đều tán lá.";
                }
                if (lowerInput.includes('đơn hàng') || lowerInput.includes('mua hàng') || lowerInput.includes('giao hàng')) {
                    return "Bà con có thể tra cứu nhanh lịch trình vận đơn ở mục **'Tra cứu đơn hàng'** trên thanh menu hoặc click vào chuông thông báo nếu đã đăng nhập. Nếu cần bốc xếp gấp, bà con gọi hotline **1900 888 999** nhé!";
                }
                if (lowerInput.includes('giá sỉ') || lowerInput.includes('sỉ') || lowerInput.includes('đại lý') || lowerInput.includes('chiết khấu')) {
                    return "Chào bà con, EcoFarm áp dụng biểu giá sỉ chiết khấu lên đến **15%** cho Đại lý và Hợp tác xã mua sỉ số lượng lớn. Bà con vui lòng liên hệ hotline **1900 888 999** để gặp kỹ sư kinh tế thương lượng giá!";
                }
                if (lowerInput.includes('cảm ơn') || lowerInput.includes('thank')) {
                    return "Dạ không có chi! Chúc bà con một mùa vụ trúng lớn, được mùa được giá! Cần hỗ trợ gì thêm bà con cứ hỏi nhé.";
                }

                return "EcoBot xin ghi nhận câu hỏi của bà con. Hiện tại Kỹ sư nông học của EcoFarm đang bận tư vấn ngoài ruộng. Bà con có thể gửi câu hỏi chi tiết ở mục **'Hỏi đáp kỹ thuật'** ở trang sản phẩm hoặc liên hệ hotline **1900 888 999** để nhận tư vấn trực tiếp miễn phí!";
            }
        });
    </script>
    @endif

  <!-- Modal Nhờ Kỹ Sư Gọi Tư Vấn -->
  <div class="modal fade" id="adviceModal" tabindex="-1" aria-labelledby="adviceModalLabel" aria-hidden="true" style="font-family: 'Plus Jakarta Sans', sans-serif;">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
              <div class="modal-header bg-success text-white py-3 px-4">
                  <h5 class="modal-title fw-bold" id="adviceModalLabel"><i class="fa-solid fa-user-doctor me-2"></i>Nhờ Kỹ Sư Gọi Điện Tư Vấn</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body p-4" id="adviceModalBody">
                  <form id="adviceForm">
                      @csrf
                      <input type="hidden" name="subject" id="adviceSubject" value="Yêu cầu gọi điện tư vấn vật tư trước khi đặt">
                      
                      <!-- Họ tên -->
                      <div class="mb-3">
                          <label for="adviceName" class="form-label fw-semibold text-dark small">Họ tên của bà con <span class="text-danger">*</span></label>
                          <input type="text" class="form-control rounded-3" id="adviceName" name="name" placeholder="Nhập họ tên" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                      </div>
                      
                      <!-- Số điện thoại -->
                      <div class="mb-3">
                          <label for="advicePhone" class="form-label fw-semibold text-dark small">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                          <input type="text" class="form-control rounded-3" id="advicePhone" name="phone" placeholder="Nhập số điện thoại nhận cuộc gọi" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required>
                      </div>
                      
                      <!-- Chi tiết yêu cầu -->
                      <div class="mb-3">
                          <label for="adviceMessage" class="form-label fw-semibold text-dark small">Chi tiết cần tư vấn <span class="text-danger">*</span></label>
                          <textarea class="form-control rounded-3" id="adviceMessage" name="message" rows="3" placeholder="Nhập sản phẩm hoặc loại cây cần tư vấn liều lượng bón tưới..." required>Tôi cần kỹ sư gọi điện tư vấn thêm thông tin trước khi đặt mua vật tư này.</textarea>
                      </div>
                      
                      <button type="submit" class="btn btn-success w-100 fw-bold rounded-3 py-2.5 mt-2" style="background-color: #2e7d32; border: none;">
                          <i class="fa-solid fa-phone-volume me-2"></i>Xác nhận - Gọi cho tôi ngay
                      </button>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Overlay Giả lập Cuộc gọi Gọi Điện -->
  <div id="callingOverlay" class="d-none" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 100000; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif;">
      <div class="text-center text-white p-4 rounded-4" style="max-width: 400px; width: 90%;">
          <!-- Ringing Icon Animation -->
          <div class="mb-4 position-relative d-inline-flex justify-content-center align-items-center" style="width: 100px; height: 100px;">
              <div class="position-absolute bg-success rounded-circle border border-success opacity-25" style="width: 100%; height: 100%; animation: pulse-ring 1.5s infinite;"></div>
              <div class="position-absolute bg-success rounded-circle border border-success opacity-50" style="width: 80%; height: 80%; animation: pulse-ring 1.5s infinite 0.5s;"></div>
              <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 70px; height: 70px; z-index: 2;">
                  <i class="fa-solid fa-phone-volume fa-2xl" id="callingIcon"></i>
              </div>
          </div>

          <h4 class="fw-bold mb-2" id="callingStatus">Đang kết nối cuộc gọi...</h4>
          <p class="text-white-50 small mb-4" id="callingSub">Đang kết nối tổng đài ảo...</p>

          <div class="card bg-dark border-secondary p-3 rounded-3 text-start mb-4">
              <div class="small text-white-50"><i class="fa-regular fa-user me-2"></i>Người nhận: <strong class="text-white" id="callingNameSpan">Nguyễn Văn A</strong></div>
              <div class="small text-white-50 mt-1.5"><i class="fa-solid fa-mobile-screen-button me-2"></i>Số điện thoại: <strong class="text-white" id="callingPhoneSpan">0987654321</strong></div>
          </div>

          <!-- Progress status text list -->
          <div id="callingProgressLogs" class="text-white-50 small mb-4 text-center font-monospace" style="min-height: 24px; font-size: 12px;"></div>

          <button type="button" class="btn btn-danger btn-lg rounded-pill px-4 fw-semibold text-xs" id="hangupBtn" style="font-size: 13px;">
              <i class="fa-solid fa-phone-slash me-2"></i>Gác máy (Hủy cuộc gọi)
          </button>
      </div>
  </div>

  <style>
      @keyframes pulse-ring {
          0% { transform: scale(1); opacity: 0.8; }
          100% { transform: scale(1.6); opacity: 0; }
      }
      .mt-1.5 { margin-top: 0.375rem; }
  </style>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Bắt sự kiện truyền data từ các nút bấm
          const adviceModal = document.getElementById('adviceModal');
          if (adviceModal) {
              adviceModal.addEventListener('show.bs.modal', function(event) {
                  const button = event.relatedTarget;
                  const message = button.getAttribute('data-message');
                  if (message) {
                      const messageInput = document.getElementById('adviceMessage');
                      if (messageInput) {
                          messageInput.value = message;
                      }
                  }
              });
          }

          // Xử lý gửi form tư vấn gọi điện qua AJAX
          const adviceForm = document.getElementById('adviceForm');
          const callingOverlay = document.getElementById('callingOverlay');
          const callingStatus = document.getElementById('callingStatus');
          const callingSub = document.getElementById('callingSub');
          const callingNameSpan = document.getElementById('callingNameSpan');
          const callingPhoneSpan = document.getElementById('callingPhoneSpan');
          const callingProgressLogs = document.getElementById('callingProgressLogs');
          const hangupBtn = document.getElementById('hangupBtn');
          let callTimer1, callTimer2, callTimer3;

          if (adviceForm) {
              adviceForm.addEventListener('submit', function(e) {
                  e.preventDefault();

                  const name = document.getElementById('adviceName').value;
                  const phone = document.getElementById('advicePhone').value;
                  const subject = document.getElementById('adviceSubject').value;
                  const message = document.getElementById('adviceMessage').value;

                  // 1. Đóng modal điền thông tin
                  const modalInst = bootstrap.Modal.getInstance(adviceModal);
                  if (modalInst) {
                      modalInst.hide();
                  }

                  // 2. Hiển thị màn hình cuộc gọi mô phỏng
                  callingNameSpan.innerText = name;
                  callingPhoneSpan.innerText = phone;
                  callingStatus.innerText = 'Đang quay số...';
                  callingSub.innerText = 'Kết nối cổng tổng đài ảo VoIP...';
                  callingProgressLogs.innerText = '[System]: Khởi tạo đường truyền kết nối...';
                  callingOverlay.classList.remove('d-none');

                  // Gửi dữ liệu qua fetch API để lưu CSDL
                  fetch("{{ route('contact.storeCallRequest') }}", {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({
                          name: name,
                          phone: phone,
                          subject: subject,
                          message: message
                      })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          // Bắt đầu chuỗi giả lập cuộc gọi VoIP
                          callTimer1 = setTimeout(function() {
                              callingStatus.innerText = 'Đang đổ chuông...';
                              callingSub.innerText = 'Điện thoại của bà con đang reo...';
                              callingProgressLogs.innerText = '[Ringing]: Vui lòng sẵn sàng nhấc máy điện thoại.';
                          }, 2500);

                          callTimer2 = setTimeout(function() {
                              callingStatus.innerText = 'Đã kết nối!';
                              callingSub.innerText = 'Cuộc gọi đàm thoại đang diễn ra...';
                              callingProgressLogs.style.color = '#4caf50';
                              callingProgressLogs.innerHTML = '<i class="fa-solid fa-circle-nodes"></i> Kỹ sư Nông học đang kết nối trực tiếp với bà con.';
                              const icon = document.getElementById('callingIcon');
                              if (icon) {
                                  icon.classList.remove('fa-phone-volume');
                                  icon.classList.add('fa-phone');
                              }
                          }, 5500);

                          callTimer3 = setTimeout(function() {
                              // Tự động hoàn tất sau 11.5 giây đàm thoại mẫu
                              finishCall();
                          }, 11500);

                      } else {
                          callingStatus.innerText = 'Lỗi kết nối!';
                          callingSub.innerText = 'Yêu cầu không được ghi nhận.';
                          callingProgressLogs.innerText = '[Error]: ' + data.message;
                      }
                  })
                  .catch(err => {
                      callingStatus.innerText = 'Lỗi đường truyền!';
                      callingSub.innerText = 'Không thể kết nối máy chủ.';
                      callingProgressLogs.innerText = '[System Error]: ' + err.message;
                  });
              });
          }

          if (hangupBtn) {
              hangupBtn.addEventListener('click', function() {
                  finishCall();
              });
          }

          function finishCall() {
              // Xóa các bộ hẹn giờ
              clearTimeout(callTimer1);
              clearTimeout(callTimer2);
              clearTimeout(callTimer3);

              // Ẩn màn hình gọi điện
              callingOverlay.classList.add('d-none');
              
              // Reset icon
              const icon = document.getElementById('callingIcon');
              if (icon) {
                  icon.classList.remove('fa-phone');
                  icon.classList.add('fa-phone-volume');
              }
              callingProgressLogs.style.color = '';
              callingProgressLogs.innerText = '';
              
              alert('Cuộc gọi tư vấn đã kết thúc thành công. Thông tin của bà con đã được lưu trữ để kỹ sư tiếp tục theo dõi!');
          }
      });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>