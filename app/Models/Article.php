<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function findWithCache($id)
    {
        if (Cache::has('article_' . $id)) {
            return Cache::get('article_' . $id);
        } else {
            $article = Article::findOrFail($id);
            Cache::forever('article_' . $id, $article);
            return $article;
        }
    }
}
