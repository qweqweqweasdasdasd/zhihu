<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Collection\MessageCollection;

class Message extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'messages';
    protected $fillable = [
    	'from_user_id','to_user_id','body','has_read','read_at','dialog_id'
    ];

    /**
     *	私信和用户的关系 一对多逆向 连接发送人
     */
    public function fromUser()
    {
    	return $this->belongsTo('App\User','from_user_id');
    }

    /**
     *	私信和用户的关系 一对多逆向 接受人
     */
    public function toUser()
    {
    	return $this->belongsTo('App\User','to_user_id');
    }

    /**
     *  私信已经读
     */
    public function markAsRead()
    {
        if(is_null($this->read_at)) {
            $this->forceFill(['has_read' => 'T','read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     *  自定义一个空的 collection
     */
    public function newCollection($model = [])
    {
        return new MessageCollection($model);
    }

    /**
     *  没有读取资料
     */
    public function Unread()
    {
        return $this->has_read == 'F';
    }

    /**
     *  读取资料
     */
    public function read()
    {
        return $this->has_read == 'T';
    }

    /**
     *  是否读取资料,显示不同的 class
     *  收信人是否读了该私信
     */
    public function UnreadClass()
    {
        // 当前登录人是收信人
        if(\Auth::user()->id === $this->from_user_id){
            return false;
        }

        return $this->Unread();
    }
}
