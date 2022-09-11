<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends Controller
{
    public function enrollGeneralSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeri|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'user_id' => $request->user,
            'same_day_booking' => $request->same_day_booking,
            'weekend_bookings' => $request->weekend_bookings,
            'bookingday_closing_time' => $request->bookingday_closing_time,
            'per_day_max_bookings' => $request->per_day_max_bookings,
            'notice_period_hrs' => $request->notice_period_hrs,
            'refund' => $request->refund,
            'gps_availability_status' => $request->gps_availability_status,
            'booking_daily_closing_time' => $request->booking_daily_closing_time,
            'birthday_message' => $request->birthday_message,
            'message' => $request->message,
            'status' => 1,
        ];

        $generalSettingsObj = GeneralSettings::create($data);
        return $this->successResponse(code: 200, data: ['generalSettingsObj' => $generalSettingsObj]);
    }

    public function getGeneralSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeri|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $generalSettingsObj = GeneralSettings::where('user_id', $request->user)->first();
        return $this->successResponse(code: 200, data: ['generalSettingsObj' => $generalSettingsObj]);
    }
}
