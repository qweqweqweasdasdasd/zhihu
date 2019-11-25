<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','Server\QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// 验证用户邮箱
Route::get('/email/verify/{token}','Server\EmailController@verify')->name('email.verify');

// 问题创建
Route::resource('question','Server\QuestionController');

