<?php

namespace App\Filament\Outputs;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response | RedirectResponse
    {
        // 1. Nếu tài khoản là Admin, Nhân viên hoặc Kỹ sư -> Cho phép vào sâu Dashboard nội bộ
        if (in_array(Auth::user()->role, ['admin', 'staff', 'engineer'])) {
            return response()->redirectTo(filament()->getUrl());
        }

        // 2. Nếu là Nhà vườn (user) -> Đẩy ngược ra trang chủ Frontend
        return redirect()->to('/');
    }
}