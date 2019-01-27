<?php

namespace App\Models;


class DiscussionPost extends Model
{
    public function discussion()
    {
        return $this->belongsTo('App\Models\Discussion');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
