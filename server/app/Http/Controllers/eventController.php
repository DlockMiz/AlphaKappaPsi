<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PastEvent;
use App\SwitchRequest;
use App\ActiveRequirement;
use App\User;
use App\ChapterComment;

use Illuminate\Support\Facades\Mail;
use App\Mail\FundSwitchRequest;




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
        ->where('switch_requests.fundraising','!=','not allowed')
        ->get();

        $user = DB::table('switch_requests')
        ->join('users', 'users.id', '=', 'switch_requests.poster_id')
        ->select('users.name', 'users.id')
        ->get();
        return [$data, $user];
    }

    public function addExecAccount(Request $request){
        $email = $request->email;
        $name = $request->name;

        $user  = new User();
        $req = new ActiveRequirement;

        $user->google_email = $email;
        $user->name = $name;
        $user->status = '1';
        $user->save();

        $req->id = $user->id;
        $req->absence = 0;
        $req->fundraising = 0;
        $req->service = 0;
        $req->prof_dev = 0;
        $req->save();

        return 200;
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
        if($post_event->event_type == 'fundraising'){
            $user_info = User::find($request->id);
            $create_date = date_create($event['date']);
            $date = date_format($create_date, "F d, Y");
            $email_data = (object)[
                'user_name' => $user_info->name,
                'event_title' => $event['title'],
                'event_location' => $event['location'],
                'event_date' => $date,
                'event_time' => $event['time'],
                'event_description' => $event['description']
            ];
            $req->fundraising = 'not allowed';
            Mail::to('dwlockster@gmail.com')
                ->send(new FundSwitchRequest($email_data));
        }

        $req->poster_id = $request->id;
        $req->event_id = $event["id"];
        $req->save();
        return;
    }

    public function getEvents(Request $request) {
		$data = Event::where('event_type', $request->event_type)
        ->where('completed', '=', 0)
        ->orderBy('date', 'desc')
        ->get();
		return $data;
    }

    public function changeRequest(Request $request){
        $req = SwitchRequest::find($request->id);
        if($request->type == 'approve'){
            $req->fundraising = 'allowed';
            $req->save();
        }
        else if($request->type == 'deny')
            $req->delete();
        return 200;
    }

    public function getChapterComments(Request $request) {
        $data = ChapterComment::where('chapter_id','=',$request->chapter_id)
        ->get();
        return $data;
    }

    public function fundraisingSwithcRequests(Request $request){
        $data = SwitchRequest::where('event_id',$request->event_id)
        ->where('fundraising','not allowed')
        ->get();
        if(count($data) == 0){
            return 500;
        }
        $users = array();

        foreach ($data as $req) {
            $user = User::where('id',$req->poster_id)->get();
            array_push($users, $user);
        }
        return [$users[0],$data];
    } 

    public function submitChapterComment(Request $request) {
        $comment = new ChapterComment();
        $comment->chapter_id = $request->chapter_id;
        $comment->comment = $request->comment;
        $comment->save();

        return 'success';
    }

    public function getAllEvents(Request $request) {
        if($request->type == 'current'){
            $data = Event::get()
            ->where('completed', '=', '0')
            ->where('event_type', '!=', 'chapter_comments');            
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
        $data->completed = 0;
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

    public function clearAttendees(Request $request) {
        $event = Event::find($request->event_id);
        $array = json_encode((object)['id'=> array()]);

        $event->attended_users = $array;                     
        $event->non_attended_users = $array;
        $event->save();
        return $event;     
    }

    public function switchUsers(Request $request) {
        $user1 = $request->id_one;
        $user2 = $request->id_two;
        $event = Event::find($request->event_id);
        $users = json_decode($event->signed_users,true);

        if(array_search($user2,$users['id']))
            return 200;

        $index = array_search($user1,$users['id']);
        $users['id'][$index] = (int)$user2;
        $event->signed_users = json_encode($users);
        $event->save();

        return;
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
