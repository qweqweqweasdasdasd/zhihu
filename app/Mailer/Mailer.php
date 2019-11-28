<?php 

namespace App\Mailer;

use Mail;

/**
 * 	发送邮箱基类
 */
class Mailer
{
	/**
	 *	发送邮箱
	 */
	public function sendTo($template,$email,$data,$subject='')
	{
        Mail::send($template,$data,function($message) use($email,$subject){

            $message ->to($email)->subject($subject);
        });
	}
}