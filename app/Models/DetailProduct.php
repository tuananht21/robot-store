<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailProduct extends Model
{
    protected $fillable = ['color', 'price', 'sale_price', 'version', 'product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(Specification::class);
    }

    public function inStock(): HasOne
    {
        return $this->hasOne(InStock::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}