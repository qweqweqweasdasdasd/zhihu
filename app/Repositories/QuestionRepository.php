<?php 
namespace App\Repositories;

use App\Question;
use App\Topic;
/**
 * 问题仓库
 */
class QuestionRepository
{
	/**
	 *	获取问题和话题关系通过 id
	 */
	public function GetQuestionWithTopicAndAnswersById($id)
	{
		return Question::where('id',$id)->with(['topic','answers'])->first();
	}

	/**
	 *	创建问题
	 */
	public function CreateQuestion($attribute)
	{
		return Question::create($attribute);
	}

	/**
	 *	获取到所有的问题列表
	 */
	public function GetQuestionFeed()
	{
		return Question::published()->latest('updated_at')->with('user')->get();
	}

	/**
	 *	获取指定一条问题
	 */
	public function GetOneQuestionWithTopicById($id)
	{
		return Question::with('topic')->find($id);
	}

	/**
	 *	格式化话题提交id和文本 统一转换为[id]
	 */
	public function normalizeTopic(array $data)
	{
		return collect($data)->map(function($topic,$key){
            if(!is_numeric($topic)){
                $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
                return (int)$newTopic->id;
            }
            Topic::find($topic)->increment('questions_count');
            return (int)$topic;
        })->toArray();
	}

	/**
	 *	通过id获取到问题和评论
	 */
	public function GetQuestionCommentById($id)
	{
		return Question::with('comments','comments.user')->where('id',$id)->first();
	}
}