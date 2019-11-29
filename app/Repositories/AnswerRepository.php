<?php 
namespace App\Repositories;

use App\Answer;

/**
 * 答案仓库
 */
class AnswerRepository
{
	/**
	 *	创建答案
	 */	
	public function CreateAnswer($attribute)
	{
		return Answer::create($attribute);
	}

	/**
	 *	通过id获取到指定的答案
	 */
	public function GetAnswerById($id)
	{
		return Answer::find($id);
	}

	/**
	 *	通过id获取到答案和评论
	 */
	public function GetAnswerCommentById($id)
	{
		return Answer::with('comments','comments.user')->where('id',$id)->first();
	}
}