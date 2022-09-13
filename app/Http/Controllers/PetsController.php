<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetsController extends Controller
{
    use ResponseTrait;

    public function enrollPet(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
            'owner' => 'required|numeric',
            'name' => 'required|string',
            'dob' => 'required',
            'gender' => 'required|numeric',
            'species' => 'required|string',
            'breed' => 'required|string',
            'male_neuterated' => 'required|numeric',
            'injuries' => 'required|string',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'user_id' => $request->user,
            'owner_id' => $request->owner,
            'name' => $request->name,
            'image' => '',
            'dob' => Carbon::parse($request->dob),
            'gender' => $request->gender,
            'species' => $request->species,
            'breed' => $request->breed,
            'male_neuterated' => $request->male_neuterated,
            'injuries' => $request->injuries,
            'note' => $request->note,
            'status' => 1
        ];

        try {
            Pets::create($data);
        } catch (\Throwable $th) {
            error_log($th);
        }
        return $this->successResponse();
    }

    public function getBusinessAccountPets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeric|exists:users,id',
            'owner' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        return $this->successResponse(code: 200, data: Pets::where('user_id', $request->user)->where('status', 1)->get());
    }

    public function getBusinessAccountPetsList(Request $request)
    {
        return $this->successResponse(code: 200, data: Pets::where('status',1)->where('user_id',$request->user)->get());
    }
}
