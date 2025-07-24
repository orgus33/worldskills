<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDetails extends Model
{
    public function category() {
        return $this->belongsTo(TicketCategory::class);
    }
}
