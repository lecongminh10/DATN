<?php

namespace App\Listeners;

use App\Events\ProductEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProductsJson
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductEvent $event): void
    {
        $products = Product::all();
        $responseData = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price_regular' => $product->price_regular,
                'price_sale' => $product->price_sale,
                'short_description' => $product->short_description,
                'content' => $product->content,
            ];
        });

        Log::info('Updated products data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/products.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
    }
}
