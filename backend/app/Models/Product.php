<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'status',
        'slug',
        'category_id',
    ];

    // Thuộc về 1 danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Liên kết 1-N với bảng chi tiết
    public function detailProducts()
    {
        return $this->hasMany(DetailProduct::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
