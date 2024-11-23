<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    const PATH_UPLOAD = 'public/profile';
    public function index()
    {
        // Lấy thông tin người dùng đã đăng nhập
        $user = Auth::user();

        // Trả về view cùng với dữ liệu người dùng
        return view('admin.profile.index', compact('user'));
    } 
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    // Xử lý cập nhật hồ sơ
    public function update(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Xác thực ảnh đại diện
        ]);
    
        // Lấy thông tin người dùng đã đăng nhập
        $user = Auth::user();
    
        // Cập nhật các trường thông tin khác
        $user->username = $request->username;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
    
        // Kiểm tra và lưu ảnh đại diện mới nếu có tải lên
        if ($request->hasFile('profile_picture')) {
            // Xóa ảnh cũ nếu có
            if ($user->profile_picture) {
                // Xóa ảnh cũ từ thư mục
                Storage::delete($user->profile_picture);
            }
    
            // Lưu ảnh mới vào thư mục 'profile_pictures'
            $path = $request->file('profile_picture')->store(self::PATH_UPLOAD);
            $user->profile_picture = $path; // Cập nhật đường dẫn ảnh mới vào cơ sở dữ liệu
        }
    
        // Lưu thông tin người dùng đã được cập nhật
        $user->save();
    
        // Chuyển hướng về trang hồ sơ với thông báo thành công
        return redirect()->route('admin.profile.edit')->with('success', 'Hồ sơ đã được cập nhật thành công.');
    }
    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Đảm bảo mật khẩu mới dài ít nhất 8 ký tự và khớp
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Chuyển hướng về trang hồ sơ với thông báo thành công
        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
