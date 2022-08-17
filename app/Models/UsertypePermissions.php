<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsertypePermissions extends Model
{
    use HasFactory;

    public function permissionData()
    {
        return $this->hasOne(Permission::class, 'id', 'permission');
    }

    public function usertypeData()
    {
        return $this->hasOne(UserType::class, 'id', 'usertype');
    }
}
