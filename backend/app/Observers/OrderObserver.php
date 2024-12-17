<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;

class OrderObserver
{
    public function created(Order $order): void
    {
        //
    }

    public function updated(Order $order)
    {
        // Kiểm tra nếu trạng thái đơn hàng thay đổi thành 'hoàn thành'
        if ($order->isDirty('status') && $order->status == 'Hoàn thành') {
            // Tính toán điểm loyalty (ví dụ, 5% của tổng giá trị đơn hàng)
            $loyaltyPoints = $order->total_price * 0.0005;

            $user = User::find($order->user_id);
            $user->loyalty_points += $loyaltyPoints;
            $user->save();
        }
    }

    public function deleted(Order $order): void
    {
        //
    }

    public function restored(Order $order): void
    {
        //
    }

    public function forceDeleted(Order $order): void
    {
        //
    }
}
