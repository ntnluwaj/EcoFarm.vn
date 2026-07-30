<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function profile()
    {
        $user = Auth::user();
        return view('frontend.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'password.min' => 'Mật khẩu mới phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Dung lượng hình ảnh không được vượt quá 2MB.',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            // Lưu ảnh mới
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin tài khoản thành công!');
    }

    public function vouchers()
    {
        $user = Auth::user();
        
        // Lấy tất cả voucher thuộc sở hữu của người dùng này
        $vouchers = \App\Models\Voucher::where('user_id', $user->id)
            ->with('product')
            ->orderBy('id', 'desc')
            ->get();
            
        return view('frontend.profile.my_vouchers', compact('user', 'vouchers'));
    }
}
