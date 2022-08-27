<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'image',
      'dob',
      'gender',
      'species',
      'breed',
      'male_neuterated',
      'injuries',
      'note',
      'status'  
    ];

}
