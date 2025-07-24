<?php

use App\Http\Controllers\CompanyTicketController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return response()->json(["test" => "test"]);
});



// Auth
Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);

// Events
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events/{id}/reserve', [ReservationController::class, 'store']);

// Reservations
Route::post('/reservations/{id}/confirm', [ReservationController::class, 'confirm']);
Route::delete('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);

// Tickets
Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/{id}', [TicketController::class, 'show']);

// Company Ticket
Route::get('/companies/{id}/tickets', [CompanyTicketController::class, 'index']);
