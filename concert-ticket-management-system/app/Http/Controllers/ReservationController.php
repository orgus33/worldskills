<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function store($id, Request $request)
    {
        // Event must exist and be active
        $event = Event::find($id);
        if (!$event) {
            return response()->json(["message" => "Event must exist and be active"]);
        }

        // Event must not be sold out
        if ($event->status === "sold_out") {
            return response()->json(["message" => "Event must not be sold out"]);
        }

        // Sale period must be active (after sale_starts_at, before event_date)
        $now = now();
        if ($now->isBefore($event->sale_starts_at) && $now->isAfter($event->sale_ends_at)) {
            return response()->json(["message" => "Sale period must be active"]);
        }

        // Requested quantity must be available
        if (($event->max_capacity - $event->tickets_sold) - $request->get("quantity")) {
            return response()->json(["message" => "Requested quantity must be available"]);
        }

        // User/company must meet age requirements for event
        $user = $request->attributes->get('user');
        if ($now->diff($user->date_of_birth) - $event->min_age >= 0) {
            return response()->json(["message" => "User/company must meet age requirements for event"]);
        }

        // Maximum 8 tickets per reservation
        if ($request->get('quantity') > 8) {
            return response()->json(["message" => "Maximum 8 tickets per reservation"]);
        }

        // Cannot have existing active reservation for same event




        $reservation = Reservation::make([
            "event_id" => $id,
            "ticket_category_id" => $request->get('category_id'),
            "quantity" => $request->get('quantity'),
            "expires_at" => now()->addMinutes(5)->toDateTimeString(),
            "status" => "active",
            "purchaser_type" => $request->get('purchaser_type'),
            "purchaser_id" => $request->get('purchaser_type') === 'company'
                ? $request->get('company_id')
                : $request->attributes->get('user')->id
        ]);

        $reservation->save();

        // LOGIC TODO :
        // Reduces available ticket count temporarily
        // Creates reservation record with 5-minute expiry
        // Calculates total price including fees

        return response()->json($reservation, 201);
    }

    public function confirm($id, Request $request)
    {
        $reservation = Reservation::with('ticketCategory')->findOrFail($id);

        $ticket = Ticket::make([
            "event_id" => $reservation->event_id,
            "category_id" => $reservation->ticket_category_id,
            "purchasable_type" => ucfirst($reservation->purchaser_type),
            "purchasable_id" => $reservation->purchaser_id,
            "ticket_code" => 'TK-' . strtoupper(uniqid()),
            "price_paid" => $reservation->ticketCategory->price,
            "status" => "active",
            "purchased_at" => now()
        ]);

        $ticket->save();

        $reservation->status = 'confirmed';
        $reservation->save();

        return response()->json($ticket, 201);
    }

    public function cancel($id, Request $request)
    {
        $reservation = Reservation::with('ticketCategory')->findOrFail($id);

        $reservation->status = 'cancel';
        $reservation->save();

        return response()->json(["message", "Reservation cancelled successfully"], 200);
    }
}
