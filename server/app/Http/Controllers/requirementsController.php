<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActiveRequirement;


class requirementsController extends Controller
{
    public function checkActiveRequirements(Request $request) {
    	$data = ActiveRequirement::find($request->id);
		return $data;
    }

    public function fufillRequirement(Request $request) {
    	if(strcmp($request->event["event_type"],"service")==0){
	    	foreach ($request->attended_users as $key => $value) {
	    		$user = ActiveRequirement::find($value["id"]);
	    		$user->service += (int)$request->event["hours"];
	    		$user->save();
	    	}
    	}
    	return $request;
    }
}
