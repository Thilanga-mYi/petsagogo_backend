<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHasDays extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'day_id',
        'start_time',
        'status'
    ];
}
