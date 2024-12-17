<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\RefundService;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{

    public $orderService;
    public $refundService;
    public function __construct(OrderService $orderService, RefundService $refundService){
        $this->orderService = $orderService;
        $this->refundService = $refundService;
    }
    public function index(Request $request)
    {
        $filters = $request->all();

        $refunds = $this->refundService->searchRefund($filters);

        return view('admin.orders.refund', compact('refunds'));
    }

    public function store(Request $request)
    {

        $existingRefund = Refund::where('order_id', $request->order_code)
            ->where('status', Refund::STATUS_PENDING)
            ->first();

        if ($existingRefund) {
            return redirect()->back()->with('error', 'Đơn hàng này đã được yêu cầu hoàn trả trước đó.');
        }

        $order = $this->orderService->getDataOrderRefund($request->order_code);

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('refund_images', 'public');
                $imagePaths[] = $path;
            }
        }

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
        $refund->update($request->all());
        return redirect()->back()->with('success', 'Yêu cầu đã được cập nhật.');
    }
    public function createRefundForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('refunds.create', compact('order'));
    }
}
