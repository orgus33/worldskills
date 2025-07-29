<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
