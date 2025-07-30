<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function store($id, Request $request)
    {
        // préréserver

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

        return response()->json($reservation, 201);
    }

    public function confirm($id, Request $request)
    {
        // confirmer
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
        // Annuler
        $reservation = Reservation::with('ticketCategory')->findOrFail($id);

        $reservation->status = 'cancel';
        $reservation->save();

        return response()->json(["message", "Reservation cancelled successfully"], 200);
    }
}
