@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">消息通知</div>
                <div class="card-body">
                	@foreach($messages as $v)
                        <span style="float: right; color: {{$v->last()->UnreadClass()?'red':'green'}}" >{{$v->last()->UnreadClass()? '未读':'已读'}}</span>
                        <div class="media {{$v->first()->UnreadClass()?'unread':'read'}}">
                            <div class="media-left">
                                <a href="#">
                                    @if(Auth::user()->id == $v->last()->from_user_id)
                                    <img width="48px;" src="{{ $v->last()->toUser->avatar }}">
                                    @else
                                    <img width="48px;" src="{{ $v->last()->fromUser->avatar }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                		<div class="media-body">
                			<h4 class="media-heading">
                				@if(Auth::user()->id == $v->last()->from_user_id)
                				<a href="#">{{ $v->last()->toUser->name }}</a>
                                @else
                                <a href="#">{{ $v->last()->fromUser->name }}</a>
                				@endif
                			</h4>
                			<p>
                				<a href="/inbox/{{$v->first()->dialog_id}}">
                					{{ $v->first()->body }} <span style="float: right;">{{$v->last()->created_at->format('Y-m-d')}}</span>
                				</a>
                			</p>
                		</div>
                	@endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
