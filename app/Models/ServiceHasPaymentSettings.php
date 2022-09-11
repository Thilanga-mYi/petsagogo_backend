<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHasPaymentSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        '30_min',
        '1_hour',
        'additional_hour_1',
        'additional_visit_1',
        'additional_pets_1',
        'price_per_service',
        'status',
    ];

}
