<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\CalendarEvent;


class calendarController extends Controller
{
    public function loadDates(Request $request) {
		$data = DB::table('calendar_events')
		->get();
		return $data;
    }
    public function submitEvent(Request $request){
    	$event = new CalendarEvent;

    	$event->description = $request->desc;
    	$event->title = $request->title;
    	$event->event_date = $request->date;
        $event->month = $request->month;

    	$event->save();
    }
    public function searchEventData(Request $request){
        $data = DB::table('calendar_events')
        ->where('event_date', $request->date)
        ->where('title', $request->title)
        ->get();
        return $data;
    }

    public function loadMonthlyEvents(Request $request){
        $data = DB::table('calendar_events')
        ->where('month', '=', $request->month)
        ->get();
        return $data;
    }

    public function deleteEvent(Request $request){

        for($x = 0; $x < $request->size; $x++){
            $event = CalendarEvent::where('id', $request->id[$x])
            ->delete();
        }
        return 'test';
    }

    public function editEvent(Request $request){
        $data = CalendarEvent::find($request->id);
        $data->title = $request->title;
        $data->event_date = $request->date;
        $data->description = $request->desc;
        $data->save();
        return $data;
    }
}
