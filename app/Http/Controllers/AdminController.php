<?php

namespace App\Http\Controllers;

use App\Jobs\UploadFileAirport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Cities;
use App\Jobs\UploadFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * INSERT AIRPORTS
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importAirports (Request $request){

        $request->validate([
            'file' => 'required|mime_types:text/plain'
        ]);

        $request->file('file')->storeAs('airport','airport.txt');

        UploadFileAirport::dispatch()->delay(Carbon::now()->addSeconds(30));

        return response()->json(['message' => 'Airports are being imported, it can take a while']);

    }

    /**
     * INSERT ROUTES
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importRoutes (Request $request){

        $request->validate([
            'file' => 'required|mime_types:text/plain'
        ]);

        $request->file('file')->storeAs('routes','routes.txt');

        UploadFile::dispatch()->delay(Carbon::now()->addSeconds(30));

        return response()->json(['message' => 'Routes are being imported, it can take a while']);

    }

    /**
     * INSERT CITY
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertCity (Request $request){

        $request->validate([
            'name' => 'required|unique:cities,name|string',
            'country' => 'required|string',
            'description' => 'required|string',
        ]);

        // insert country if no exists
        $country = Country::firstOrCreate(['name' => $request->input('country')]);

        // insert city
        Cities::create(['name' => $request->input('name'), 'description' => $request->input('description'),'countries_id' => $country->id]);

        return response()->json(['message' => 'City Insert Success!']);

    }
}
