<?php

namespace App\Http\Controllers;

use App\Models\ServiceHasPaymentSettings;
use App\Models\Services;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\ServiceIcon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    use ResponseTrait;

    #STATUS: 2 = Save Without Payment, 1: Update with Adding Payment, 3: Deactivate 

    public function enrollServices(Request $request)
    {

        try {
            error_log(json_encode($request->all()));

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
                'name' => 'required|string',
                'icon' => 'required|numeric',
                'weekend_availibility' => 'required|numeric',
                'date_time_availibility' => 'required|numeric',
                'add_time_restriction_note' => 'nullable|string',
                'selected_time_shift' => 'nullable|numeric',
                'no_of_visit_availability' => 'required|numeric',
                'no_of_visit_count' => 'nullable|numeric',
                'message' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'user_id' => $request->user,
                'name' => $request->name,
                'icon' => $request->icon,
                'date_time_availibility' => $request->date_time_availibility,
                'weekend_availibility' => $request->weekend_availibility,
                'no_of_visit_availability' => $request->no_of_visit_availability,
                'status' => 1
            ];

            if ($request->has('message') && $request->filled('message')) {
                $data['message'] = $request->message;
            }

            if ($request->date_time_availibility == '1') {
                $data['selected_time_shift'] = $request->selected_time_shift;
                $data['add_time_restriction_note'] = $request->add_time_restriction_note;
            }

            if ($request->no_of_visit_availability == '1') {
                $data['no_of_visit_count'] = $request->no_of_visit_count;
            }

            Services::create($data);

            return $this->successResponse();
        } catch (\Throwable $th) {
            error_log($th);
        }
    }

    public function getAllServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        try {
            $data = [];

            // STATUS SHOULD BE CHANGED TO 1
            $serviceRecords = Services::where('user_id', $request->user)
                ->with('paymentSettings')
                ->with('iconData')
                ->get();

            foreach ($serviceRecords as $key => $value) {
                $value['image'] = $value['iconData']['image'];
                $data[] = $value;
            }

            return $this->successResponse(code: 200, data: $data);
        } catch (\Throwable $th) {
            error_log($th);
        }
    }

    public function enrollServicesPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
            'service' => 'required|numeric|exists:services,id',
            'thirty_min' => 'required|numeric',
            'one_hour' => 'required|numeric',
            'additional_hour_1' => 'required|numeric',
            'additional_visit_1' => 'required|numeric',
            'addition_pets_1' => 'required|numeric',
            'proce_per_services' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'user_id' => $request->user,
            'service_id' => $request->service,
            '30_min' => $request->thirty_min,
            '1_hour' => $request->one_hour,
            'additional_hour_1' => $request->additional_hour_1,
            'additional_visit_1' => $request->additional_visit_1,
            'additional_pets_1' => $request->additional_pets_1,
            'price_per_service' => $request->proce_per_services,
            'status' => 1,
        ];

        $serivceHasPaymentObj = ServiceHasPaymentSettings::create($data);
        return $this->successResponse(code: 200, data: ['serivceHasPaymentObj' => $serivceHasPaymentObj]);
    }

    public function getServiceIcons()
    {
        return $this->successResponse(code: 200, data: ServiceIcon::where('status', 1)->get());
    }

    public function enrollServicePayment(Request $request)
    {

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
                'service' => 'required|numeric|exists:services,id',
                'thirtymin' => 'required|numeric',
                'onehour' => 'required|numeric',
                'additional1hour' => 'required|numeric',
                'additional1visit' => 'required|numeric',
                'additional1pet' => 'required|numeric',
                'pricePerService' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'user_id' => $request->user,
                'service_id' => $request->service,
                '30_min' => $request->thirtymin,
                '1_hour' => $request->onehour,
                'additional_hour_1' => $request->additional1hour,
                'additional_visit_1' => $request->additional1visit,
                'additional_pets_1' => $request->additional1pet,
                'price_per_service' => $request->pricePerService,
            ];

            ServiceHasPaymentSettings::where('user_id', $request->user)
                ->where('service_id', $request->service)
                ->update(['status' => 2]);

            $shpObj = ServiceHasPaymentSettings::create($data);
            Services::where('id', $shpObj->service_id)->update(['status' => 1]);

            DB::commit();

            return $this->successResponse();
        } catch (\Throwable $th) {
            error_log($th);
            return $this->errorResponse(data: "Unable to Save Data, Something went wrong...");
        }
    }
}
