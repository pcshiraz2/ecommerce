<?php


namespace App\Models;

use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
