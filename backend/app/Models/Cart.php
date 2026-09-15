<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'detail_product_id',
        'quantity',
    ];

    // Một dòng trong giỏ hàng thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailProduct()
    {
        return $this->belongsTo(DetailProduct::class, 'detail_product_id');
    }
}
