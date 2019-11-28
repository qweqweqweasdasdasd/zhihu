<?php 
namespace App\Mailer;

use Auth;

/**
 *  用户邮箱发送
 */
class UserMailer extends Mailer
{
	public function followNotifiyEmail($email)
	{
		$data = [
            'url' => url(config('app.url')),
            'name' => \Auth::guard('api')->user()->name
        ];

        $this->sendTo('email.new_user_follow_notification',$email,$data,'一封来自第9平行宇宙世界的信件');
	}
}