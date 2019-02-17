<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }


    public function getInventory()
    {
        return $this->transactions()->sum('amount');
    }

    public static function findWithCache($id)
    {
        if (Cache::has('category_' . $id)) {
            return Cache::get('category_' . $id);
        } else {
            $category = Category::findOrFail($id);
            Cache::forever('category_' . $id, $category);
            return $category;
        }
    }

    public static function findType($type)
    {
        if (Cache::has('categories_' . $type)) {
            return Cache::get('categories_' . $type);
        } else {
            $categories = Category::where('type', $type)->orderBy('order', 'asc')->get();
            Cache::forever('categories_' . $type, $categories);
            return $categories;
        }
    }
}
