<?php

namespace App\Models;

class Address extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
