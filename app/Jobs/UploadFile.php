<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Airports;
use App\Models\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * UploadFile constructor.
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
        if (!Storage::exists('routes/routes.txt')) {
            return false;
        }

        $routesFile = Storage::path('routes/routes.txt');
        $allRoutes = array_map('str_getcsv', file($routesFile, FILE_IGNORE_NEW_LINES));

        foreach ($allRoutes as $route){

            list( $airline, $airline_id, $source_airport, $source_airport_id, $destination_airport, $destination_airport_id, $codeshare, $stops, $equipment, $price) = $route;

            // skip
            if ($airline_id == '\N' || $source_airport_id == '\N' || $destination_airport_id == '\N') {
                continue;
            }

            // check if exists
            if (!Airports::where('airport_id', $source_airport_id)->orWhere('airport_id', $destination_airport_id)->exists()) {
                continue;
            }

            Route::updateOrCreate(
                [
                    'airline_id' => $airline_id,
                    'source_airport_id' => $source_airport_id,
                    'destination_airport_id' => $destination_airport_id,
                ],
                [
                    'airline' => $airline,
                    'airline_id' => $airline_id,
                    'source_airport' => $source_airport,
                    'source_airport_id' => $source_airport_id,
                    'destination_airport' => $destination_airport,
                    'destination_airport_id' => $destination_airport_id,
                    'codeshare' => $codeshare,
                    'stops' => $stops,
                    'equipment' => $equipment,
                    'price' => $price,
                ]
            );

        }

    }
}
