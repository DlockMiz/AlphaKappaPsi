<?php

namespace App\Http\Controllers;

use App\PasswordToken;
use App\User;
use App\Mail\ForgottenPasswordEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class PasswordResetController extends Controller
{
   public function sendResetPassEmail(Request $request) {
   		$row = new PasswordToken;
   		$token = str_random(32);
   		$row->password_token = $token;
   		$token = "www.akpsimiz.com/password_reset/".$token;
   		$row->email = $request->email;
   		$row->save();

   		Mail::to($row->email)->send(new ForgottenPasswordEmail($token));
   }

   public function changePassword(Request $request){
   		$token = $request->token;
   		$pass = $request->first_password;
   		$hash = password_hash($pass, PASSWORD_DEFAULT);


   		$data = PasswordToken::where('password_token', $request->token)->get();
   		$user = User::where('email',$data[0]->email)->update(['password'=>$hash]);
   		$del = PasswordToken::find($data[0]->id)->delete();
    	return 'success';
   }
}
