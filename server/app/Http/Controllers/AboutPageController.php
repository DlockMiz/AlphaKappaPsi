<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\About;


class AboutPageController extends Controller
{
    public function getAboutData(Request $request) {
    	$data = '';
		$data = About::select('description')
			->get();
		return $data;
    }
}
