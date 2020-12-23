<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Airports;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\Cities;

class UploadFileAirport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * UploadFileAirport constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if (!Storage::exists('airport/airport.txt')) {
            return false;
        }

        $routesFile = Storage::path('airport/airport.txt');

        $allAirports = array_map('str_getcsv', file($routesFile, FILE_IGNORE_NEW_LINES));

        foreach ($allAirports as $airport){

            list($airport_id, $name, $city, $country, $iata, $icao, $latitude, $longitude, $altitude, $timezone_offset, $dst, $timezone, $type, $source) = $airport;

            // skip if no city or county
            if (!$city || !$country) {
                continue;
            }

            // create country
            $country = Country::firstOrCreate(['name' => $country]);

            // create city
            $city = Cities::firstOrCreate(['name' => $city, 'countries_id' => $country->id]);

            // insert
            Airports::updateOrCreate(
                [
                    'airport_id' => $airport_id,
                ],
                [
                    'airport_id' => $airport_id,
                    'name' => $name,
                    'cities_id' => $city->id,
                    'countries_id' => $country->id,
                    'IATA' => $iata !== '\N' ? $iata : null,
                    'ICAO' => $icao !== '\N' ? $icao : null,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'altitude' => $altitude,
                    'timezone_offset' => $timezone_offset !== '\N' ? $timezone_offset : null,
                    'DST' => $dst !== '\N' ? $dst : null,
                    'timezone' => $timezone !== '\N' ? $timezone : null,
                    'type' => $type,
                    'source' => $source,
                ]
            );

        }
    }
}
