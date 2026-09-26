<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// chỉ tk bằng 1 dc phép lắng nghe channels
Broadcast::channel('admin.order-status', function ($user) {
    return $user->role === 1;
});

Broadcast::channel('order-status.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});