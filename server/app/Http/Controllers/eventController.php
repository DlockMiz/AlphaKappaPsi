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
        if($data->max_users < sizeof($request->signed_users)){
            return 'fail';
        }
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
        $data->month = $request->month;
    	$data->signed_users = $request->signed_users;
    	$data->event_type = $request->event_type;
        $data->max_users = $request->max_users;
        $data->attended_users = $request->attended_users;

    	$data->save();
    	return 'success';
    }
        public function editEvent(Request $request){
        $data = Event::find($request->id);
        $data->title = $request->title;
        $data->location = $request->location;
        $data->description = $request->description;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->month = $request->month;
        $data->max_users = $request->max_users;
        $data->save();
        return 'success';
    }
    public function deleteEvent(Request $request){
        $data = Event::find($request->id)
        ->delete();
        return 'success';
    }

}
