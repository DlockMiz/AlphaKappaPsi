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
	    		$user = ActiveRequirement::find($value["id"]);
	    		$user->service += (int)$request->event["hours"];
	    		$user->save();
	    	}
    	} else if(strcmp($request->event["event_type"],"prof_dev")==0){
            foreach ($request->attended_users as $key => $value) {
                $user = ActiveRequirement::find($value["id"]);
                $user->prof_dev += (int)$request->event["hours"];
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
