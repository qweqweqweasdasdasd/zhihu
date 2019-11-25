@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                <div >
                    @if(Auth::check() && Auth::user()->owns($question))
                        <a href="/question/{{$question->id}}/edit" class="btn btn-default">编辑</a>

                        <form action="/question/{{$question->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default">删除</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
