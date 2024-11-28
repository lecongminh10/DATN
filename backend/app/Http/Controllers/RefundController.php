<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Refund;
use App\Services\OrderService;
use Illuminate\Http\Request;

class RefundController extends Controller
{

    public $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    public function index()
    {
        $refunds = Refund::with(['user', 'order', 'product'])->get();
        // dd($refunds);
        return view('admin.orders.refund', compact('refunds'));
    }

    public function store(Request $request)
    {
        $order = $this->orderService->getDataOrderRefund($request->order_code);
                
        // Lưu dữ liệu vào bảng refunds
        Refund::create([
            'user_id' => auth()->id(), // Lấy ID người dùng hiện tại
            'order_id' => $order->order_id,
            'quantity'=>$order->quantity,
            'amount' => $order->amount,
            'refund_method' => $request->refund_method,
            'reason' => $request->reason,
            'status' => Refund::STATUS_PENDING, // Trạng thái mặc định
        ]);

        // Chuyển hướng sau khi lưu thành công
        return redirect()->route('refunds.index')->with('success', 'Yêu cầu hoàn trả đã được gửi thành công!');
    }

    public function update(Request $request, Refund $refund)
    {
        $refund->update($request->only(['status', 'processed_at', 'rejection_reason']));
        return redirect()->back()->with('success', 'Yêu cầu đã được cập nhật.');
    }
    public function createRefundForm($orderId)
    {
        $order = Order::findOrFail($orderId); // Tìm đơn hàng theo ID
        return view('refunds.create', compact('order'));
    }
}
