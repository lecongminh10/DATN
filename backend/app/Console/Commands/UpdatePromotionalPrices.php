<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePromotionalPrices extends Command
{
    protected $signature = 'promotions:update';
    protected $description = 'Update promotional prices based on promotion_end_time';

    public function handle()
    {
        $now = Carbon::now();

        // Log the current date and time
        Log::info('Running promotional price update at: ' . $now);

        // Update price_sale in products where promotion_end_time is less than now
        $updatedProductsCount = DB::table('products')
            ->where('promotion_end_time', '<', $now)
            ->update(['price_sale' => null]);

        // Log the number of products updated
        Log::info('Updated products: ' . $updatedProductsCount);

        // Update price_modifier in product_variants where promotion_end_time is less than now
        $updatedVariantsCount = DB::table('product_variants')
            ->where('promotion_end_time', '<', $now)
            ->update(['price_modifier' => null]);

        // Log the number of product variants updated
        Log::info('Updated product variants: ' . $updatedVariantsCount);

        $this->info('Promotional prices have been updated successfully.');
    }
}
