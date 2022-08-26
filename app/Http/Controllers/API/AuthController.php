<?php

namespace App\Http\Controllers\API;

use App\Interfaces\API\AuthInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    use ResponseTrait;

    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
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
            'email' => 'required|string|email|max:255',
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
