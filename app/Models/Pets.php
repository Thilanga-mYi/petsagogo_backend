<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'user_id',
    'owner_id',
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

  public function getImageAttribute($value)
  {
      return asset('uploads/pets/'.$value);
  }
}
