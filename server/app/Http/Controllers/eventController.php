<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PastEvent;


class eventController extends Controller
{
    public function getEvents(Request $request) {
		$data = Event::where('event_type', $request->event_type)
        ->where('completed', '=', 0)
        ->get();
		return $data;
    }

    public function getAllEvents(Request $request) {

        if($request->type == 'current'){
            $data = Event::get()
            ->where('completed', '=', '0');
            return $data;
        } else{
            $data = Event::get();
            return $data;
        }
    }
    public function getSingleEvent(Request $request) {
        $data = Event::find($request);
        return $data;
    }
    public function userSignedEvent(Request $request) {

		$data = Event::find($request->id);
        $max = 0;

        $users = json_decode($data->signed_users,true);
        foreach($users as $person => $id){
            foreach ($id as $array){ 
                $max++;
            }
        }
        if($max == $data->max_users){
            return 'fail';
        } else{
            $data->signed_users = $request->signed_users;
            $data->save();
        }
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
        $data->completed = $request->complete;

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

    public function attendUser(Request $request) {
        if($request->type == 'attend'){
            $data = Event::find($request->event_id);
            $data->attended_users = $request->users;
            $data->save();
            return $data;
        } else if($request->type == 'non_attend'){
            $data = Event::find($request->event_id);
            $data->non_attended_users = $request->users;
            $data->save();
            return $data;
        }
        return 'success';
    }

    public function switchAttendance(Request $request) {
        $data = Event::find($request->event_id);
        $data->attended_users = $request->att_users;
        $data->non_attended_users = $request->non_att_users;
        $data->save();
        return 'success';
    }
    public function removeSignedUser(Request $request) {
        $data = Event::find($request->event_id);
        $data->signed_users = $request->users;
        $data->save();
        return 'success';
    }
    public function setPastEvent(Request $request) {
        $data = Event::find($request->event_id);
        $data->completed = 1;
        $data->save();
    }

}
