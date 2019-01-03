<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
