<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        if ($request->get("quantity") > ($event->max_capacity - $event->tickets_sold)) {
            return response()->json(["message" => "Requested quantity must be available"]);
        }

        // User/company must meet age requirements for event
        $user = $request->attributes->get('user');
        $age = $user->date_of_birth ? Carbon::parse($user->date_of_birth)->diffInYears($now) : null;
        if (is_null($age) || $age < $event->min_age) {
            return response()->json(["message" => "User/company must meet age requirements for event"]);
        }

        // Maximum 8 tickets per reservation
        if ($request->get('quantity') > 8) {
            return response()->json(["message" => "Maximum 8 tickets per reservation"]);
        }

        // Cannot have existing active reservation for same event
        $existing = Reservation::where('event_id', $id)
            ->where('status', 'active')
            ->where('purchaser_type', $request->get('purchaser_type'))
            ->where('purchaser_id', $request->get('purchaser_type') === 'company'
                ? $request->get('company_id')
                : $request->attributes->get('user')->id
            )
            ->exists();

        if ($existing) {
            return response()->json(["message" => "Cannot have existing active reservation for same event"]);
        }


        // Creates reservation record with 5-minute expiry
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

        // Reduces available ticket count temporarily
        $event->tickets_sold += $request->get('quantity');
        $event->save();

        // Calculates total price including fees
        $category = $reservation->ticketCategory ?? null;
        $basePrice = $category ? $category->price : 0;
        $fees = 0.1 * $basePrice * $reservation->quantity;
        $totalPrice = ($basePrice * $reservation->quantity) + $fees;
        $reservation->total_price = $totalPrice;

        return response()->json($reservation, 201);
    }

    public function confirm($id, Request $request)
    {

        $reservation = Reservation::with('ticketCategory')->find($id);

        if (!$reservation) {
            return response()->json(["message" => "Reservation not found"]);
        }

        //Reservation must exist and belong to authenticated user
        if ($reservation->purchaser_id !== ($request->get('purchaser_type') === 'company'
                ? $request->get('company_id')
                : $request->attributes->get('user')->id)) {
            return response()->json(["message" => "Reservation must exist and belong to authenticated user"], 403);
        }

        //Reservation must not be expired (5-minute window)
        if (now()->greaterThan($reservation->expires_at)) {
            return response()->json(["message" => "Reservation must not be expired"], 410);
        }

        //Reservation must not be already confirmed
        if ($reservation->status === 'confirmed') {
            return response()->json(["message" => "Reservation must not be already confirmed"], 409);
        }

        //Payment method must be valid
        if (!$request->has('payment_method') || !in_array($request->get('payment_method'), ['credit_card', 'paypal'])) {
            return response()->json(["message" => "Payment method must be valid"], 422);
        }

        // Create ticket records with polymorphic purchasable relationship
        $tickets = [];
        for ($i = 0; $i < $reservation->quantity; $i++) {
            $tickets[] = Ticket::create([
                "event_id" => $reservation->event_id,
                "category_id" => $reservation->ticket_category_id,
                "purchasable_type" => ucfirst($reservation->purchaser_type),
                "purchasable_id" => $reservation->purchaser_id,
                "ticket_code" => 'TK-' . strtoupper(uniqid()),
                "price_paid" => $reservation->ticketCategory->price ?? 0,
                "status" => "active",
                'qr_code' => Str::random(32),
                "purchased_at" => now()
            ]);
        }

        // Update reservation status to confirmed
        $reservation->status = 'confirmed';
        $reservation->save();

        return response()->json(["message" => "email send", "tickets" => $tickets], 201);
    }

    public function cancel($id, Request $request)
    {

        $reservation = Reservation::find($id);

        //Reservation must exist and belong to authenticated user
        if (!$reservation || $reservation->purchaser_id !== ($request->get('purchaser_type') === 'company' ? $request->get('company_id') : $request->attributes->get('user')->id)) {
            return response()->json(["message" => "Reservation must exist and belong to authenticated user"], 403);
        }

        //Reservation must not be expired or confirmed
        if (now()->greaterThan($reservation->expires_at) || $reservation->status === 'confirmed') {
            return response()->json(["message" => "Reservation must not be expired or confirmed"], 410);
        }


        //Releases held tickets back to available pool
        $event = Event::find($reservation->event_id);
        if ($event && $reservation->quantity) {
            $event->tickets_sold = $event->tickets_sold - $reservation->quantity;
            $event->save();
        }

        //Marks reservation as cancelled
        $reservation->status = 'cancelled';
        $reservation->save();

        return response()->json(["message" => "Reservation cancelled successfully"]);
    }
}
