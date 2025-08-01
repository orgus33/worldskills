<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get("per_page");

        $city = $request->get("city");
        $date_from = $request->get("date_from");
        $date_to = $request->get("date_to");
        $sort = $request->get("sort");

        $query = Event::query();

        if ($city) {
            $query->where('city', 'like', '%' . $city . '%');
        }

        if ($date_from) {
            $query->where('event_date', '>=', $date_from);
        }

        if ($date_to) {
            $query->where('event_date', '<=', $date_to);
        }

        // Récupérer le prix et faire le sort


        $events = $query->paginate($per_page ?? 15);

        return response()->json($events);
    }

    public function show($id)
    {
        $event = Event::with('ticketsCategory')->find($id);

        if (!$event) {
            return response()->json(["message" => "Event not found"], 404);
        }


        return response()->json($event);
    }
}
