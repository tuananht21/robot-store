<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'path'
    ];

    // Ảnh thuộc về một sản phẩm robot cụ thể
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
