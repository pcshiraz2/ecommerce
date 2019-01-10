<?php

namespace App\Models;

use App\Models\Model;

class Account extends Model
{
    public function getInventory()
    {
        return $this->transactions()->sum('amount');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
