<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'address',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
    ];

    // Đơn hàng được mua bởi một tài khoản User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đơn hàng có thể mua nhiều món/dòng robot chi tiết
    public function details()
    {
        return $this->hasMany(DetailOrder::class, 'order_id');
    }
}
