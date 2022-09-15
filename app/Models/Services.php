<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'weekend_availibility',
        'date_time_availibility',
        'add_time_restriction_note',
        'selected_time_shift',
        'no_of_visit_availability',
        'no_of_visit_count',
        'message',
        'status',
    ];

    public function paymentSettings()
    {
        return $this->hasOne(ServiceHasPaymentSettings::class, 'service_id', 'id');
    }

    public function iconData()
    {
        return $this->hasOne(ServiceIcon::class,'id','icon');
    }
    
}
