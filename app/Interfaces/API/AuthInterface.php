<?php

namespace App\Interfaces\API;

interface AuthInterface{
    public function signup($data);
    public function login($data);
    public function resetPassword($data);
}