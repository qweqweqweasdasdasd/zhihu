<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topic', function (Request $request) {
  
    $topic = \App\Topic::select(['id','name'])
    		->where('name','like','%'.$request->query('q').'%')
    		->get();

    return $topic;
});	
	
Route::post('/question/follower', function (Request $request) {
    
    $followed = \App\Follow::where('question_id',$request->get('question'))
    						->where('user_id',$request->get('user'))
    						->count();

    if(!$followed){
    	return response()->json(['followed'=>false]);
    }
    return response()->json(['followed'=>true]);
});


Route::post('/question/follow', function (Request $request) {
    
    $followed = \App\Follow::where('question_id',$request->get('question'))
    						->where('user_id',$request->get('user'))
    						->first();

    if($followed == null){
    	// 添加
    	\App\Follow::create([
    		'question_id' => $request->get('question'),
    		'user_id' => $request->get('user')
    	]);
    	return response()->json(['followed'=>true]);
    }
    // 删除
    $followed->delete();
    return response()->json(['followed'=>false]);
});

Route::get('/email/sendEmail','Api\AppController@sendEmail');
