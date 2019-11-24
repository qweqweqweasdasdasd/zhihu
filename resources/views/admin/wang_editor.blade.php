<div class="form-group" >             
	<!-- 富文本编辑 -->

	<div id="{{$id}}">
		<p>{!! old($column,value) !!}</p>
	</div>
	<input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}" />
</div>