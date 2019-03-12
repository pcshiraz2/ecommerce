<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    public static function findWithCache($id)
    {
        if (Cache::has('product_' . $id)) {
            return Cache::get('product_' . $id);
        } else {
            $product = Product::findOrFail($id);
            Cache::forever('product_' . $id, $product);
            return $product;
        }
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function brand()
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

    public function scopeOfCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id);
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
