<?php

namespace App\Http\Controllers;

use App\Models\InfoBoxFooter;
use Illuminate\Http\Request;

class InfoBoxFooterController extends Controller
{

    public function edit()
    {
        // Lấy thông tin info_boxes từ DB hoặc tạo đối tượng rỗng
        $infoBoxFooter = InfoBoxFooter::firstOrNew([]);
        return view('admin.info_boxes_footer.edit', compact('infoBoxFooter'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_1' => 'nullable|string',
            'title_2' => 'nullable|string',
            'title_3' => 'nullable|string',
            'sub_title_1' => 'nullable|string',
            'sub_title_2' => 'nullable|string',
            'sub_title_3' => 'nullable|string',
            'description_support' => 'nullable|string',
            'description_payment' => 'nullable|string',
            'description_return' => 'nullable|string',
        ]);

        $infoBoxFooter = InfoBoxFooter::first();
        if (!$infoBoxFooter) {
            $infoBoxFooter = new InfoBoxFooter();
        }
        // Cập nhật các ô thông tin
        $infoBoxFooter->title_1 = $request->input('title_1');
        $infoBoxFooter->title_2 = $request->input('title_2');
        $infoBoxFooter->title_3 = $request->input('title_3');
        $infoBoxFooter->sub_title_1 = $request->input('sub_title_1');
        $infoBoxFooter->sub_title_2 = $request->input('sub_title_2');
        $infoBoxFooter->sub_title_3 = $request->input('sub_title_3');
        $infoBoxFooter->description_support = $request->input('description_support');
        $infoBoxFooter->description_payment = $request->input('description_payment');
        $infoBoxFooter->description_return = $request->input('description_return');
        $infoBoxFooter->active = $request->has('active') ? 1 : 0;
        $infoBoxFooter->save();

        return redirect()->back()->with('success', 'Info Boxes Footer cập nhật thành công.');
    }
}
