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

//calendar routes
Route::post('/loadDates', 'calendarController@loadDates');
Route::post('/submitEvent', 'calendarController@submitEvent');
Route::post('/editEvent', 'calendarController@editEvent');
Route::post('/searchEventData', 'calendarController@searchEventData');
Route::post('/loadMonthlyEvents', 'calendarController@loadMonthlyEvents');
Route::post('/deleteEvent', 'calendarController@deleteEvent');

//login and register routes
Route::post('/findUser', 'loginController@findUser');
Route::post('/addUser', 'loginController@addUser');

//event routes
Route::post('/getEvents', 'eventController@getEvents');
Route::post('/addEvent', 'eventController@addEvent');
Route::post('/editEvent', 'eventController@editEvent');
Route::post('/deleteEvent', 'eventController@deleteEvent');
Route::post('/userSignedEvent', 'eventController@userSignedEvent');
Route::post('/getAllEvents', 'eventController@getAllEvents');
Route::post('/getSingleEvent', 'eventController@getSingleEvent');
Route::post('/attendUser', 'eventController@attendUser');
Route::post('/switchAttendance', 'eventController@switchAttendance');
Route::post('/setPastEvent', 'eventController@setPastEvent');
Route::post('/setPastEvent', 'eventController@setPastEvent');

//accounts settings routes
Route::post('/loadSignedEvents', 'accountSettingsController@loadSignedEvents');
Route::post('/getRegisteredUsers', 'memberListController@getRegisteredUsers');
Route::post('/getUser', 'memberListController@getUser');
Route::post('/editUser', 'memberListController@editUser');
Route::post('/getRequestedUsers', 'memberListController@getRequestedUsers');
Route::post('/addRequestedUsers', 'memberListController@addRequestedUsers');
Route::post('/getSignedUsers', 'memberListController@getSignedUsers');


//requirement routes
Route::post('/checkActiveRequirements', 'requirementsController@checkActiveRequirements');
Route::post('/fufillRequirement', 'requirementsController@fufillRequirement');
Route::post('/getReqParams', 'requirementsController@getReqParams');

//comments
Route::post('/submitComments', 'requirementsController@submitComments');






















