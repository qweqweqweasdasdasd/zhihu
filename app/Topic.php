<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'topics';
    protected $fillable = [
    	'name','bio','questions_count','followers_count'
    ];

    /**
     *	话题和问题关系 多对多
     */
    public function questions()
    {
    	return $this->belongsToMany('App\Topic','question_topic','question_id','topic_id')->withTimestamps();
    }
}
