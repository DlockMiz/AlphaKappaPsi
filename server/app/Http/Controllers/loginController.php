<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\User;
use App\RequestedUser;


class loginController extends Controller
{
    public function findUser(Request $request) {
		$data = User::where('email', $request->email)
		->get();

        if(password_verify($request->password,$data->pass)){
            return $data;
        } else {
            return null;
        }
    }

    public function getGoogleApiKey(Request $request) {
        $data = DB::table('api_keys')
            ->get()
            ->where('id','=','1');
        return $data;
    }
    public function addUser(Request $request){
    	$data = new RequestedUser;
        $hash = password_hash($request->password, PASSWORD_DEFAULT);
    	$data->password = $hash;
    	$data->email = $request->email;
    	$data->name = $request->name;
    	$data->save();

    	return 'success';
    }
}
