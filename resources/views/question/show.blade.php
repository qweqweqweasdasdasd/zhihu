@extends('layouts.app')

@section('content')
<style type="text/css">
    .follow{
        text-align: center;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-1">
            <div class="card">
                <div class="card-header">
                    {{$question->title}}
                    @foreach($question->topic as $topic)
                        <a class="label label-info" href="/topic/{{ $topic->id }}">{{$topic->name}}</a>
                    @endforeach
                </div>

                <div class="card-body">
              		{!! $question->body !!}
                </div>

                    @if(Auth::check() && Auth::user()->owns($question))
                        <a href="/question/{{$question->id}}/edit" class="btn btn-default">编辑</a>
                        <br>
                        <form action="/question/{{$question->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn  btn-block">删除</button>
                        </form>
                    @endif
                    <comments type="question" 
                              model="{{$question->id}}" 
                              count="{{$question->conments_count}}">
                    </comments>
            </div> 
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-header follow">
                    <h2>{{ $question->followers_count }}</h2>
                    <span>关注者</span>
                </div>
                <div class="card-body">
     
                    <!-- vue 组件 -->
                    <question-follow-button question="{{$question->id}}"></question-follow-button>
                    <!-- vue 组件 -->
                    <a href="" class="btn">篡写答案</a>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-1">
            <div class="card">
                <div class="card-header">
                   {{ $question->answers_count }} 个答案
                </div>
                <div class="card-body">
                <form action="/answer" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="question_id" value="{{$question->id}}">    
                        <!-- 显示答案 -->
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                       <!--  <img width="48px;" class="media-object" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}"> -->
                                       <user-vote-button answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote-button>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/answer/{{$answer->id}}">
                                            {!! $answer->body !!}
                                        </a>
                                    </h4>
                                </div>
                            <comments type="answer" 
                                      model="{{$answer->id}}" 
                                      count="{{$answer->conments_count}}">
                            </comments>
                            </div>
                            <br>
                        @endforeach
                        @if(Auth::check())
                        <div class="form-group" >
                            <!-- 富文本编辑 -->
                            <input type="hidden" name="body" id="editor_txt">
                            <div id="editor">{!! old('body') !!}</div>

                        </div>
                        @if ($errors->has('body'))
                             <span style="font-size: 80%;color: #e3342f;" role="alert">
                             <strong>{{ ($errors->first('body')) }}</strong>
                             </span>
                        @endif
                    <button class="btn btn-block" type="submit" id="btn1">提交答案</button>
                    @else
                    <a href="/login" class="btn btn-success btn-block">登录提交答案</a>
                    @endif
                </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header follow">
                    <h5>关注作者</h5>

                </div>
                <div class="card-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img width="36px;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                            </a>
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="">{{$question->user->name}}</a>
                        </h4>
                    </div>
                    <div>
                        <span>问题</span>
                        <span>{{$question->user->questions_count}}</span>
                        <span>答案</span>
                        <span>{{$question->user->answers_count}}</span>
                        <span>评论</span>
                        <span>{{$question->user->comments_count}}</span>
                    </div>
                    <!-- vue 组件 -->
                    <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                    <!-- vue 组件 -->
                    <send-message user="{{$question->user_id}}"></send-message>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('my-js')
<script type="text/javascript" src="/vendor/laravel-admin-ext/wang-editor/wangEditor-3.0.10/release/wangEditor.min.js"></script>
<script type="text/javascript">
    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )
    editor.customConfig.zIndex = 100
    editor.create()
    
    document.getElementById('btn1').addEventListener('click',function(){

        var editor_txt=editor.txt.html();
        document.getElementById('editor_txt').value=editor_txt;
    },false)
</script>
@endsection