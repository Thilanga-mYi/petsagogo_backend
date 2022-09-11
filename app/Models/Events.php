<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'pre_booking_type',
        'allocated_booking_count',
        'message',
        'approved_admin',
        'admin_remark',
        'status',
    ];
}
