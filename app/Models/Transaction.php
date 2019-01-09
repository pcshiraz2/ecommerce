<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeBalance($query)
    {
        $query->where('invoice_id', null);
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeOfGateway($query, $gateway_id)
    {
        return $query->where('gateway_id', $gateway_id);
    }
}
