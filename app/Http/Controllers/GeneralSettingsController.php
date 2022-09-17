<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;

class GeneralSettingsController extends Controller
{
    use ResponseTrait;

    public function enrollGeneralSettings(Request $request)
    {
        try {
            DB::beginTransaction();
            error_log(json_encode($request->all()));

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'same_day_booking' => $request->same_day_booking == 'true' ? 1 : 0,
                'weekend_bookings' => $request->weekend_booking == 'true' ? 1 : 0,
                'booking_daily_closing_time' => $request->booking_daily_closing_time,
                'max_number_of_booking_per_day' => $request->max_number_of_booking_per_day,
                'notice_period_hrs' => $request->notice_period_hrs,
                'refund' => $request->refund == null ? 0 : $request->refund,
                'gps_status' => $request->gps == 'true' ? 1 : 0,
                'birthday_message' => $request->birthday_message,
                'booking_message' => $request->message,
                'status' => 1,
            ];

            if (GeneralSettings::where('user_id', $request->user)->first()) {
                GeneralSettings::where('user_id', $request->user)->update($data);
            } else {
                $data['user_id'] = $request->user;
                GeneralSettings::create($data);
            }

            DB::commit();

            return $this->successResponse(code: 200, data: "General Settings Saved Successfully");
        } catch (\Throwable $th) {
            error_log($th);
        }
    }

    public function getGeneralSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $generalSettingsObj = GeneralSettings::where('user_id', $request->user)->first();
        return $this->successResponse(code: 200, data: $generalSettingsObj);
    }
}
