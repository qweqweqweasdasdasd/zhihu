<?php

namespace App\Http\Controllers\Server;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionFollowController extends Controller
{
	/**
     *  初始化参数
     */ 
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *	用户关注该问题
     */
    public function follow($question)
    {
    	Auth::user()->followThis($question);

    	return back();
    }
}
