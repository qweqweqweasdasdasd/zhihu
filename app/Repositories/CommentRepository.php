<?php 
namespace App\Repositories;

use App\Comment;

/**
 * 评论仓库
 */
class CommentRepository
{
	/**
	 *	创建评论
	 */	
	public function CreateComment($attribute)
	{
		return Comment::create($attribute);
	}
}