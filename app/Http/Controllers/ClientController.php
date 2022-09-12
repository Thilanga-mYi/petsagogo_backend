<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    use ResponseTrait;

    public function enrollClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string|min:10|max:11',
            'email' => 'required|email|unique:users',
            'address' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }
        try {
            DB::beginTransaction();
            $userDataObj = [
                'usertype' => 3,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ];

            $userObj = User::create($userDataObj);

            foreach ($request->petObj as $key => $petObj) {

                $image = $petObj['image'];  // your base64 encoded
                $image = str_replace(' ', '+', $image);
                $imageName =  Carbon::now()->format('YmdHmis') . '.' . 'png';
                File::put(public_path() . '/uploads/pets/' . $imageName, base64_decode($image));

                $petData = [
                    'name' => $petObj['name'],
                    'user_id' => $petObj['user'],
                    'owner_id' => $userObj->id,
                    'image' => $imageName,
                    'dob' => $petObj['dob'],
                    'gender' => $petObj['gender'],
                    'species' => $petObj['species'],
                    'breed' => $petObj['breed'],
                    'male_neuterated' => $petObj['male_neuterated'] == 0 ? 1 : 2,
                    'injuries' => $petObj['injuries'],
                    'note' => $petObj['note'],
                    'status' => 1,
                ];

                Pets::create($petData);

                DB::commit();
            }
            return $this->successResponse(code: 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            error_log($th);
            return $this->errorResponse(data: 'Something went wrong. Please try again');
        }
    }
}
