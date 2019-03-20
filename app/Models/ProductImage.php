<?php

namespace App\Models;


class ProductImage extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
