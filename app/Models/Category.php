<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use SoftDeletes;

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
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
            $categories = Category::where('type', $type)->get();
            Cache::forever('categories_' . $type, $categories);
            return $categories;
        }
    }
}
