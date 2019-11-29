<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'messages';
    protected $fillable = [
    	'from_user_id','to_user_id','body','has_read','read_at'
    ];

    /**
     *	私信和用户的关系 多对多 连接发送人
     */
    public function fromUser()
    {
    	return $this->belongsToMany('App\User','messages','from_user_id')->withTimestamps();
    }

    /**
     *	私信和用户的关系 多对多 接受人
     */
    public function toUser()
    {
    	return $this->belongsToMany('App\User','messages','to_user_id')->withTimestamps();
    }
}
