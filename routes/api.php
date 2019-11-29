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

Route::middleware('auth:api')->get('/topic', 'Server\TopicController@index');	

// 用户关注问题接口
Route::post('/question/follower', 'Server\QuestionFollowController@followers')->middleware('auth:api');
Route::post('/question/follow', 'Server\QuestionFollowController@followThisQuestion')->middleware('auth:api');

// 用户关注用户接口
Route::get('/user/followers/{user}','Api\FollowersController@index');
Route::post('/user/follow','Api\FollowersController@follow');

// 用户对答案点赞接口
Route::post('/answer/{id}/vote/users','Api\VoteController@users');
Route::post('/answer/vote','Api\VoteController@vote');

// 访客发送私信
Route::post('/message/store','Server\MessageController@store');

// 评论问题或者答案
Route::get('/answer/{id}/comments','Server\CommentsController@answers');
Route::get('/question/{id}/comments','Server\CommentsController@questions');
Route::post('/comment/store','Server\CommentsController@store');

Route::get('/email/sendEmail','Api\AppController@sendEmail');
