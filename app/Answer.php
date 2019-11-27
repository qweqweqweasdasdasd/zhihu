<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'answers';
    protected $fillable = [
    	'user_id','question_id','body','votes_count','comments_count','is_hidden','close_comment'
    ];


    /**
     *	答案和用户的关系 一对多逆向
     */
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }

    /**
     *	答案和问题的关系 一对多逆向
     */
    public function question()
    {
    	return $this->belongsTo('App\Question','question_id','id');
    }
}
