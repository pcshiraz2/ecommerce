<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    public function getInventory()
    {
        return $this->transactions()->sum('amount');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
