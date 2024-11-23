<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateLoyaltyPoints extends Command
{
    protected $signature = 'loyalty:update';
    protected $description = 'Update loyalty points for completed orders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Kiểm tra các đơn hàng đã hoàn thành
        $orders = Order::where('status', Order::HOAN_THANH)->get();

        foreach ($orders as $order) {
            // Tính toán điểm loyalty
            $loyaltyPoints = $order->total_price * 0.0005;

            // Cập nhật điểm loyalty cho người dùng
            $user = User::find($order->user_id);
            if ($user) {
                $user->loyalty_points += $loyaltyPoints;
                $user->save();
            }
        }

        $this->info('Loyalty points updated successfully.');
    }
}
