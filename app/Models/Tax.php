<?php

namespace App\Models;

class Tax extends Model
{
    public function getNameAttribute()
    {
        $rate = $this->rate * 100;
        return "{$this->title} ({$rate} %)";
    }
}
