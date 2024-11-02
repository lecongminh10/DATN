<?php

namespace App\Listeners;

use App\Events\CategoryEvent;
use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CategoriesJson
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
    public function handle(CategoryEvent $event): void
    {
        $categories = Category::all();
        $responseData = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ];
        });

        Log::info('Updated categories data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/categories.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
    }
}
