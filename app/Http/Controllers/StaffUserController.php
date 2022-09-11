<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;

class StaffUserController extends Controller
{

    use ResponseTrait;

    public function enrollStaffUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'password' => $request->password,
            'status' => 2,
        ];

        $user = User::create($data);
        return $this->successResponse(code: 200, data: ['user' => $user]);
    }

    public function getAllStaffUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|numeri|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [];
        $userRecords = User::where('parent_user_id', $request->user)->orderBy('name', 'ASC');

        foreach ($userRecords as $key => $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'profile_image' => $user->image,
            ];
        }

        return $this->successResponse(code: 200, data: ['staffList' => $data]);
    }
}
