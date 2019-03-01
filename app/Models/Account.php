<?php

namespace App\Models;

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

    public function getNameAttribute()
    {
        return $this->title . '(' . \App\Utils\MoneyUtil::format($this->balance) .')';
    }
}
