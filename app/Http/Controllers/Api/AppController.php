<?php

namespace App\Http\Controllers\Api;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     *	发送邮箱
     */
    public function sendEmail()
    {

    	Mail::send('email.register',['name'=>'test'],function($message){
            $to = '2356596937@qq.com';
            $message->to($to)->subject('邮件测试');

            // 返回的一个错误数组，利用此可以判断是否发送成功
            // dd(Mail::failures());
        });
    }
}
