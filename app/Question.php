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
    	return $this->belongsToMany('App\Topic','question_topic','question_id','topic_id')->withTimestamps();
    }

    /**
     *  一对多逆向
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     *  scope 发布的
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }
}
