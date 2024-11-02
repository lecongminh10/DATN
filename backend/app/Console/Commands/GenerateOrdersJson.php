<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class GenerateOrdersJson extends Command
{
    protected $signature = 'generate:orders-json';
    protected $description = 'Generate orders JSON file from database';

    public function handle()
    {
        $orders = Order::with(['user', 'payment.paymentGateway'])->get();
        if ($orders->isEmpty()) {
            $this->error('No orders found in the database.');
            return;
        }
        $responseData = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'code' => $order->code,
                'total_price' => $order->total_price,
                'shipping_address_id' => $order->shipping_address_id,
                'payment_id' => $order->payment_id,
                'note' => $order->note,
                'status' => $order->status,
                'carrier_id' => $order->carrier_id,
                'tracking_number' => $order->tracking_number,
                'deleted_at' => $order->deleted_at,
                'deleted_by ' => $order->deleted_by ,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'user' => [
                    'email' => $order->user ? $order->user->email:null,
                ],
                'payment' => [
                    'paymentGateway' => [
                        'name' => $order->payment && $order->payment->paymentGateway ? $order->payment->paymentGateway->name:null, // Lấy tên cổng thanh toán từ quan hệ paymentGateway
                    ],
                ],
            ];
        });

        Log::info('Generated orders data:', $responseData->toArray());
        
        $jsonFilePath = storage_path('app/public/orders.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
        
        $this->info('Orders JSON file generated successfully!');
    }
}