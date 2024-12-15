<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Popuphome;
use Illuminate\Support\Facades\Storage;

class PopuphomeController extends Controller
{
    const PATH_UPLOAD = 'public/popuphome';

    public function edit()
    {
        // Lấy thông tin từ DB
        $popuphome = Popuphome::first();
        return view('admin.popuphome.edit', compact('popuphome'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $popuphome = Popuphome::first();
        if (!$popuphome) {
            $popuphome = new Popuphome();
        }
        
        $popuphome->title = $request->input('title');
        $popuphome->description = $request->input('description');
        $popuphome->active = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($popuphome->image) {
                Storage::delete($popuphome->image);
            }
            // Lưu ảnh mới và lấy đường dẫn
            $path = $request->file('image')->store(self::PATH_UPLOAD);
            $popuphome->image = $path;
        }

        $popuphome->save();

        return redirect()->back()->with('success', 'Cập nhật popup thành công.');
    }
}
