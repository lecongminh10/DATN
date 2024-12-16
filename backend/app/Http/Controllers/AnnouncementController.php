<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Hiển thị thông báo
    public function edit()
    {
        // Lấy thông báo duy nhất từ bảng announcements
        $announcement = Announcement::first();

        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(Request $request)
    {
        // Lấy thông báo duy nhất từ bảng announcements
        $announcement = Announcement::first();

        // Nếu thông báo chưa tồn tại, tạo bản ghi mới
        if (!$announcement) {
            $announcement = new Announcement();
        }

        // Cập nhật thông tin thông báo
        $announcement->message = $request->input('message');
        $announcement->discount_percentage = $request->input('discount_percentage');
        $announcement->category = $request->input('category');
        $announcement->start_date = $request->input('start_date');
        $announcement->end_date = $request->input('end_date');

        // Chuyển đổi giá trị của 'active' thành kiểu boolean (1 hoặc 0)
        $announcement->active = $request->has('active') ? 1 : 0;

        // Lưu thông báo
        $announcement->save();

        return redirect()->route('admin.announcement.edit')->with('success', 'Thông báo đã được cập nhật.');
    }
    public function showClientAnnouncement()
    {
        // Lấy thông báo đang hoạt động và trong khoảng thời gian hợp lệ
        $announcement = Announcement::where('active', true)
                                   ->where('start_date', '<=', now())
                                   ->where('end_date', '>=', now())
                                   ->first();
        $pages = Page::where('is_active', true) ->select('name', 'permalink')->get();
        return view('client.advertising_bar.index', compact('announcement','pages'));
    }
}
