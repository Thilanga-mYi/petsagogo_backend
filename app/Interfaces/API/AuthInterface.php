<?php

namespace App\Interfaces\API;

interface AuthInterface{
    public function signup($data);
    public function login($data);
    public function sendEmailVerification($email);
    public function sendMobileVerification($mobile);
    public function resetPassword($data);
    public function emailVerify($encordedCode);
    public function mobileVerify($encordedCode);
}