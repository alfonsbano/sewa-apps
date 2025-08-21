<?php

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes/api.php
Route::get('/booked-dates', function() {
    $bookings = Transaction::where('status', 'confirmed')
        ->where('room_id', request('room_id'))
        ->get();
    
    $bookedDates = [];
    
    foreach ($bookings as $booking) {
        $start = new DateTime($booking->check_in_date);
        $end = new DateTime($booking->check_out_date);
        
        while ($start < $end) {
            $bookedDates[] = $start->format('Y-m-d');
            $start->modify('+1 day');
        }
    }
    
    return array_unique($bookedDates);
});
