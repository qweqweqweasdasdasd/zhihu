<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    const USER_ACTIVATED = 1;

    const USER_UNACTIVATED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','is_active','questions_count','answers_count','comments_count','favorites_count','likes_count','follows_count','followings_count','settings','remember_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $data = [
            'url'=>url(config('app.url').route('password.reset', $token, false)),
        ];

        Mail::send('email.passreset',$data,function($message) {

            $message ->to($this->email)->subject('邮件测试');
            
            // 返回的一个错误数组，利用此可以判断是否发送成功
            // dd(Mail::failures());
        });
    }


    /**
     *  检查当前登录者是否为作者
     */
    public function owns($model)
    {
        return !!($this->id == $model->user_id);
    }

    /**
     *  用户和答案的关系 一对多
     */
    public function answers()
    {
        return $this->hasMany('App\Answer','user_id','id');
    }

    /**
     *  用户关注问题的关系 多对多
     */
    public function follows()
    {
        return $this->belongsToMany('App\Question','user_question','user_id','question_id')->withTimestamps();
    }

    /**
     *  用户关注用户关系 多对多 
     */
    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id');
    }

    /**
     *  用户关注用户关系 多对多 
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id');
    }

    /**
     *  用户关注问题
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    /**
     *  用户关注作者
     */
    public function FollowThisAuthor($userId)
    {
        return $this->followers()->toggle($userId);
    }

    /**
     *  用户关注了问题
     */
    public function followd($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }


}
