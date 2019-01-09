<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
