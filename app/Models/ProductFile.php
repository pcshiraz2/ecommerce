<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ProductFile extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('age', function (Builder $builder) {
            $builder->where('enabled', '=', true);
        });
    }


    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
