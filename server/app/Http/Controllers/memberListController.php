<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class memberListController extends Controller
{
    public function getRegisteredUsers(Request $request) {
		$data = User::get();
		return $data;
    }

    public function getUser(Request $request) {
		$data = User::find($request->id);
		return $data;
    }

}
