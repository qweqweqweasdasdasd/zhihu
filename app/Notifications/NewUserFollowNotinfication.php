<?php

namespace App\Notifications;

use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\SendcloudChannel;

class NewUserFollowNotinfication extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }

    /**
     *  使用站内信息给作者通知
     */
    public function toDatabase($notifiable)
    {
        return [
            'name' => \Auth::guard('api')->user()->name

            // TODO
        ];
    }

    /**
     *  SendcloudChannel
     */
    public function toSendcloud($notifiable)
    {
        // 新用户关注信息通知
        (new UserMailer())->followNotifiyEmail($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
