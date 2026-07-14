<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * BỘ LỌC AN NINH KIỂM TRA QUYỀN TRUY CẬP (PRD - TIÊU CHÍ AC-05)
     * Đã cấu trúc lại để cho phép Đại lý/Nhà vườn đi qua cổng đăng nhập công cộng.
     */
public function handle(Request $request, Closure $next): Response
{
    // 🌟 SỬA ĐIỀU KIỆN: Bỏ qua kiểm tra nếu đang ở trang đăng nhập cũ, mới hoặc livewire
    if ($request->is('admin/login*') || $request->is('login*') || $request->is('livewire/*')) {
        return $next($request);
    }

    // Nếu chưa đăng nhập -> Đá về đúng trang /login mới cấu hình
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập tài khoản để tiếp tục tác nghiệp!');
    }

    // Tiêu chí AC-05: Đang vào vùng quản trị nhưng không phải Admin hoặc Nhân viên (staff) -> Đẩy ra trang chủ Frontend
    if (!in_array(Auth::user()->role, ['admin', 'staff']) && $request->is('admin*')) {
        return redirect('/');
    }

    return $next($request);
}
}