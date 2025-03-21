<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('broadcast-coupon', function () {
    return true;
});
Broadcast::channel('message', function ($user) {
    return true; // Hoặc điều kiện xác thực người dùng
});

Broadcast::channel('usersonline', function ($user) {
    return true;
});

Broadcast::channel('chat.{romId}', function () {
    return true; 
});
Broadcast::channel('notification_message', function ($user) {
    return true;
});