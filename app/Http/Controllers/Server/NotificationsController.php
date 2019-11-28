<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    /**
     *	展示站内通知信息
     */
    public function index()
    {
    	$user = \Auth::user();

    	return view('notifications.index',compact('user'));
    }
}
