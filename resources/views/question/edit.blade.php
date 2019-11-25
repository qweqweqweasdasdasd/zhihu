@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.css">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">发布问题</div>

                <div class="card-body">
                	<form action="/question/{{$question->id}}" method="post">
                		{{ method_field('PATCH') }}
                		{{ csrf_field() }}
                		<div class="form-group">
                			<label for="title">标题</label>
                			<input type="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="标题" id="title" value="{{$question->title}}">

                			@if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                		</div>
                  		<div class="form-group">
                            <label for="topic">话题</label>
                            <select class="js-example-basic-multiple js-example-data-ajax form-control" name="topic[]" multiple="multiple">
                          		@foreach($question->topic as $topic)
                          			<option value="{{ $topic->id }}" selected>{{ $topic->name }}</option>
                          		@endforeach
                            </select>    
                        </div>
                  		<div class="form-group" >
	                        <label for="body">内容</label>
							<!-- 富文本编辑 -->
                            <input type="hidden" name="body" id="editor_txt">
							<div id="editor">{!! $question->body !!}</div>

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


@endsection
<!-- 简单富文本编辑器 -->
@section('my-js')
<script type="text/javascript" src="/vendor/laravel-admin-ext/wang-editor/wangEditor-3.0.10/release/wangEditor.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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

    // $('.js-example-basic-multiple').select2();

    $(".js-example-data-ajax").select2({
          tags: true,
          placeholder: '请选择相关的话题',
          minimumInputLength: 2,
          ajax: {
            url: "/api/topic",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used
              params.page = params.page || 1;

              return {
                results: data,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            },
            cache: true
          },
          templateResult: formatRepo,
          templateSelection: formatRepoSelection
    });
    function formatRepo (repo) {
      if (repo.loading) {
        return repo.text;
      }

      return "<div class='select2-result-repository clearfix'>"+
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            repo.name?repo.name:"laravel" + 
            "</div></div></div>";  
    }

    function formatRepoSelection (repo) {
      return repo.name || repo.text;
    }

</script>
@endsection
<!-- 简单富文本编辑器 -->
