<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function transactions()
    {
        return $this->belongsTo('App\Transaction');
    }

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function attachments()
    {
        return $this->hasMany('App\InvoiceAttachment');
    }


    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }


}
