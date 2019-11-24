<?php

namespace App\Http\Controllers\Server;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    /**
     *	发送邮箱
     */
    public function verify(Request $request,$token)
    {
    	$user = User::where('confirmation_token',$token)->first();

		if(is_null($user)){
			flash('邮箱认证失败!')->warning();
			//return redirect('/');
		}   

		$user->is_active = User::USER_ACTIVATED;
		$user->confirmation_token = str_random(40);
		$user->save();

		Auth::login($user);
		flash("欢迎回来!")->success();
		return redirect('/home');	
    }
}
