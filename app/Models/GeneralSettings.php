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
        'booking_daily_closing_time',
        'max_number_of_booking_per_day',
        'notice_period_hrs',
        'refund',
        'gps_status',
        'birthday_message',
        'booking_message',
        'status',
    ];
}
