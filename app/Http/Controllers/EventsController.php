<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    public function enrollEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $data = [
            'name' => $request->name,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'allocated_booking_count' => $request->allocated_booking_count,
            'message' => $request->message,
            'status' => 2,
        ];

        Events::create($data);
        return $this->successResponse(code: 200);
    }

    public function getAllEvents(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [];
        $eventsObj = Events::where('user_id', $request->user)->orderby('created_date', 'DESC')->get();

        foreach ($eventsObj as $key => $event) {
            $data[] = [
                'name' => $event->name,
                'start_date' => $event->start_date,
                'start_time' => $event->start_time,
                'end_date' => $event->end_date,
                'end_time' => $event->end_time,
                'allocated_booking_count' => $event->allocated_booking_count,
                'pre_booked_count' => 0,
            ];
        }

        return $this->successResponse(code: 200, data: ['staffList' => $data]);
    }
}
