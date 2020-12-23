<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('user')->group(function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout')->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum', 'checkAdmin'])->group(function() {
    Route::post('import_airports', 'AdminController@importAirports');
    Route::post('import_routes', 'AdminController@importRoutes');
    Route::post('insert_city', 'AdminController@insertCity');
});

Route::middleware(['auth:sanctum'])->group(function() {
    //CommentController
    Route::post('add_comment', 'CommentController@add');
    Route::post('update_comment', 'CommentController@update');
    Route::delete('delete_comment', 'CommentController@delete');

    //FlightRouteController
    Route::post('get_towns', 'FlightRouteController@getTown');
    Route::get('get_route', 'FlightRouteController@flightDestination');
});



