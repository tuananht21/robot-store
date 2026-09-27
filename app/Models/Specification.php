<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specification extends Model
{
    protected $fillable = ['spec_name', 'spec_value', 'detail_product_id'];

    public function detailProduct(): BelongsTo
    {
        return $this->belongsTo(DetailProduct::class);
    }
}