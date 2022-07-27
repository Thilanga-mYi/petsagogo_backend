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

    public function login($data)
    {
        
    }
    public function resetPassword($data)
    {
        //
    }
}
