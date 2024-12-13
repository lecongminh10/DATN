<?php

namespace App\Http\Controllers;

use App\Models\BannerExtra;
use App\Models\BannerMain;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // Banner Main
    public function list_banner_main()
    {
        $perPage = 5;
        $parentBanner = BannerMain::paginate($perPage);
        return view('admin.banner.banner-main.list-banner-main',  compact('parentBanner'));
    }

    public function banner_main_view_add()
    {
        return view('admin.banner.banner-main.add-banner-main');
    }

    public function banner_main_add(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'nullable|string|max:255', 
            'sub_title' => 'nullable|string|max:255', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Xác nhận ảnh và giới hạn dung lượng tối đa
            'price' => 'nullable|numeric', // Đảm bảo giá trị là số
            'title_button' => 'nullable|string|max:255',
        ]);

        // Tạo mới đối tượng BannerMain
        $bannerMain = new BannerMain();

        // Kiểm tra và xử lý ảnh (nếu có ảnh mới)
        if ($request->hasFile('image')) {
            // Lưu ảnh mới vào thư mục banner-main và cập nhật trường image
            $bannerMain->image = $request->file('image')->store('banner-main', 'public');
        }

        // Cập nhật các giá trị còn lại
        $bannerMain->title = $request->input('title');
        $bannerMain->sub_title = $request->input('sub_title');
        $bannerMain->price = $request->input('price');
        $bannerMain->title_button = $request->input('title_button');
        $bannerMain->active = $request->has('active') ? 1 : 0;

        // Lưu thông tin vào cơ sở dữ liệu
        $bannerMain->save(); // Dùng save() để lưu bản ghi mới

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Thêm banner chính thành công.');
    }

    public function banner_main_edit($id)
    {
        // Lấy thông tin banner theo id từ DB, nếu không tìm thấy sẽ trả về 404
        $bannerMain = BannerMain::findOrFail($id); // Nếu không tìm thấy sẽ trả về lỗi 404
        return view('admin.banner.banner-main.edit-banner-main', compact('bannerMain'));
    }

    public function banner_main_update(Request $request, $id)
    {
        // Xác thực dữ liệu
        // $request->validate([
        //     'title' => 'nullable|string|max:255', 
        //     'sub_title' => 'nullable|string|max:255', 
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Xác nhận ảnh và giới hạn dung lượng tối đa
        //     'price' => 'nullable|numeric', // Đảm bảo giá trị là số
        //     'title_button' => 'nullable|string|max:255',
        // ]);

        // Lấy bản ghi BannerMain theo id
        $bannerMain = BannerMain::findOrFail($id); // Nếu không tìm thấy sẽ trả về lỗi 404

        // Kiểm tra và xử lý ảnh (nếu có ảnh mới)
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ (nếu cần thiết) trước khi lưu ảnh mới
            if ($bannerMain->image && file_exists(public_path('storage/' . $bannerMain->image))) {
                unlink(public_path('storage/' . $bannerMain->image));
            }
            // Lưu ảnh mới vào thư mục banner-main và cập nhật trường image
            $bannerMain->image = $request->file('image')->store('banner-main', 'public');
        }

        // Cập nhật các giá trị còn lại
        $bannerMain->title = $request->input('title');
        $bannerMain->sub_title = $request->input('sub_title');
        $bannerMain->price = $request->input('price');
        $bannerMain->title_button = $request->input('title_button');
        $bannerMain->active = $request->has('active') ? 1 : 0;

        // Lưu thông tin vào cơ sở dữ liệu
        $bannerMain->update();

        // Trả về thông báo thành công
        return redirect()->route('admin.banner.list_banner_main')->with('success', 'Banner chính cập nhật thành công.');
    }

    // Banner Extra
    public function banner_extra_edit()
    {
        // Lấy thông tin info_boxes từ DB hoặc tạo đối tượng rỗng
        $bannerExtra = BannerExtra::firstOrNew([]);
        return view('admin.banner.banner-extra.edit-banner-extra', compact('bannerExtra'));
    }

    public function banner_extra_update(Request $request)
    {
        // $request->validate([
        //     'title_1' => 'nullable|string, 
        //     'title_2' => 'nullable|string,
        //     'title_3' => 'nullable|string,
        //     'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Xác nhận ảnh và giới hạn dung lượng tối đa
        //     'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Giới hạn dung lượng và loại ảnh
        //     'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Giới hạn dung lượng và loại ảnh
        //     'price_1' => 'nullable|numeric', // Đảm bảo giá trị là số
        //     'price_2' => 'nullable|numeric', // Đảm bảo giá trị là số
        //     'price_3' => 'nullable|numeric', // Đảm bảo giá trị là số
        //     'title_button_1' => 'nullable|string',
        //     'title_button_2' => 'nullable|string',
        //     'title_button_3' => 'nullable|string',
        // ]);

        // Kiểm tra nếu đã có bản ghi 'BannerExtra', nếu chưa thì tạo mới
        $bannerExtra = BannerExtra::first();
        if (!$bannerExtra) {
            $bannerExtra = new BannerExtra();
        }

        // Kiểm tra và xử lý ảnh (nếu có ảnh mới)
        if ($request->hasFile('image_1')) {
            // Xóa ảnh cũ (nếu cần thiết) trước khi lưu ảnh mới
            if ($bannerExtra->image_1 && file_exists(public_path('storage/' . $bannerExtra->image_1))) {
                unlink(public_path('storage/' . $bannerExtra->image_1));
            }
            // Lưu ảnh mới vào thư mục banner-extra và cập nhật trường image_1
            $bannerExtra->image_1 = $request->file('image_1')->store('banner-extra', 'public');
        }

        if ($request->hasFile('image_2')) {
            // Xóa ảnh cũ (nếu có) trước khi lưu ảnh mới
            if ($bannerExtra->image_2 && file_exists(public_path('storage/' . $bannerExtra->image_2))) {
                unlink(public_path('storage/' . $bannerExtra->image_2));
            }
            // Lưu ảnh mới vào thư mục banner-extra và cập nhật trường image_2
            $bannerExtra->image_2 = $request->file('image_2')->store('banner-extra', 'public');
        }

        if ($request->hasFile('image_3')) {
            // Xóa ảnh cũ (nếu có) trước khi lưu ảnh mới
            if ($bannerExtra->image_3 && file_exists(public_path('storage/' . $bannerExtra->image_3))) {
                unlink(public_path('storage/' . $bannerExtra->image_3));
            }
            // Lưu ảnh mới vào thư mục banner-extra và cập nhật trường image_3
            $bannerExtra->image_3 = $request->file('image_3')->store('banner-extra', 'public');
        }

        // Cập nhật các giá trị còn lại
        $bannerExtra->title_1 = $request->input('title_1');
        $bannerExtra->title_2 = $request->input('title_2');
        $bannerExtra->title_3 = $request->input('title_3');
        $bannerExtra->price_1 = $request->input('price_1');
        $bannerExtra->price_2 = $request->input('price_2');
        $bannerExtra->price_3 = $request->input('price_3');
        $bannerExtra->title_button_1 = $request->input('title_button_1');
        $bannerExtra->title_button_2 = $request->input('title_button_2');
        $bannerExtra->title_button_3 = $request->input('title_button_3');
        $bannerExtra->active = $request->has('active') ? 1 : 0;

        // Lưu thông tin vào cơ sở dữ liệu
        $bannerExtra->save();

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Banner phụ cập nhật thành công.');
    }

}
