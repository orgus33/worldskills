<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_category_id',
        'quantity',
        'expires_at',
        'status',
        'purchaser_type',
        'purchaser_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}
