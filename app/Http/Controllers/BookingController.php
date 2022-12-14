<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingHasDays;
use App\Models\BookingHasPets;
use App\Models\Pets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    use ResponseTrait;

    #1: Pending Staff Confirmation, 2 : Staff Confirmed, 3: Staff Confirmed, 4: Completed

    public function enrollBusinessBooking(Request $request)
    {
        error_log(json_encode($request->all()));

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
                'service' => 'required|numeric|exists:services,id',
                'selected_dates' => 'required',
                'duration' => 'required',
                'picking_time' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'business_account_id' => $request->user,
                'service_id' => $request->service,
                'duration' => $request->duration,
                'picking_time' => $request->picking_time,
                'ref' => 'BUSBO' . str_pad(Booking::count(), 4, '0', STR_PAD_LEFT),
                'visits' => $request->has('visits') ? $request->visits : 0,
                'message' => $request->message,
                'status' => 1
            ];

            $bookingObj = Booking::create($data);

            foreach ($request->pets as $key => $pet) {
                $petData = [
                    'booking_id' => $bookingObj->id,
                    'pet_id' => $pet,
                    'status' => 1
                ];
                BookingHasPets::create($petData);
            }

            foreach ($request->selected_dates as $key => $date) {
                BookingHasDays::create([
                    'booking_id' => $bookingObj->id,
                    'date' => $date,
                    'status' => 1
                ]);
            }
            DB::commit();

            return $this->successResponse(data: "Booking Saved Successfully");
        } catch (\Throwable $th) {
            error_log($th);
        }
    }

    public function getBusinessAccountPendingBookingList(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $bookingRecords = Booking::where('business_account_id', $request->user)
                ->where('status', 1) #Read Guide on Top
                ->orderby('created_at', 'DESC')
                ->with('getBookingService')
                ->get();

            $responseData = [];
            $bookingData = [];

            foreach ($bookingRecords as $key => $bookingValue) {

                // GET BOOKING HAS PETS
                $bookingHasPets = BookingHasPets::where('booking_id', $bookingValue->id)
                    ->orderby('id', 'DESC')
                    ->with('getPet')
                    ->first();

                // GET BOOKING HAS DAYS
                $bookingHasDays = BookingHasDays::where('booking_id', $bookingValue->id)->get();

                $bookingData['bookingData'] = $bookingValue;
                $bookingData['bookingData']['get_booking_has_pets'] = $bookingHasPets;
                $bookingData['bookingData']['get_booking_has_days'] = $bookingHasDays;
                // $bookingData['bookingData']['get_booking_has_days'] = $bookingHasDays;

                $responseData[] = ['data' => $bookingData];
            }

            error_log(json_encode($responseData));
            return $this->successResponse(code: 200, data: $responseData);
        } catch (\Throwable $th) {
            error_log($th);
            return $this->errorResponse(data: "Something went wrong please try again");
        }
    }

    public function getBookingDetail(Request $request)
    {
        try {
            $bookingObj = Booking::where('id', $request->id)
                ->with('getBookingService')
                ->first();

            // GET BOOKING HAS PETS
            $bookingHasPets = BookingHasPets::where('booking_id', $bookingObj->id)
                ->orderby('id', 'DESC')
                ->with('getPet')
                ->first();
            $bookingHasDaysRecords[] = [
                $bookingHasPets,
            ];

            $bookingData['bookingData'] = $bookingObj;
            $bookingData['bookingData']['get_booking_has_pets'] = $bookingHasPets;
            return $this->successResponse(code: 200, data: $bookingData);
        } catch (\Throwable $th) {
            error_log($th);
        }
    }
}
