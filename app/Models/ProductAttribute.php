<?php

namespace App\Models;

class ProductAttribute extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }
}
