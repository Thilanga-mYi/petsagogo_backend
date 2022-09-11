<?php

namespace App\Http\Controllers;

use App\Models\ServiceHasPaymentSettings;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function enrollServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'icon' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'user_id' => $request->user,
            'name' => $request->name,
            'icon' => $request->icon,
            'weekend_availibility' => $request->weekend_availability_status,
            'date_time_availibility' => $request->date_time_avilability_status,
            'add_time_restriction_note' => $request->add_time_restriction_note,
            'no_of_visit_availability' => $request->no_of_visit_availability_status,
            'no_of_visit_count' => $request->no_of_visit_count,
            'message' => $request->message,
        ];

        $serviceObj = Services::create($data);
        return $this->successResponse();
    }

    public function getAllServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeri|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [];
        $servicesObj = Services::where('user_id', $request->user)->with('paymentSettings');

        foreach ($servicesObj as $key => $service) {
            $data[] = [
                'name' => $service->name,
                'icon' => $service->icon,
                'weekend_availibility' => $service->weekend_availibility,
                'date_time_availibility' => $service->date_time_availibility,
                'add_time_restriction_note' => $service->add_time_restriction_note,
                'no_of_visit_availability' => $service->no_of_visit_availability,
                'no_of_visit_count' => $service->no_of_visit_count,
                'message' => $service->message,
            ];
        }

        return $this->successResponse(code: 200, data: ['servicesList' => $data]);
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
}
