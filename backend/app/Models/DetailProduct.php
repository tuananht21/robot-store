<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    //
    use HasFactory;

    protected $table = 'detail_products';

    protected $fillable = [
        'product_id',
        'price',
        'sale_price',
        'version',
        'stock',
    ];

    // Thuộc về một sản phẩm nào đó
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Một phiên bản chi tiết sản phẩm có thể nằm trong nhiều giỏ hàng
    public function carts()
    {
        return $this->hasMany(Cart::class, 'detail_product_id');
    }

    // Một phiên bản chi tiết sản phẩm có thể nằm trong nhiều chi tiết đơn hàng
    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'detail_product_id');
    }
}
