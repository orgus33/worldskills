<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'venu_name',
        'venu_address',
        'city',
        'event_date',
        'doors_open',
        'sale_starts_at',
        'sale_ends_at',
        'min_age',
        'max_capacity',
        'tickets_sold',
        'status',
        'image_url',
        'ticket_category_id'
    ];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function ticketsCategory() {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }
}
