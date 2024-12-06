<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Feedback;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // public function create()
    // {
    //     // Logic xử lý khi hiển thị form tạo feedback
    //     return view('client.feedbacks.create');

    // }

    public function create()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();
        $wishlistCount = WishList::where('user_id',$user)->count();

        // Truyền dữ liệu vào view
        return view('client.feedbacks.create', compact('user','carts', 'cartCount','wishlistCount'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'feedback_type' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'attachment_url' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:10240', // 10MB
        ]);

        // Lưu phản hồi vào cơ sở dữ liệu
        $feedback = new Feedback();
        $feedback->full_name = $validatedData['full_name'];
        $feedback->email = $validatedData['email'];
        $feedback->phone_number = $validatedData['phone_number'];
        $feedback->address = $validatedData['address'];
        $feedback->feedback_type = $validatedData['feedback_type'];
        $feedback->subject = $validatedData['subject'];
        $feedback->message = $validatedData['message'];
        $feedback->rating = $validatedData['rating'];

        // Xử lý tệp đính kèm nếu có
        if ($request->hasFile('attachment_url')) {
            $filePath = $request->file('attachment_url')->store('attachments', 'public');
            $feedback->attachment_url = $filePath;
        }

        $feedback->save();

        // Quay lại với thông báo thành công
        return redirect()->back()->with('success', 'Phản hồi của bạn đã được gửi thành công!');
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('client.feedback.show', compact('feedback'));
    }

}