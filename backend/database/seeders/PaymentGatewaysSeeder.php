<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateways;

class PaymentGatewaysSeeder extends Seeder
{
    public function run()
    {
        PaymentGateways::create([
            'name' => 'VNPay',
            'api_key' =>  env('VNP_TMN_CODE'), 
            'secret_key' =>  env('VNP_HASH_SECRET'), 
            'gateway_type' => 'online', 
            'deleted_by' => null, 
        ]);

        PaymentGateways::create([
            'name' => 'Cash',
            'api_key' => 'cash',
            'secret_key' => 'cash', 
            'gateway_type' => 'offline',
            'deleted_by' => null, 
        ]);
    }
}
