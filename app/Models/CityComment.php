<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cities_id',
        'users_id',
        'comment',
    ];
}
