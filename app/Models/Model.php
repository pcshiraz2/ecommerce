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
use Conner\Tagging\Taggable;

class Model extends Eloquent
{
    use SoftDeletes, Sortable, Filterable, Taggable;

    protected $dates = ['deleted_at'];
    protected $casts = ['options' => 'array'];

    public function scopeCollect($query, $sort = 'name')
    {
        $request = request();
        $input = $request->input();
        if(session('per-page')) {
            $limit = $request->get('limit', session('per-page'));
        } else {
            $limit = $request->get('limit', config('platform.per-page'));
        }
        //dd($input, $query->filter($input)->sortable($sort));

        return $query->filter($input)->sortable($sort)->paginate($limit);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeDisabled($query)
    {
        return $query->where('enabled', false);
    }
}