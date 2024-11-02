<?php

namespace App\Listeners;

use App\Events\UserEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UsersJson
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
    public function handle(UserEvent $event): void
    {
        $users = User::all();
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

        Log::info('Updated users data:', $responseData->toArray());

        $jsonFilePath = storage_path('app/public/users.json');
        file_put_contents($jsonFilePath, $responseData->toJson(JSON_PRETTY_PRINT));
    }
}
