<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Event;

class eventController extends Controller
{
    public function getEvents(Request $request) {
		$data = Event::where('event_type', $request->event_type)
        ->get();
		return $data;
    }
    public function userSignedEvent(Request $request) {
		$data = Event::find($request->id);
        $data->signed_users = $request->signed_users;
        $data->save();
		return $data;
    }

    public function addEvent(Request $request){
    	$data = new Event;
    	$data->title = $request->title;
    	$data->location = $request->location;
    	$data->description = $request->description;
    	$data->date = $request->date;
    	$data->time = $request->time;
    	$data->signed_users = $request->signed_users;
    	$data->event_type = $request->event_type;
        $data->month = $request->month;
    	$data->save();
    	return 'success';
    }

}
