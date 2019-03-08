<?php

namespace App\Models;


class Discussion extends Model
{
    public static function findWithCache($id)
    {
        if (Cache::has('discussion_' . $id)) {
            return Cache::get('discussion_' . $id);
        } else {
            $discussion = Page::findOrFail($id);
            Cache::forever('discussion_' . $id, $discussion);
            return $discussion;
        }
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\DiscussionPost');
    }
}
