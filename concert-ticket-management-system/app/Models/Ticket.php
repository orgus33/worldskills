<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'category_id',
        'purchasable_type',
        'purchasable_id',
        'ticket_code',
        'price_paid',
        'status',
        'purchased_at',
        'qr_code'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}
