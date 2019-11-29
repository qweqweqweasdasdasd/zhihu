<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\CommentRepository;

class CommentsController extends Controller
{
	protected $answer;
	protected $question;
	protected $comment;

	/**
	 * 	初始化
	 */
	public function __construct(AnswerRepository $answer,QuestionRepository $question,CommentRepository $comment)
	{
		$this->answer = $answer;
		$this->comment = $comment;
		$this->question = $question;
	}


	/**
	 *	获取答案评论
	 */
    public function answers($id)
    {
    	$Answer = $this->answer->GetAnswerCommentById($id);

    	return $Answer->comments;
    }

    /**
     *	获取问题评论
     */
    public function questions($id)
    {
    	$question = $this->question->GetQuestionCommentById($id);

    	return $question->comments;
    }

    /**
     *	创建新的评论
     */
    public function store(Request $request)
    {
    	$model = $this->getModelNameFromType($request->get('type'));

    	$comment = $this->comment->CreateComment([
    		'commentable_id' => $request->get('model'),
    		'commentable_type' => $model,
    		'body' => $request->get('body'),
    		'user_id' => \Auth::guard('api')->user()->id
    	]);

    	return $comment;
    }

    public function getModelNameFromType($type)
    {
    	return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
