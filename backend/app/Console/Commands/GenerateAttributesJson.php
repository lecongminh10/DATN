<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attribute;
use Illuminate\Support\Facades\Log;

class GenerateAttributesJson extends Command
{
    protected $signature = 'generate:attributes-json';
    protected $description = 'Generate attributes JSON file from database';

    public function handle()
    {
        $attributes = Attribute::with('attributeValues')->get();
        if ($attributes->isEmpty()) {
            $this->error('No attributes found in the database.');
            return;
        }
        $responseData = $attributes->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'name' => $attribute->attribute_name,
                'values' => $attribute->attributeValues->map(function ($value) {
                    return [
                        'id' => $value->id,
                        'attribute_value' => $value->attribute_value,
                    ];
                }),
            ];
        });
        Log::info('Generated attributes data:', $responseData->toArray());
        $jsonFilePath = storage_path('app/public/attributes.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
        $this->info('Attributes JSON file generated successfully!');
    }
}
