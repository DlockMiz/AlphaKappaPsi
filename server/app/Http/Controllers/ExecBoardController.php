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
}
