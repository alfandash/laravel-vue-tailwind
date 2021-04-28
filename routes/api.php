<?php

use Zttp\Zttp;
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

Route::get('users/{id}', function ($id) {
  error_log('Some message here.');
});


Route::get('weather', function () {

  $apiKey = config('services.accuweather.key');
  $locationId = request('location');

  $response = Zttp::get("http://dataservice.accuweather.com/currentconditions/v1/$locationId?apikey=$apiKey&details=true", '');

  return $response->json();
});


Route::get('weather/forecasts/daily/5day', function() {

  $apiKey = config('services.accuweather.key');
  $locationId = request('location');

  $response = Zttp::get("http://dataservice.accuweather.com/forecasts/v1/daily/5day/$locationId?apikey=$apiKey&metric=true", '');

  return $response->json();
});
