<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PastEvent;
use App\SwitchRequest;
use App\User;




class eventController extends Controller
{
    public function switchRequestedUser(Request $request){
        $user = User::find($request->user_id);
        $userid = $user->id;

        $event = Event::find($request->event_id);
        $arr = json_decode($event->signed_users, true);
        for($x = 0; $x < count($arr['id']); $x++){
            if($arr['id'][$x] == $userid)
                return 300;
        }
        for($x = 0; $x < count($arr['id']); $x++){
            if($arr['id'][$x] == $request->poster_id)
                $arr['id'][$x] = $userid;
        }
        $event->signed_users = json_encode($arr);
        $event->save();

        $switch = SwitchRequest::find($request->switch_id)->delete();
        return $event->signed_users;
    }

    public function getAllSwitchRequests(Request $request){
        $data = DB::table('switch_requests')
        ->join('events', 'events.id', '=', 'switch_requests.event_id')
        ->select('switch_requests.id', 'switch_requests.event_id','events.title','switch_requests.poster_id')
        ->get();

        $user = DB::table('switch_requests')
        ->join('users', 'users.id', '=', 'switch_requests.poster_id')
        ->select('users.name', 'users.id')
        ->get();
        return [$data, $user];
    }

    public function requestUserSwitch(Request $request){
        $event = $request->post_event;
        $bool = false;

        $post_event = Event::find($event['id']);
        $arr = json_decode($post_event->signed_users, true);
        for($x = 0; $x < count($arr['id']); $x++){
            if($arr['id'][$x] == $request->id)
                $bool = true;
        }
        if($bool == false) return 200;

        $data = SwitchRequest::where('poster_id', $request->id)->get();
        foreach($data as $switch){
            if($switch->event_id == $event['id'])
                return 100;
        }

        $req = new SwitchRequest;
        $req->poster_id = $request->id;
        $req->event_id = $event["id"];
        $req->save();
        return;
    }

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
            return $data->values();

        }else if($request->type == 'past'){
            $data = Event::get()
            ->where('completed', '=', '1');
            return $data->values();
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

		$data = Event::find($request->event_id);
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
            array_push($users["id"], $request->id);
            $data->signed_users = json_encode($users);
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
        $data->hours = $request->hours;
    	$data->event_type = $request->event_type;
        $data->max_users = $request->max_users;
        $data->attended_users = $request->attended_users;
        $data->non_attended_users = $request->attended_users;
        $data->completed = $request->complete;
        $data->censor_perms = $request->censor_perms;

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
        $data->hours = $request->hours;
        $data->max_users = $request->max_users;
        $data->censor_perms = $request->censor_perms;
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

        $users = json_decode($data->signed_users,true);
        for($i = 0; $i < count($users["id"]); $i++){
            if($users["id"][$i] == $request->user_id)
                unset($users["id"][$i]);
        }

        $data->signed_users = json_encode($users);
        $data->save();

    }
    public function setPastEvent(Request $request) {
        $data = Event::find($request->event_id);
        $data->completed = 1;
        $data->save();
    }

}
