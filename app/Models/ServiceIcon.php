<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceIcon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'status'];

    public function getImageAttribute($value)
    {
        return asset('uploads/service_icons/'.$value);
    }
}
