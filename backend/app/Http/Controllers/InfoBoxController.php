<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoBox;

class InfoBoxController extends Controller
{

    public function edit()
    {
        // Lấy thông tin các info_boxes từ DB
        $infoBox = InfoBox::first();
        return view('admin.info_boxes.edit', compact('infoBox'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title1' => 'nullable|string',
            'title2' => 'nullable|string',
            'title3' => 'nullable|string',
            'description_shopping' => 'nullable|string',
            'description_money' => 'nullable|string',
            'description_support' => 'nullable|string',
        ]);

        $infoBox = InfoBox::first();
        if (!$infoBox) {
            $infoBox = new InfoBox();
        }
        // Cập nhật các ô thông tin
        $infoBox->title1 = $request->input('title1');
        $infoBox->title2 = $request->input('title2');
        $infoBox->title3 = $request->input('title3');
        $infoBox->description_shopping = $request->input('description_shopping');
        $infoBox->description_money = $request->input('description_money');
        $infoBox->description_support = $request->input('description_support');
        $infoBox->active = $request->has('active') ? 1 : 0;
        $infoBox->save();

        return redirect()->back()->with('success', 'Info Boxes updated successfully.');
    }
}
