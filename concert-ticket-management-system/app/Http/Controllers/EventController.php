<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request) {

        $page = $request->get("page");
        $per_page = $request->get("per_page");
        $city = $request->get("city");
        $date_from = $request->get("date_from");
        $date_to = $request->get("date_to");
        $sort = $request->get("sort");

        $events = Event::all();


        return response()->json([$events]);

    }

    public function show() {

    }

    public function store() {

    }
}
