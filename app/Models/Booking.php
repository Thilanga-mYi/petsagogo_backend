<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_account_id',
        'service_id',
        'ref',
        'duration',
        'picking_time',
        'visits',
        'message',
        'status'
    ];

    public function getBookingService()
    {
        return $this->hasOne(Services::class, 'id', 'service_id')->with('iconData');
    }

    public function getBookingPets()
    {
        return $this->hasOne(BookingHasPets::class, 'booking_id', 'id')->with('getPet');
    }

    public function getBookingDays()
    {
        return $this->hasOne(BookingHasDays::class, 'booking_id', 'booking_id');
    }
}
