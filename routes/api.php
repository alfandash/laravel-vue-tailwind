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

  // $apiKey = config('services.accuweather.key');

  $response = Zttp::get('https://cors-anywhere.herokuapp.com/http://dataservice.accuweather.com/forecasts/v1/daily/1day/208971?apikey=8COJAyesWeK8RWfdXyyCWAQAbcdvPeTQ');

  return $response->json();
});
