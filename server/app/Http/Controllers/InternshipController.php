<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\internship;


class InternshipController extends Controller
{
    public function getInternData(Request $request) {
    	$data = internship::select('description') 
            ->get();
    	return $data;
    }
}
