<?php

namespace App\Models;

class Service extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
