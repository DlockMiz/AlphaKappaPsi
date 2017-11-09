<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\RequestedUser;


class memberListController extends Controller
{
    public function getRegisteredUsers(Request $request) {
		$data = User::get();
		return $data;
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
			$user = new User;

			$user->password = $data->password;
    		$user->email = $data->email;
    		$user->name = $data->name;
    		$user->status = '3';

    		$data->delete();
    		$user->save();
    	}

		return 'success';
    }

}
