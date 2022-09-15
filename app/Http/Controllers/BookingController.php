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

    public function enrollBusinessBooking(Request $request)
    {
        error_log(json_encode($request->all()));
        // error_log(Carbon::parse($request->time)->format('H:i:s A'));

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
                'service' => 'required|numeric|exists:services,id',
                'from' => 'required',
                'to' => 'required',
                'day' => 'required',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'business_account_id' => $request->user,
                'service_id' => $request->service,
                'ref' => 'BUSBO' . str_pad(Booking::count(), 4, '0', STR_PAD_LEFT),
                'start_date' => Carbon::parse($request->from),
                'end_date' => Carbon::parse($request->to),
                'time' => Carbon::parse($request->time)->format('H:i:s A'),
                'visits' => $request->has('visits') ? $request->visits : 0,
                'message' => $request->message,
                'status' => 1
            ];

            error_log(json_encode($data));

            $bookingObj = Booking::create($data);

            foreach ($request->pets as $key => $pet) {
                $petData = [
                    'booking_id' => $bookingObj->id,
                    'pet_id' => $pet,
                    'status' => 1
                ];
                BookingHasPets::create($petData);
            }

            $bookingDayData = [
                'booking_id' => $bookingObj->id,
                'day_id' => $request->day,
                'start_time' => Carbon::parse($request->time)->format('H:i:s A'),
                'status' => 1
            ];

            BookingHasDays::create($bookingDayData);
            DB::commit();

            return $this->successResponse(data: "Booking Saved Successfully");
        } catch (\Throwable $th) {
            error_log($th);
        }
    }

    public function getBusinessAccountPendingActiveBookingList(Request $request)
    {
        error_log('------------------------');

        try {

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $bookingRecords = Booking::where('business_account_id', $request->user)
                ->where('status', '!=', 3)
                ->where('status', '!=', 3)
                ->with('getBookingService')
                ->get();


            $bookingHasPetsRecords = [];
            $bookingHasDaysRecords = [];

            foreach ($bookingRecords as $key => $bookingValue) {

                // GET BOOKING HAS PETS
                $bookingHasPets = BookingHasPets::where('booking_id', $bookingValue->id)
                    ->orderby('id', 'DESC')
                    ->with('getPet')
                    ->first();
                // $bookingHasDaysRecords
                $bookingHasDaysRecords[] = [
                    $bookingHasPets,
                ];

                // GET BOOKING HAS DAYS
                // $bookingHasDays = BookingHasDays::where('booking_id', $bookingValue->id)->get();
                $bookingHasDays = BookingHasDays::where('booking_id', $bookingValue->id)->first();
                $bookingHasPetsRecords[] = [
                    $bookingHasDays,
                ];
            }

            $responseData[] = [
                'bookingData' => $bookingRecords,
                'bookingPetsData' => $bookingHasPetsRecords,
                'bookingDaysData' => $bookingHasDaysRecords,
            ];

            error_log(json_encode($responseData));
            return $this->successResponse(code: 200, data: $responseData);
        } catch (\Throwable $th) {
            error_log($th);
            return $this->errorResponse(data: "Something went wrong please try again");
        }
    }
}
