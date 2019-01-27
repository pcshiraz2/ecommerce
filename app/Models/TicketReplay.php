<?php

namespace App\Models;

class TicketReplay extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
