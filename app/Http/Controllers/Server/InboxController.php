<?php

namespace App\Http\Controllers\Server;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    /**
     *	显示私信列表: 根据收信人和发信人的不同,分别显示对方的头像和名
     */
    public function index()
    {

    	$messages = Message::where('to_user_id',\Auth::user()->id)
    				->orWhere('from_user_id',\Auth::user()->id)
    				->with(['fromUser','toUser'])
    				->latest()
    				->get();
    				//dd($messages->groupBy('to_user_id'));
    	
    	//return view('inbox.index',['messages'=>$messages->unique('dialog_id')->groupBy('to_user_id')]);
    	return view('inbox.index',['messages'=>$messages->groupBy('dialog_id')]);
    }

    /**
     *	显示对话记录: 根据对话id显示全部信息 (部分) 
     */
    public function show($dialog_id)
    {
    	//$messages = Message::where('dialog_id',$dialog_id)->orderBy('created_at','desc')->get();
    	$messages = Message::where('dialog_id',$dialog_id)->latest()->get();
    	// 已读功能
    	$messages->markAsRead();

    	return view('inbox.show',compact('messages','dialog_id'));
    }

    /**
     *	回复保存数据
     */
    public function store($dialog_id)
    {
    	// 获取到一条对话信息
    	$message = Message::where('dialog_id',$dialog_id)->first();
    	$toUserId = $message->from_user_id === \Auth::user()->id ? $message->to_user_id : $message->from_user_id;

    	Message::create([
    		'from_user_id' => \Auth::user()->id,
    		'to_user_id' => $toUserId,
    		'body' => request('body'),
    		'dialog_id' => $dialog_id
    	]);

    	return back();
    }
}
