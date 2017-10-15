<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\User;



class loginController extends Controller
{
    public function findUser(Request $request) {
		$data = User::where('password', $request->password)
        ->where('email', $request->email)
		->get();
		return $data;
    }
    public function addUser(Request $request){
    	$data = new User;
    	$data->password = $request->password;
    	$data->email = $request->email;
    	$data->name = $request->name;
    	$data->status = '3';

    	$data->save();

    	return 'success';
    }
}
