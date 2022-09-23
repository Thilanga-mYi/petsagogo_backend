<?php

namespace App\Http\Controllers\API;

use App\Interfaces\API\AuthInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    use ResponseTrait;

    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function signupBusiness(Request $request)
    {

        error_log(json_encode($request->all()));

       try {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'company_tel' => 'required|string',
            'company_username' => 'required|string|unique:users,username',
            'company_mobile' => 'required|string:max:10',
            'company_email_address' => 'required|email|unique:users,company_email_address',
            'company_website' => 'required|string',
            'company_business_start_date' => 'required|date',
            'password' =>  'required|string|min:6|confirmed',
            'name' => 'required|string',
            'dob' => 'required|date',
            'address' => 'required|string',
            'tel' => 'required|string|max:10',
            'mobile' => 'required|string:max:10',
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'usertype' => 1,
            'company_name' => $request->company_name,
            'company_name' => $request->company_name,
            'username' => $request->company_username,
            'company_address' => $request->company_address,
            'company_tel' => $request->company_tel,
            'company_mobile' => $request->company_mobile,
            'company_email_address' => $request->company_email_address,
            'company_website' => $request->company_website,
            'company_business_start_date' => $request->company_business_start_date,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'dob' => $request->dob,
            'address' => $request->address,
            'tel' => $request->tel,
            'mobile' => $request->mobile,
            'email' => $request->email
        ];

        $this->authInterface->signup($data);

        return $this->successResponse();
       } catch (\Throwable $th) {
        Log::info($th);
       }
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string|min:10|max:11',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }

        $data = [
            'usertype' => 3,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password)
        ];

        $this->authInterface->signup($data);

        return $this->successResponse();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }
        $user = $this->authInterface->login($request->email);
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Login Client')->plainTextToken;
                $user['permissions'] = User::getUserPermissions($user->usertype);
                return $this->successResponse(code: 200, data: ['token' => $token, 'user' => $user]);
            } else {
                return $this->errorResponse(code: 422, data: 'Credentials mismatch');
                //hello
            }
        } else {
            return $this->errorResponse(code: 422, data: 'Credentials mismatch');
        }
    }

    public function verify()
    {
        $user = Auth::user();
        $user['permissions'] = User::getUserPermissions($user->usertype);
        return $this->successResponse(code: 200, data: ['user' => $user]);
    }

    public function emailVerify($encordedEmail)
    {
    }

    public function mobileVerify($encordedMobile)
    {
    }
}
