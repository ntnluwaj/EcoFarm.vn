@extends('frontend.layouts.master')

@section('title', $data['title'] ?? 'Chi tiết thông báo - EcoFarm')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Chi tiết thông báo</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <!-- Top Accent Line -->
                <div style="height: 6px; background: linear-gradient(90deg, #2e7d32 0%, #4caf50 100%);"></div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-start gap-4 flex-column flex-md-row">
                        <!-- Icon Circle -->
                        @php
                            $faIcon = $data['icon'] ?? 'fa-bell';
                            if (strpos($faIcon, 'heroicon-') === 0) {
                                $faIcon = match($faIcon) {
                                    'heroicon-o-shopping-bag' => 'fa-box-open',
                                    'heroicon-o-chat-bubble-left-right' => 'fa-user-doctor',
                                    'heroicon-o-gift' => 'fa-gift',
                                    'heroicon-o-bell' => 'fa-bell',
                                    'heroicon-o-check-circle' => 'fa-circle-check',
                                    'heroicon-o-truck' => 'fa-truck',
                                    default => 'fa-bell'
                                };
                            }
                            $color = $data['color'] ?? 'success';
                        @endphp
                        <div class="rounded-circle bg-{{ $color }}-subtle text-{{ $color }} d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; min-width: 72px; font-size: 28px;">
                            <i class="fa-solid {{ $faIcon }}"></i>
                        </div>

                        <!-- Notification details -->
                        <div class="flex-grow-1">
                            <span class="text-muted small d-block mb-1">
                                <i class="fa-regular fa-clock me-1"></i>{{ $notification->created_at->format('d/m/Y - H:i') }} ({{ $notification->created_at->diffForHumans() }})
                            </span>
                            <h4 class="fw-bold text-dark mb-3" style="font-size: 20px;">
                                {{ $data['title'] ?? 'Thông báo từ hệ thống' }}
                            </h4>
                            <div class="text-secondary mb-4 py-3 px-3 rounded-3 bg-light border-start border-3 border-{{ $color }}" style="font-size: 14.5px; line-height: 1.6; white-space: pre-wrap;">{{ $data['body'] ?? '' }}</div>

                            <div class="d-flex flex-wrap gap-2.5">
                                @if(!empty($data['url']))
                                    <a href="{{ $data['url'] }}" class="btn btn-success fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2" style="background-color: #2e7d32; border: none; font-size: 14px;">
                                        <i class="fa-solid fa-circle-arrow-right"></i> Xem chi tiết giao dịch
                                    </a>
                                @else
                                    <a href="{{ route('home') }}" class="btn btn-success fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2" style="background-color: #2e7d32; border: none; font-size: 14px;">
                                        <i class="fa-solid fa-house"></i> Quay lại trang chủ
                                    </a>
                                @endif

                                <form action="{{ route('notifications.markAsUnread', $notification->id) }}" method="POST" class="m-0 d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary fw-semibold rounded-pill px-4 py-2" style="font-size: 14px;">
                                        <i class="fa-regular fa-envelope-open me-1"></i> Đánh dấu chưa đọc
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
