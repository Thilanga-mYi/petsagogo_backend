<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static $platform = [1 => 'MOBILE', 2 => 'WEB'];

    protected $fillable = ['route', 'platform', 'development_mode'];
}
