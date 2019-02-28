<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActiveRequirement;
use App\RequirementParam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignedEventEmail;



class requirementsController extends Controller
{
    public function submitComments(Request $request) {
        DB::table('comments')->insert(
            ['comments' => $request->comments,
            'name' => $request->name]
        );
    }

    public function clearPoints(Request $request) {
        DB::table('active_requirements')
        ->update(['fundraising' => 0, 'prof_dev' => 0, 'service' => 0]);
        return 100;
    }

    public function checkActiveRequirements(Request $request) {
    	$data = ActiveRequirement::find($request->id);
		return $data;
    }

    public function getReqParams(Request $request) {
        $data = RequirementParam::get();
        return $data;
    }

    public function changeReqParams(Request $request) {
        $data = RequirementParam::select()
        ->where('event_type', '=', $request->type)
        ->update(['parameters' => $request->value]);
        return $request->value;
    }

    public function fufillRequirement(Request $request) {
    	if(strcmp($request->event["event_type"],"service")==0){
	    	foreach ($request->attended_users as $key => $value) {
	    		$user = ActiveRequirement::find($value);
                $points = (int)$request->hours;   
	    		$user->service = $points + $user->service;
	    		$user->save();
	    	}
    	} else if(strcmp($request->event["event_type"],"prof_dev")==0){
            foreach ($request->attended_users as $key => $value) {
                $user = ActiveRequirement::find($value);
                $points = (int)$request->hours;                       
                $user->prof_dev = $points + $user->prof_dev;
                $user->save();
            }
        } else if(strcmp($request->event["event_type"],"fundraising")==0){
            foreach ($request->attended_users as $key => $value) {
                $user = ActiveRequirement::find($value);
                $points = (int)$request->event["hours"];
                $user->fundraising += $points;
                $user->save();
            }
        } 
    	return $request;
    }
}
