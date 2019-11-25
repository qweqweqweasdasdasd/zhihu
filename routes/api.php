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
	

Route::get('/email/sendEmail','Api\AppController@sendEmail');
