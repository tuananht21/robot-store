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
    ];

    // Thuộc về một sản phẩm nào đó
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
