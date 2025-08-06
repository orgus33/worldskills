<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->attributes->get('user');

        $tickets = Ticket::where('purchasable_id', $user->id)->get();


        return response()->json($tickets);
   }

    public function show($id, Request $request)
    {
        $user = $request->attributes->get('user');

        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(["message" => "Ticket not found"], 404);
        }

        if ($ticket->purchasable_id != $user->id) {
            return response()->json(["message" => "Not authorized to view this ticket"], 403);
        }

        return response()->json($ticket);
    }
}
