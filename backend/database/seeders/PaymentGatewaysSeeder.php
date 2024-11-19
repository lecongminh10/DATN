<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaysSeeder extends Seeder
{
    public function run()
    {
        PaymentGateway::create([
            'name' => 'VNPay',
            'api_key' =>  env('VNP_TMN_CODE'), 
            'secret_key' =>  env('VNP_HASH_SECRET'), 
            'gateway_type' => 'online', 
            'deleted_by' => null, 
        ]);

        PaymentGateway::create([
            'name' => 'Cash',
            'api_key' => 'cash',
            'secret_key' => 'cash', 
            'gateway_type' => 'offline',
            'deleted_by' => null, 
        ]);
    }
}
