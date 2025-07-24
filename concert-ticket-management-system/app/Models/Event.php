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

    public function ticketsWithEvent() {
        return $this->hasMany(TicketWithEvent::class);
    }

    public function ticketsDetail() {
        return $this->hasMany(TicketDetails::class);
    }

    public function companiesTicket()
    {
        return $this->hasMany(CompanyTicket::class);
    }
}
