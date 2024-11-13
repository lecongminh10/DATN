<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GenerateUsersJson extends Command
{
    protected $signature = 'generate:users-json';
    protected $description = 'Generate users JSON file from database';

    public function handle()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $this->error('No users found in the database.');
            return;
        }

        $responseData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->username,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'phone_number' => $user->phone_number,
                'status' => $user->status,
            ];
        });

        Log::info('Generated users data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/users.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));

        $this->info('Users JSON file generated successfully!');
    }
}
