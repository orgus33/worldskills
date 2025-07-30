<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'max_quantity',
        'available_quantity',
        'position'
    ];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }
}
