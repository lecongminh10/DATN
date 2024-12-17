<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\UserReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = UserReview::with(['user','product', 'productVariant.attributeValues.attribute', 'product.galleries']);
        if ($request->has('product_name') && $request->product_name != '') {
            $query->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->product_name . '%');
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('review_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('review_date', '<=', $request->date_to);
        }

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

        return redirect()->route('admin.comment.index')->with('success', 'Đã trả lời bình luận thành công!');
    }
    public function showProductReviews($productId)
    {
        $product = Product::findOrFail($productId);

        $comments = UserReview::with(['user', 'product', 'productVariant.attributeValues.attribute'])
            ->where('product_id', $productId)
            ->get();

        $pages = Page::where('is_active', true) ->select('name', 'permalink')->get();
        return view('client.product-detail', compact('product', 'comments' ,'pages'));
    }
// public function store(Request $request)
// {
//     dd($request->all()); // Kiểm tra tất cả dữ liệu form

//     $request->validate([
//         'rating' => 'required|integer|between:1,5',
//         'review_text' => 'required|string',
//         'name' => 'required|string',
//         'email' => 'required|email',
//         'product_id' => 'required|exists:products,id',
//     ]);

//     UserReview::create([
//         'user_id' => auth()->id() ?: null,
//         'product_id' => $request->product_id,
//         'rating' => $request->rating,
//         'review_text' => $request->review_text,
//         'review_date' => now(),
//         'is_verified' => true,
//     ]);

//     return redirect()->back()->with('success', 'Review submitted successfully!');
// }
// public function show($id)
// {
//     // Lấy sản phẩm theo ID
//     $product = Product::findOrFail($id);

//     // Lấy tất cả các bình luận của sản phẩm (nếu có)
//     $comments = UserReview::where('product_id', $id)->get();

//     // Truyền biến $product và $comments vào view
//     return view('client.product-detail', compact('product', 'comments'));
// }
}

