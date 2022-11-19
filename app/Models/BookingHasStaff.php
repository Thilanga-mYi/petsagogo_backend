<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHasStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_account_id',
        'staff_id',
        'booking_id',
        'status',
    ];
}
