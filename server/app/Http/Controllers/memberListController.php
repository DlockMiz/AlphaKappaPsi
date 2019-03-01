<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Alumni;
use App\RequestedUser;
use App\ActiveRequirement;
use Illuminate\Support\Facades\DB;



class memberListController extends Controller
{

    public function getRegisteredUsers(Request $request) {
		$data = DB::table('users')
        ->join('active_requirements','users.id','=','active_requirements.id')
        ->get();
		return $data;
    }
    public function deleteAlumni(Request $request) {
        Alumni::truncate();
        return;
    }

    public function deleteUsers(Request $request) {
        $ids = $request->users_id;
        foreach ($ids as $value) {
            User::find($value)->delete();
        }
        return '100';
    }

    public function makePledgesActives(Request $request) {
        $data = DB::table('users')
        ->where('status', '=', '3')
        ->update(['status' => 2]);
        return $data;
    }

    public function makeAlumni(Request $request) {
        $users_arr = $request->users_id;
        for($i = 0 ; $i < sizeof($users_arr); $i++){
            $user = User::find($users_arr[$i]);
            $user_req = ActiveRequirement::find($users_arr[$i]);
            $alumni = new Alumni;
            $alumni->name = $user->name;
            $alumni->phone_number = $user->phone_number;
            $alumni->grad_date = $user->grad_date;
            $alumni->major_minor = $user->major_minor;
            $alumni->save();
            $user->delete();
            $user_req->delete();
        }
        return 100;
    }
    public function getAlumni(Request $request) {
        $data = Alumni::get();
        return $data;
    }

    public function removeRequestedUsers(Request $request) {
        for($i = 0 ; $i < sizeof($request->id); $i++){
            $data = RequestedUser::find($request->id[$i]);
            $data->delete();
        }
        return 'success';
    }

    public function getSignedUsers(Request $request) {
        $users = [];
        $event = Event::find($request->event_id);
        $signed = false;

        if($request->type == 'parse_signed_users'){
            for($i =0;$i < sizeof($request->users); $i++){
                $data = User::find($request->users[$i]);                
                $att_users = json_decode($event->attended_users,true);
                foreach($att_users as $person => $id){
                    foreach ($id as $array){ 
                        // if($array == $data->id){
                        //     $signed = true;
                        // }
                    }
                }
                $non_att_users = json_decode($event->non_attended_users,true);
                foreach($non_att_users as $person => $id){
                    foreach ($id as $array){ 
                        // if($array == $data->id){
                        //     $signed = true;
                        // }
                    }
                }
                if($signed == false){
                    array_push($users, $data);
                    $signed = false;
                }
                $signed = false;
            }
        } else {
            for($i =0;$i < sizeof($request->users); $i++){
                $data = User::find($request->users[$i]);
                array_push($users, $data);
            }
        }
        return $users;
    }

    public function getUser(Request $request) {
		$data = User::find($request->id);
        if(isset($request->type)){
            if($request->type == 'requirements'){
                $requirements = ActiveRequirement::find($request->id);
                $data->major_minor = json_decode($data->major_minor);
                return[$data,$requirements];
            }
        }
		return $data;
    }

    public function editUser(Request $request) {
		$data = User::find($request->user['id']);
        $requirements = ActiveRequirement::find($request->user['id']);

        $requirements->service = $request->requirements['service'];
        $requirements->prof_dev = $request->requirements['prof_dev'];
        $requirements->fundraising = $request->requirements['fundraising'];

        $data->dues = $request->user['dues'];
		$data->name = $request->user['name'];
		$data->noti_email = $request->user['noti_email'];
		$data->status = $request->user['status'];
		$data->save();
        $requirements->save();
		return 200;
    }
    public function getRequestedUsers(Request $request) {
		$data = RequestedUser::get();
		return $data;
    }

    public function addRequestedUsers(Request $request) {
    	for($i = 0 ; $i < sizeof($request->id); $i++){
			$data = RequestedUser::find($request->id[$i]);
            $req = new ActiveRequirement;
			$user = new User;

            $major = array();
            $minor = array();
            $major_minor = (object)[
                'major' => $major,
                'minor' => $minor
            ];

            $user->major_minor = json_encode($major_minor);
			$user->password = $data->password;
    		$user->email = $data->email;
    		$user->name = $data->name;
            $user->status = '3';



    		$data->delete();
    		$user->save();

            $req->id = $user->id;
            $req->absence = 0;
            $req->fundraising = 0;
            $req->service = 0;
            $req->prof_dev = 0;
            $req->save();
    	}


		return 'success';
    }

}
