<?php

namespace App\Models;

class Product extends Model
{
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
        return $query->where('top', true);
    }

    public function scopeDiscount($query)
    {
        return $query->where('discount', true);
    }

    public function scopeNew($query)
    {
        return $query->orderBy('created_at', 'desc');
    }


    public function scopeShop($query)
    {
        return $query->where('shop', true);
    }

    public function scopePost($query)
    {
        return $query->where('post', true);
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price + $this->tax;
    }

    public function getFinalDiscountAttribute()
    {
        if($this->discount) {
            return $this->discount_price + $this->tax;
        } else {
            return $this->sale_price + $this->tax;
        }
    }
}
