<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    /**
     *  topic方法
     */
    public function index(Request $request)
    {
    	// 复制到 reposiotry
        $topic = \App\Topic::select(['id','name'])
                ->where('name','like','%'.$request->query('q').'%')
                ->get();

        return $topic;
    }
}
