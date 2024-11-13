<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class GenerateCategoriesJson extends Command
{
    protected $signature = 'generate:categories-json';
    protected $description = 'Generate categories JSON file from database';

    public function handle()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->error('No categories found in the database.');
            return;
        }

        $responseData = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ];
        });

        Log::info('Generated categories data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/categories.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));

        $this->info('Categories JSON file generated successfully!');
    }
}
