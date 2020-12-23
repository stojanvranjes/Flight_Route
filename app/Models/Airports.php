<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_id',
        'name',
        'cities_id',
        'countries_id',
        'IATA',
        'ICAO',
        'latitude',
        'longitude',
        'altitude',
        'timezone_offset',
        'DST',
        'timezone',
        'type',
        'source',
    ];
}
