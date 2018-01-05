<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\RequestedUser;
use App\ActiveRequirement;



class memberListController extends Controller
{

    public function getRegisteredUsers(Request $request) {
		$data = User::get();
		return $data;
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
                        if($array == $data->id){
                            $signed = true;
                        }
                    }
                }
                $non_att_users = json_decode($event->non_attended_users,true);
                foreach($non_att_users as $person => $id){
                    foreach ($id as $array){ 
                        if($array == $data->id){
                            $signed = true;
                        }
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
		return $data;
    }

    public function editUser(Request $request) {
		$data = User::find($request->id);
		$data->name = $request->name;
		$data->email = $request->email;
		$data->status = $request->status;
		$data->save();
		return 'success';
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

			$user->password = $data->password;
    		$user->email = $data->email;
    		$user->name = $data->name;
    		$user->status = '3';

    		$data->delete();
    		$user->save();

            $req->id = $user->id;
            $req->absence = 0;
            $req->spring_basketball = 0;
            $req->fall_basketball = 0;
            $req->fall_football = 0;
            $req->service = 0;
            $req->prof_dev = 0;
            $req->save();
    	}


		return 'success';
    }

}
