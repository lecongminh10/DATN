<?php

namespace App\Http\Controllers;

use App\Models\BannerLeft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BannerLeftRequest;

class BannerLeftController extends Controller
{
    public function index()
    {
        $banners = BannerLeft::paginate(5)->all();
        return view('admin.banner.banner-left.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banner.banner-left.create');
    }
    public function store(BannerLeftRequest $request)
    {
        $request->validated();
        $bannerLeft = new BannerLeft();

        if ($request->hasFile('image')) {
            $bannerLeft->image = $request->file('image')->store('banner-left', 'public');
        }

        $bannerLeft->title = $request->input('title');
        $bannerLeft->sub_title = $request->input('sub_title');
        $bannerLeft->sale = $request->input('sale');
        $bannerLeft->description = $request->input('description');
        $bannerLeft->active = $request->has('active') ? 1 : 0;
        $bannerLeft->save();
        return redirect()->route('admin.banner.index')->with('success', 'Thêm banner thành công.');

    }

    public function edit($id)
    {
        $bannerLeft = BannerLeft::findOrFail($id);
        return view('admin.banner.banner-left.edit',compact('bannerLeft'));
    }

    public function update(BannerLeftRequest $request, $id)
{
    $request->validated();
    $bannerLeft = BannerLeft::findOrFail($id);

    if ($request->hasFile('image')) {
        if ($bannerLeft->image) {
            Storage::disk('public')->delete($bannerLeft->image);
        }
        $bannerLeft->image = $request->file('image')->store('banner-left', 'public');
    }

    $bannerLeft->title = $request->input('title');
    $bannerLeft->sub_title = $request->input('sub_title');
    $bannerLeft->sale = $request->input('sale');
    $bannerLeft->description = $request->input('description');
    $bannerLeft->active = $request->has('active') ? 1 : 0;

    $bannerLeft->save();

    return redirect()->route('admin.banner.index')->with('success', 'Cập nhật banner thành công.');
}

}
