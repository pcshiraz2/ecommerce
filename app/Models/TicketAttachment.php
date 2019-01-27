<?php

namespace App\Models;

class TicketAttachment extends Model
{
    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
