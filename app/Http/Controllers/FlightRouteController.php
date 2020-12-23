<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cities;
use Illuminate\Support\Facades\DB;

class FlightRouteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTown(Request $request){

        $cities = Cities::with(['comments' => function($query) use ($request) {
            $query->select('cities_id', 'comment', 'created_at', 'updated_at');

            // limit
            if ($request->limit) {
                $request->validate(['limit' => 'integer']);
                $query
                    ->limit($request->input('limit'))
                    ->orderBy('created_at', 'DESC');
            }

        }]);

        if ($request->input('search')) {
            $cities->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }

        $cities = $cities->get(['id', 'name', 'description']);

        return response()->json($cities);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function flightDestination(Request $request){

        $request->validate([
            'city_id_from' => 'integer',
            'city_id_to' => 'integer',
        ]);

        $city_id_from = $request->input('city_id_from');
        $city_id_to = $request->input('city_id_to');

        $route =
            DB::select(
                'SELECT 
                        fromCity.name city_a_name,
                        fromAirport.name airport_a_name,
                        toCity.name city_b_name,
                        toAirport.name airport_b_name,
                        routes.price,
                        ROUND (111.111 *
                        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(fromAirport.latitude))
                         * COS(RADIANS(toAirport.latitude))
                         * COS(RADIANS(fromAirport.longitude - toAirport.longitude))
                         + SIN(RADIANS(fromAirport.latitude))
                         * SIN(RADIANS(toAirport.latitude)))))) AS kilometers
                    FROM routes
                    LEFT JOIN airports fromAirport ON fromAirport.airport_id = routes.source_airport_id
                    LEFT JOIN airports toAirport ON toAirport.airport_id = routes.destination_airport_id
                    LEFT JOIN cities fromCity ON fromCity.id = fromAirport.cities_id
                    LEFT JOIN cities toCity ON toCity.id = toAirport.cities_id
                    WHERE routes.source_airport_id IN (SELECT airport_id FROM airports WHERE cities_id = ?) AND routes.destination_airport_id IN (SELECT airport_id FROM airports WHERE cities_id = ?)
                    ORDER BY routes.price ASC', [$city_id_from, $city_id_to]);

        if (! $route) {
            return response()->json(['No flight routes found!'], 404);
        }

        return response()->json($route);
    }

}
