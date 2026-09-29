<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_from_id',
        'user_to_id',
        'message',
    ];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from_id');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_to_id');
    }
}