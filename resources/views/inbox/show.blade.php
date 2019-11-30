@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">对话列表</div>
                <div class="card-body">
                	<form action="/inbox/{{$dialog_id}}/store" method="post">
                		{{ csrf_field() }}
                		<div class="form-group">
                			<textarea name="body" class="form-control"></textarea>
                		</div>
                		<div class="form-group">
                			<button class="btn btn-success" style="float: right;">发送私信</button>
                		</div>
                	</form>
                	@foreach($messages as  $k => $v)
                		<div class="media">
                			<div class="media-left">
                				<a href="#">
                					<img width="48px;" src="{{ $v->fromUser->avatar }}">
                				</a>
                			</div>
                		</div>
                		<div class="media-body">
                			<h4 class="media-heading">
                				<a href="#">{{ $v->fromUser->name }}</a>
                			</h4>
                				{{ $v->body }}  <span style="float: right;">{{$v->created_at->format('Y-m-d')}}</span>
                		</div>
                	@endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
