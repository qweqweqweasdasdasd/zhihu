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
        'name', 'email', 'password','avatar','confirmation_token','is_active','questions_count','answers_count','comments_count','favorites_count','likes_count','follows_count','followings_count','settings','remember_token'
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
}
