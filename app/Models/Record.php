<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
