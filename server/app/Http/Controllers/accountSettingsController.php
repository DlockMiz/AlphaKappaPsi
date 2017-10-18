<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use App\Event;

class accountSettingsController extends Controller
{
    public function loadSignedEvents(Request $request) {
    	$events = [];

		$data = Event::get();
		 foreach($data as $value){
		 	$users = json_decode($value->signed_users,true);
		 	foreach($users as $person => $id){
		 		foreach ($id as $array){ 
		 			if($array == $request[0]){
		 			array_push($events, $value);
		 			}
		 		}
		 	}
		 }
		return $events;
    }
}
