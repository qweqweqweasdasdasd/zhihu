<?php 
namespace App\Repositories;

use App\User;

/**
 * 用户仓库
 */
class UserRepository
{
	/**
	 *	获取到指定用户
	 */
	public function GetUserById($userId)
	{
		return User::find($userId);
	}

	/**
	 *	
	 */
	public function GetFollowersArray($author)
	{
		$data = \DB::table('followers')->where('followed_id',$author)->pluck('follower_id')->toArray();
		
		return $data; 
	}
}