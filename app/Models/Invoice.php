<?php

namespace App\Models;

use App\Models\Model;

class Invoice extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transactions()
    {
        return $this->belongsTo('App\Models\Transaction');
    }

    public function records()
    {
        return $this->hasMany('App\Models\Record');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\InvoiceAttachment');
    }


    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeDue($query)
    {
        return $query->where('status', '!=', 'paid');
    }

}
