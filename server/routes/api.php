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
Route::post('/getGoogleApiKey', 'loginController@getGoogleApiKey');

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
Route::post('/removeSignedUser', 'eventController@removeSignedUser');
Route::post('/requestUserSwitch', 'eventController@requestUserSwitch');
Route::post('/getAllSwitchRequests', 'eventController@getAllSwitchRequests');
Route::post('/switchRequestedUser', 'eventController@switchRequestedUser');
Route::post('/addExecAccount', 'eventController@addExecAccount');
Route::post('/clearAttendees', 'eventController@clearAttendees');
Route::post('/switchUsers', 'eventController@switchUsers');
Route::post('/getChapterComments', 'eventController@getChapterComments');
Route::post('/submitChapterComment', 'eventController@submitChapterComment');
Route::post('/fundraisingSwithcRequests', 'eventController@fundraisingSwithcRequests');
Route::post('/changeRequest', 'eventController@changeRequest');
Route::post('/markPriority', 'eventController@markPriority');
Route::post('/forceAddUser', 'eventController@forceAddUser');
Route::post('/removeUserFromEvent', 'eventController@removeUserFromEvent');





//accounts settings routes
Route::post('/loadSignedEvents', 'accountSettingsController@loadSignedEvents');
Route::post('/getRegisteredUsers', 'memberListController@getRegisteredUsers');
Route::post('/getUser', 'memberListController@getUser');
Route::post('/editUser', 'memberListController@editUser');
Route::post('/getRequestedUsers', 'memberListController@getRequestedUsers');
Route::post('/addRequestedUsers', 'memberListController@addRequestedUsers');
Route::post('/removeRequestedUsers', 'memberListController@removeRequestedUsers');
Route::post('/getSignedUsers', 'memberListController@getSignedUsers');
Route::post('/registerCurrentUserWithGoogle', 'accountSettingsController@registerCurrentUserWithGoogle');
Route::post('/signInActiveWithGoogle', 'loginController@signInActiveWithGoogle');
Route::post('/unlinkGoogleAccount', 'accountSettingsController@unlinkGoogleAccount');
Route::post('/linkNotiEmail', 'accountSettingsController@linkNotiEmail');
Route::post('/savePersonalInfo', 'accountSettingsController@savePersonalInfo');
Route::post('/makePledgesActives', 'memberListController@makePledgesActives');
Route::post('/makeAlumni', 'memberListController@makeAlumni');
Route::post('/getAlumni', 'memberListController@getAlumni');
Route::post('/deleteUsers', 'memberListController@deleteUsers');
Route::post('/deleteAlumni', 'memberListController@deleteAlumni');






//email routres
Route::post('/sendSignedUsersEmail', 'emailController@sendSignedUsersEmail');



//requirement routes
Route::post('/checkActiveRequirements', 'requirementsController@checkActiveRequirements');
Route::post('/fufillRequirement', 'requirementsController@fufillRequirement');
Route::post('/getReqParams', 'requirementsController@getReqParams');
Route::post('/changeReqParams', 'requirementsController@changeReqParams');
Route::post('/clearPoints', 'requirementsController@clearPoints');


//comments
Route::post('/submitComments', 'requirementsController@submitComments');

//exec board
Route::post('/getExecBoard', 'ExecBoardController@getExecBoard');
Route::post('/editExecMember', 'ExecBoardController@editExecMember');

//password controller
Route::post('/sendResetPassEmail', 'PasswordResetController@sendResetPassEmail');
Route::post('/changePassword', 'PasswordResetController@changePassword');


























