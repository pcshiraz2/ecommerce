<?php

namespace App\Models;

use App\Models\Model;

class Record extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
