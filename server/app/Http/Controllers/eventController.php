<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Event;

class eventController extends Controller
{
    public function getEvents(Request $request) {
		$data = Event::get();
		return $data;
    }
}
