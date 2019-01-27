<?php

namespace App\Models;


class InvoiceAttachment extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
