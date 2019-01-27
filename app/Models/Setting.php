<?php

namespace App\Models;

class Setting extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
