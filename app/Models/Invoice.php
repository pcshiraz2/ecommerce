<?php

namespace App\Models;


class Invoice extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
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

    public function getFullDescriptionAttribute()
    {
        return "{$this->description}<br />{$this->paid_at}";
    }
}
