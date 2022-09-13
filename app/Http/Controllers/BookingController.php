<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function enrollBusinessBooking(Request $request)
    {
        error_log(Carbon::parse($request->time)->format('H:i:s A'));
    }
}
