@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">发布问题</div>

                <div class="card-body">
                	<form action="/question" method="post">
                		{{ csrf_field() }}
                		<div class="form-group">
                			<label for="title">标题</label>
                			<input type="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="标题" id="title" value="{{old('title')}}">

                			@if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                		</div>
                  		
                  		<div class="form-group" >
	              
							<!-- 富文本编辑 -->
                            <input type="hidden" name="body" id="editor_txt">
							<div id="editor"></div>

                        </div>
						@if ($errors->has('body'))
						     <span style="font-size: 80%;color: #e3342f;" role="alert">
                                <strong>{{ ($errors->first('body')) }}</strong>
                            </span>
						@endif

						<button class="btn btn-success pull-right" type="submit" id="btn1">发布问题</button>

                	</form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 简单富文本编辑器 -->

<script type="text/javascript" src="/vendor/laravel-admin-ext/wang-editor/wangEditor-3.0.10/release/wangEditor.min.js"></script>

<script type="text/javascript">
    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )
    editor.create()
    document.getElementById('btn1').addEventListener('click',function(){
        var editor_txt=editor.txt.html();
        document.getElementById('editor_txt').value=editor_txt;
    },false)
</script>
<!-- 简单富文本编辑器 -->
@endsection
