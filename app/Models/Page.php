<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    public $sortable = ['title'];

    public static function findWithCache($id)
    {
        if (Cache::has('page_' . $id)) {
            return Cache::get('page_' . $id);
        } else {
            $page = Page::findOrFail($id);
            Cache::forever('page_' . $id, $page);
            return $page;
        }
    }
}
