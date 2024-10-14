<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class GenerateTagsJson extends Command
{
    protected $signature = 'generate:tags-json';
    protected $description = 'Generate tags JSON file from database';

    public function handle()
    {
        $tags = Tag::all();
        if ($tags->isEmpty()) {
            $this->error('No tags found in the database.');
            return;
        }
        $responseData = $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
            ];
        });

        Log::info('Generated tags data:', $responseData->toArray());
        
        $jsonFilePath = storage_path('app/public/tags.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
        
        $this->info('Tags JSON file generated successfully!');
    }
}
