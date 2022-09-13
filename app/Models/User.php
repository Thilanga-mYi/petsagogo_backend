<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'company_address',
        'company_tel',
        'company_mobile',
        'company_email_address',
        'company_website',
        'company_business_start_date',
        'dob',
        'name',
        'username',
        'parent_user_id',
        'usertype',
        'tel',
        'email',
        'mobile',
        'password',
        'mobile_verified',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserPermissions($usertype)
    {
        return Permission::whereIn('id', UsertypePermissions::where('usertype', $usertype)->pluck('permission'))->get();
    }

    public function getClientHasPets()
    {
        return $this->hasOne(Pets::class, 'owner_id', 'id');
    }
}
