<?php

namespace App\Models;

class Ticket extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\TicketAttachment');
    }

    public function replays()
    {
        return $this->hasMany('App\TicketReplay');
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOpen($query)
    {
        $query->whereIn('status', ['staff', 'user', 'waiting']);
    }

    public function scopeClose($query)
    {
        $query->whereIn('status', ['close', 'force_close']);
    }
}
