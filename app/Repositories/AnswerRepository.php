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
}