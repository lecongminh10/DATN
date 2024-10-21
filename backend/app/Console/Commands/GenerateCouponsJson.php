<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateCouponsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:coupons-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coupons = Coupon::with( 'categories', 'products')
            ->where('is_active', true) 
            ->get();

        if ($coupons->isEmpty()) {
            $this->error('No active coupons found in the database.');
            return;
        }

        $responseData=$coupons->map(function ($coupon) {
                return [
                    'id'                   => $coupon->id,
                    'code'                 => $coupon->code,
                    'applies_to'           => $coupon->applies_to,
                    'description'          => $coupon->description,
                    'discount_type'        => $coupon->discount_type,
                    'discount_value'       => $coupon->discount_value,
                    'max_discount_amount'  => $coupon->max_discount_amount,
                    'min_order_value'      => $coupon->min_order_value,
                    'start_date'           => $coupon->start_date,
                    'end_date'             => $coupon->end_date,
                    'usage_limit'          => $coupon->usage_limit,
                    'per_user_limit'       => $coupon->per_user_limit,
                    'is_active'            => $coupon->is_active,
                    'is_stackable'         => $coupon->is_stackable,
                    'eligible_users_only'  => $coupon->eligible_users_only,
                    'created_by'           => $coupon->created_by,
                ];
        });
        Log::info('Generated coupons data:', $responseData->toArray());
        $jsonFilePath = storage_path('app/public/coupons.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
        
        $this->info('coupons JSON file generated successfully!');
    }
}
