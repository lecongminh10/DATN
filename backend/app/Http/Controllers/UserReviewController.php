<?php

namespace App\Http\Controllers;

use App\Models\UserReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query builder
        $query = UserReview::with(['user','product', 'productVariant.attributeValues.attribute', 'product.galleries']);
        // dd($query);
        // Lọc theo tên sản phẩm
        if ($request->has('product_name') && $request->product_name != '') {
            $query->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->product_name . '%');
            });
        }

        // Lọc theo ngày bắt đầu
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('review_date', '>=', $request->date_from);
        }

        // Lọc theo ngày kết thúc
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('review_date', '<=', $request->date_to);
        }

        // Phân trang
        $comment = $query->paginate(10);

        return view('admin.comment.index', compact('comment'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_text' => 'required|string',
        ]);

        $comment = UserReview::findOrFail($id);
        $comment->update([
            'reply_text' => $request->reply_text,
            'reply_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Đã trả lời bình luận thành công!');
    }
}

