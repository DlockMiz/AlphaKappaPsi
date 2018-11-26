<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignedEventEmail;

use App\Event;
use App\User;

class emailController extends Controller
{
    public function sendSignedUsersEmail(Request $request) {
    	$event = $request->event;
    	$users = $request->users;
    	$create_date = date_create($event['date']);
    	$date = date_format($create_date, "F d, Y");
        $email;

    	foreach($users as $user){
    		$user_info = User::find($user['id']);
    		$email_data = (object)[
    			'user_name' => $user_info->name,
    			'event_title' => $event['title'],
    			'event_location' => $event['location'],
    			'event_date' => $date,
    			'event_time' => $event['time'],
    			'event_description' => $event['description']
    		];
            if($user_info['noti_email'] == null)
                $email = $user_info['email'];
            else
                $email = $user_info['noti_email'];

    		Mail::to($email)
          		->send(new SignedEventEmail($email_data));
    	}
    }
}
