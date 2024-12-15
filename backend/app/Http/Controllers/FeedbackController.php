<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Hiển thị danh sách phản hồi
    public function index()
    {
        $feedbacks = Feedback::paginate(10);
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    // Hiển thị chi tiết phản hồi
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedbacks.show', compact('feedback'));
    }

    // Cập nhật trạng thái phản hồi
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'response' => 'nullable|string'
        ]);

        $feedback = Feedback::findOrFail($id);

        // Update the feedback's status and response
        $feedback->update([
            'status' => $request->status,
            'admin_response' => $request->response
        ]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Trạng thái phản hồi và trả lời đã được cập nhật.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Phản hồi đã được xóa mềm.');
    }


}