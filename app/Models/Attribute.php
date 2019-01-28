<?php

namespace App\Models;


class Attribute extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
