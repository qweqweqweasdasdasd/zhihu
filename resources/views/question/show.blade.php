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

            </div> 
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header follow">
                    <h2>{{ $question->followers_count }}</h2>
                    <span>关注者</span>
                </div>
                <div class="card-body">
                    <!-- <a href="/question/{{$question->id}}/follow" class="btn {{Auth::user()->followd($question->id)?'btn-success':''}}">
                        {{Auth::user()->followd($question->id)?'已关注':'未关注'}}
                    </a> -->

                    <!-- vue 组件 -->
                    <question-follow-button question="{{$question->id}}" user="{{Auth::user()->id}}">
                    </question-follow-button>
                    <!-- vue 组件 -->
                    <a href="" class="btn">篡写答案</a>
                </div>
            </div>
        </div>
        <br/>
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
                                        <img width="48px;" class="media-object" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/answer/{{$answer->id}}">
                                            {!! $answer->body !!}
                                        </a>
                                    </h4>
                                </div>
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