<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'comments';
    protected $fillable = [
    	'user_id','body','commentable_id','commentable_type','parent_id','level','is_hidden'
    ];

    /**
     *	与问题和答案 多态关系
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     *	评论和用户的关系 一对多(逆向)
     */
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
