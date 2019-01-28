<?php

namespace App\Models;


class City extends Model
{
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
