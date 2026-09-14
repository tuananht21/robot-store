<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'middleware' => 'api', // Hoặc sanctum nếu dùng sanctum
    'prefix' => 'api/v1' // thêm prefix
]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
