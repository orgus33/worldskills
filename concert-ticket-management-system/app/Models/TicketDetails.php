<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetails extends Model
{
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function category() {
        return $this->belongsTo(TicketCategory::class);
    }
}
