<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Notifications\NewUserFollowNotinfication;

class FollowersController extends Controller
{
	/**
	 *	用户仓库
	 */
	protected $user;

	/**
	 *  初始化
	 */
	public function __construct(UserRepository $user)
	{
		$this->user = $user;
	}

    /**
     *	
     */
    public function index($id)
    {
    	// 作者
    	$user = $this->user->GetUserById($id);
    	// 追随者查询
    	$followers = $user->followersUser()->pluck('follower_id')->toArray();
    	
    	//$followers = $this->user->GetFollowersArray($user->id);

    	if(in_array(\Auth::guard('api')->user()->id, $followers)){
    		return response()->json(['followed'=>true]);
    	}
    	return response()->json(['followed'=>false]);
    }

    /**
     * 
     */
    public function follow(Request $request)
    {
    	$author = $this->user->GetUserById($request->get('user'));

    	$followed = \Auth::guard('api')->user()->FollowThisAuthor($author->id);

    	if(count($followed['attached']) > 0){
    		// 发送站内信息
    		$author->notify(new NewUserFollowNotinfication());

    		$author->increment('followings_count');	// 作者被关注
    		return response()->json(['followed'=>true]);
    	}

    	$author->decrement('followings_count');	// 取消作者被关注
    	return response()->json(['followed'=>false]);
    }
}
