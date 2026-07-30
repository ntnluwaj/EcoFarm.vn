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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'avatar.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes' => 'Chấp nhận các định dạng ảnh: jpeg, png, jpg, gif.',
            'avatar.max' => 'Dung lượng ảnh đại diện không quá 2MB.',
            'password.min' => 'Mật khẩu mới phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ để tiết kiệm không gian
            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                @unlink(public_path('storage/' . $user->avatar));
            }

            // Lưu tệp ảnh đại diện mới vào disk public
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
