<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExecBoard;

class ExecBoardController extends Controller
{
    public function getExecBoard(Request $request){
    	$board = ExecBoard::get();
    	return $board;
    }
    public function editExecMember(Request $request){
    	$member = ExecBoard::find($request->member['id']);
    	$member->name = $request->member['name'];
    	$member->desc = $request->member['desc'];
    	$member->info = $request->member['info'];
    	$member->save();
    	return;
    }
}
