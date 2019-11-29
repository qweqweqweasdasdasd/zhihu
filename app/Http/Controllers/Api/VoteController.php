<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AnswerRepository;

class VoteController extends Controller
{ 
	/**
	 *	答案仓库
	 */
	protected $answer;

	/**
	 *  初始化
	 */
	public function __construct(AnswerRepository $answer)
	{
		$this->answer = $answer;
	}

    /**
     *	用户对答案点赞状态
     */
    public function users($id)
    {
    	$user = \Auth::guard('api')->user();

    	if($user->hasVotedFor($id)){
    		
    		return response()->json(['voted'=>ture]);
    	}
    	return response()->json(['voted'=>false]);
    }

    /**
     *  用户对答案点赞
     */
    public function vote(Request $request)
    {
    	$answer = $this->answer->GetAnswerById($request->get('answer'));

    	$voted = \Auth::guard('api')->user()->voteFor($request->get('answer'));

    	if(count($voted['attached']) > 0){
    		
    		$answer->increment('votes_count');	// 作者被关注
    		return response()->json(['voted'=>true]);
    	}

    	$answer->decrement('votes_count');	// 取消作者被关注
    	return response()->json(['voted'=>false]);
    }
}
