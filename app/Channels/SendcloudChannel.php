<?php 

namespace App\Channels;

use Illuminate\Notifications\Notification;

/**
 * 自定义channels
 */
class SendcloudChannel
{
	public function send($notifiable, Notification $notification)
	{
		$message = $notification->toSendcloud($notifiable,$notification);
	}

}