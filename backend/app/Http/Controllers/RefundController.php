<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Refund;
use App\Services\OrderService;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundController extends Controller
{

    public $orderService;
    public $refundService;
    public function __construct(OrderService $orderService, RefundService $refundService){
        $this->orderService = $orderService;
        $this->refundService = $refundService;
    }
    // Trong Controller của bạn
    public function index(Request $request)
    {
        // Truyền dữ liệu tìm kiếm từ request vào service
        $filters = $request->all(); // Lấy tất cả các tham số tìm kiếm từ request

        // Gọi hàm tìm kiếm từ service và lấy dữ liệu hoàn trả
        $refunds = $this->refundService->searchRefund($filters);

        // Trả về view cùng với dữ liệu refund
        return view('admin.orders.refund', compact('refunds'));
    }

    public function store(Request $request)
    {
        // Hiển thị dữ liệu để debug (chỉ để kiểm tra)
        // dd($request->all());

        // Kiểm tra nếu đơn hàng đã được xử lý hoàn trả trước đó
        $existingRefund = Refund::where('order_id', $request->order_code)
            ->where('status', Refund::STATUS_PENDING)
            ->first();

        if ($existingRefund) {
            return redirect()->back()->with('error', 'Đơn hàng này đã được yêu cầu hoàn trả trước đó.');
        }

        // Xử lý lưu dữ liệu hoàn trả
        $order = $this->orderService->getDataOrderRefund($request->order_code);

        // Xử lý ảnh
        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('refund_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // Lưu yêu cầu hoàn trả vào database
        Refund::create([
            'user_id' => auth()->id(),
            'order_id' => $order->order_id,
            'quantity' => $order->quantity,
            'amount' => $order->amount,
            'refund_method' => $request->refund_method,
            'reason' => $request->reason,
            'image' => json_encode($imagePaths),
            'status' => Refund::STATUS_PENDING,
        ]);

        return redirect()->back()->with('success', 'Yêu cầu hoàn trả đã được gửi thành công!');
    }

    public function update(Request $request, Refund $refund)
    {
        $refund->update($request->only(['status']));
        return redirect()->back()->with('success', 'Yêu cầu đã được cập nhật.');
    }
    public function createRefundForm($orderId)
    {
        $order = Order::findOrFail($orderId); // Tìm đơn hàng theo ID
        return view('refunds.create', compact('order'));
    }
}
