<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    use ResponseTrait;

    public function enrollEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:users,id',
            'name' => 'required|string',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'allocated_booking_count' => 'nullable|numeric',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        if (Carbon::parse($request->start_date)->gt(Carbon::parse($request->end_date))) {
            return $this->errorResponse(data: 'Invalid Dates. Please Try Again');
        }

        if (Carbon::parse($request->start_date)->eq(Carbon::parse($request->end_date))) {
            if (Carbon::parse($request->start_time)->gt(Carbon::parse($request->end_time))) {
                return $this->errorResponse(data: 'Invalid Time Slot');
            }
            if (Carbon::parse($request->start_time)->eq(Carbon::parse($request->end_time))) {
                return $this->errorResponse(data: 'Invalid Time Slot');
            }
        }

        $data = [
            'user_id' => $request->user_id,
            'name' => $request->name,
            'start_date' => Carbon::parse($request->start_date),
            'start_time' => Carbon::parse($request->start_time),
            'end_date' => Carbon::parse($request->end_date),
            'end_time' => Carbon::parse($request->end_time),
            'allocated_booking_count' => $request->allocated_booking_count,
            'message' => $request->message,
            'status' => 2,
        ];

        Events::create($data);
        return $this->successResponse();
    }

    public function getAllEvents(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $eventsObj = Events::where('user_id', $request->user)->orderby('created_at', 'DESC')->get();
        return $this->successResponse(code: 200, data: $eventsObj);
    }
}
