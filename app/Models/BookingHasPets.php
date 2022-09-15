<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHasPets extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'pet_id',
        'statius'
    ];

    public function getPet()
    {
       return $this->belongsTo(Pets::class, 'pet_id');
    }
}
