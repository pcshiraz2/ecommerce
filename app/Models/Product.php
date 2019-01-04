<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Conner\Tagging\Taggable;

class Product extends Model
{
    use SoftDeletes, Taggable;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function files()
    {
        return $this->hasMany('App\Models\ProductFile');
    }

    public function records()
    {
        return $this->hasMany('App\Models\Record');
    }

    public function getInventory()
    {
        if ($this->initial_balance) {
            $total = $this->initial_balance;
        } else {
            $total = 0;
        }
        $total += $this->records()->sum('quantity');
        return $total;
    }

    public function scopeTop($query)
    {
        return $query->where('top', 'yes');
    }


    public function scopeShop($query)
    {
        return $query->where('shop', 'yes');
    }

    public function scopePost($query)
    {
        return $query->where('post', 'yes');
    }
}
