<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'questions';
    protected $fillable = [
    	'title','body','user_id','conments_count','followers_count','answers_count','close_comment','is_hidden'
    ];

    /**
     *	问题和话题的关系
     */
    public function topic()
    {
    	return $this->belongsToMany('App\Question','question_topic','topic_id','question_id')->withTimestamps();
    }
}
