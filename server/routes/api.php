<?php

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\Input;
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

Route::post('/getAboutData', 'AboutPageController@getAboutData');
Route::post('/getInternData', 'InternshipController@getInternData');




