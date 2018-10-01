<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use App\Event;
use App\User;


class accountSettingsController extends Controller
{
    public function loadSignedEvents(Request $request) {
    	$events = [];
		$data = Event::get()->where('event_type' ,$request->event_type)->values();
		 foreach($data as $value){
		 	if($value->completed != 1){
		 	$users = json_decode($value->signed_users,true);
			 	foreach($users as $person => $id){
			 		foreach ($id as $array){ 
			 			if($array == $request->id){
			 			array_push($events, $value);
			 			}
			 		}
			 	}
			 }
		 }
		return $events;
    }

    public function registerCurrentUserWithGoogle(Request $request){
    	$user = User::find($request->user_id);
    	$user->google_email = $request->email;
    	$user->save();
    	return $user;
    }

    public function unlinkGoogleAccount(Request $request){
    	$user = User::find($request->user_id);
    	$user->google_email = null;
    	$user->save();
    	return;
    }

    public function linkNotiEmail(Request $request){
        $user = User::find($request->user_id);
        $user->noti_email = $request->noti_email;
        $user->save();
        return $user;
    }
}
