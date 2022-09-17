<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;

class StaffUserController extends Controller
{

    use ResponseTrait;

    public function enrollStaffUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
                'name' => 'required|string',
                'username' => 'required|string',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $data = [
                'usertype' => 2,
                'parent_user_id' => $request->user,
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'status' => 2,
            ];

            User::create($data);
            return $this->successResponse(code: 200, data: "Successfully Saved");
        } catch (\Throwable $th) {
            error_log($th);
            return $this->errorResponse(data: "Something went wrong");
        }
    }

    public function getStaffUsers(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }

            $userRecords = User::where('parent_user_id', $request->user)->orderBy('name', 'ASC')->get();
            return $this->successResponse(code: 200, data: $userRecords);
        } catch (\Throwable $th) {
            error_log($th);
        }
    }
}
