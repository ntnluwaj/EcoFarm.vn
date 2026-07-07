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
        // 1. Nếu tài khoản là Admin tối cao -> Cho phép vào sâu Dashboard nội bộ
        if (Auth::user()->role === 'admin') {
            return response()->redirectTo(filament()->getUrl());
        }

        // 2. Nếu là Nhà vườn (user) -> Đẩy ngược ra trang chủ Frontend
        return redirect()->to('/');
    }
}