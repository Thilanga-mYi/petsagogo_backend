<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'same_day_booking',
        'weekend_bookings',
        'bookingday_closing_time',
        'per_day_max_bookings',
        'notice_period_hrs',
        'refund',
        'gps_availability_status',
        'booking_daily_closing_time',
        'birthday_message',
        'message',
        'status',
    ];
}
