<?php

namespace App\Repositories;

use App\Interfaces\API\AuthInterface;
use App\Models\User;
use App\Traits\ResponseTrait;

class AuthRepository implements AuthInterface
{

    use ResponseTrait;

    public function signup($data)
    {
        return User::create($data);
    }

    public function login($email)
    {
        return User::where('email', $email)->first();
    }

    public function resetPassword($data)
    {
        //
    }

    public function sendEmailVerification($email)
    {
        //
    }

    public function sendMobileVerification($mobile)
    {
        //
    }

    public function emailVerify($encordedCode)
    {
        $decordedText = base64_decode($encordedCode);
        $user=User::where('email',$decordedText)->where('email_verified',2)->first();
        if($user){
            User::where('email',$decordedText)->update(['email_verified'=>1]);
            return 1;
        }else{
            return 2;
        }
    }

    public function mobileVerify($encordedCode)
    {
        $decordedText = base64_decode($encordedCode);
        $user=User::where('mobile',$decordedText)->where('mobile_verified',2)->first();
        if($user){
            User::where('mobile',$decordedText)->update(['mobile_verified'=>1]);
            return 1;
        }else{
            return 2;
        }
    }
}
