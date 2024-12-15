<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order)
    {
        // Kiểm tra nếu trạng thái đơn hàng thay đổi thành 'hoàn thành'
        if ($order->isDirty('status') && $order->status == 'Hoàn thành') {
            // Tính toán điểm loyalty (ví dụ, 5% của tổng giá trị đơn hàng)
            $loyaltyPoints = $order->total_price * 0.0005;

            // Cập nhật điểm loyalty cho người dùng
            $user = User::find($order->user_id);
            $user->loyalty_points += $loyaltyPoints;
            $user->save();
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
