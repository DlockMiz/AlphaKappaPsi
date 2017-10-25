<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\User;



class loginController extends Controller
{
    public function findUser(Request $request) {
		$data = User::where('email', $request->email)
		->get();
        
        if(sizeof($data) == 0){
            return 'fail';
        }
		if(password_verify($request->password, $data[0]->password)){
            return $data;
        }else{
            return 'fail';
        }
    }
    public function addUser(Request $request){
    	$data = new User;
        $hash = password_hash($request->password, PASSWORD_DEFAULT);
    	$data->password = $hash;
    	$data->email = $request->email;
    	$data->name = $request->name;
    	$data->status = '3';
    	$data->save();

    	return 'success';
    }
}
