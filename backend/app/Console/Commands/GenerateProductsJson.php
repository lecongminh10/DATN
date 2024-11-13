<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class GenerateProductsJson extends Command
{
    protected $signature = 'generate:products-json';
    protected $description = 'Generate products JSON file from database';

    public function handle()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            $this->error('No products found in the database.');
            return;
        }

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

        Log::info('Generated products data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/products.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));

        $this->info('Products JSON file generated successfully!');
    }
}
