<?php

namespace App\Models;

class ProductFile extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
