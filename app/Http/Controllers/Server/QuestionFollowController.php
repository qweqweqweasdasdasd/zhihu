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

    /**
     *  follower 状态
     */
    public function follower(Request $request)
    {
        $user = \Auth::guard('api')->user();

        $followed = $user->followd($request->get('question'));

        if(!$followed){
            return response()->json(['followed'=>false]);
        }
        return response()->json(['followed'=>true]);
    }

    /**
     *  follower 这个问题
     */
    public function followerThisQuestion(Request $request)
    {
        $user = \Auth::guard('api')->user();
        $question = \App\Question::find($request->get('question'));

        $followed = $user->followThis($question->id);

        if(count($followed['detached']) > 0){
           
            $question->decrement('followers_count');
            return response()->json(['followed'=>false]);
        }

        $question->increment('followers_count');
        return response()->json(['followed'=>true]);
    }
}
