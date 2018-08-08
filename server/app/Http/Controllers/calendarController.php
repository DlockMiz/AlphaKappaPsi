<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;


class calendarController extends Controller
{
    public function loadDates(Request $request) {
		$data = DB::table('events')
        ->where('event_type','!=','chapter_comments')
		->get();
		return $data;
    }
    public function submitEvent(Request $request){
    	$event = new Event;
        $users = json_encode(array("id" => array()));

    	$event->description = $request->desc;
    	$event->title = $request->title;
    	$event->date = $request->date;
        $event->month = $request->month;
        $event->signed_users = $users;

    	$event->save();
    }
    public function searchEventData(Request $request){
        $data = DB::table('events')
        ->where('date', $request->date)
        ->where('title', $request->title)
        ->get();
        return $data;
    }

    public function loadMonthlyEvents(Request $request){
        $data = DB::table('events')
        ->where('month', '=', $request->month)
        ->get();
        return $data;
    }

    public function deleteEvent(Request $request){

        for($x = 0; $x < $request->size; $x++){
            $event = Event::where('id', $request->id[$x])
            ->delete();
        }
        return 'test';
    }

    public function editEvent(Request $request){
        $data = Event::find($request->id);
        $data->title = $request->title;
        $data->date = $request->date;
        $data->description = $request->desc;
        $data->save();
        return $data;
    }
}
