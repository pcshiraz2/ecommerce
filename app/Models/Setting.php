<?php

namespace App\Models;

use App\Models\Model;

class Setting extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
