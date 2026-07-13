<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/')->with('info', 'Bà con đã đăng nhập tài khoản rồi.');
        }
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Họ và tên là bắt buộc.',
            'email.required' => 'Địa chỉ Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được đăng ký sử dụng.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'customer',
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // Đăng nhập tự động ngay sau khi đăng ký thành công
        Auth::login($user);

        // Gửi thông báo chuông chào mừng
        try {
            \Filament\Notifications\Notification::make()
                ->title('Đăng ký tài khoản thành công!')
                ->body("Chào mừng bạn {$user->name} đã gia nhập mái nhà EcoFarm. Hãy cập nhật địa chỉ giao hàng để mua sắm thuận tiện!")
                ->icon('heroicon-o-user')
                ->color('success')
                ->sendToDatabase($user);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi thông báo đăng ký: " . $e->getMessage());
        }

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công! Hệ thống đã tự động đăng nhập cho bà con.');
    }
}
