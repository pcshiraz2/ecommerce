<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 1/3/2019
 * Time: 6:15 AM
 */

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

abstract class Model extends Eloquent
{
    use SoftDeletes, Sortable, Filterable;

    protected $dates = ['deleted_at'];

    public function scopeCollect($query, $sort = 'name')
    {
        $request = request();
        $input = $request->input();
        if(session('per-page')) {
            $limit = $request->get('limit', session('per-page'));
        } else {
            $limit = $request->get('limit', config('platform.per-page'));
        }
        return $query->filter($input)->sortable($sort)->paginate($limit);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', 1);
    }

    public function scopeDisabled($query)
    {
        return $query->where('enabled', 0);
    }
}