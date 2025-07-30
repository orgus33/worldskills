<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index($id, Request $request)
    {
        $tickets = Ticket::where('purchasable_id', $id)->get();


        return response()->json($tickets);
    }
}
