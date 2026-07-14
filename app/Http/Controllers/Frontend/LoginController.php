<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/')->with('info', 'Bà con đã đăng nhập tài khoản rồi.');
        }
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Địa chỉ Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (in_array($user->role, ['admin', 'employee'])) {
                return redirect()->intended('/admin')->with('success', "Đăng nhập thành công! Chào mừng {$user->name} truy cập trang quản trị.");
            }
            return redirect()->intended('/')->with('success', "Đăng nhập thành công! Chào mừng bà con {$user->name} đã quay trở lại.");
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Thông tin đăng nhập (Email hoặc Mật khẩu) không chính xác.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Bà con đã đăng xuất tài khoản thành công.');
    }
}
