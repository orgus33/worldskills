<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTicket extends Model
{
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function category() {
        return $this->belongsTo(TicketCategory::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
