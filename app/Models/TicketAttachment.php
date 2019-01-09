<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
