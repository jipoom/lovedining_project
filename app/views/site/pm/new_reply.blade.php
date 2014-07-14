@extends('site.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<!--<li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>-->
		</ul>
	<!-- ./ tabs -->

	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($privateMessage)){{ URL::to('message_service/reply/' . $privateMessage->id)}}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Subject</label>
						{{ Form::text('title',Input::old('title', isset($privateMessage) ? 'Re:'.$privateMessage->title : null) , array('class'=>'form-control', 'placeholder'=>'Subject'))}} </p>
						{{{ $errors->first('title', ':message') }}}
                       
          				@if(isset($privateMessage))
          					<label class="control-label" for="title">Reply to:</label>	
          					<?php 
						 	$content = '<blockquote> From:'.$privateMessage->sender.'<p>Subject:'.$privateMessage->title.'<p>Date:'.$privateMessage->created_at.'<p>&nbsp;</p>'.$privateMessage->content.'</blockquote><hr />';
						 	?>	
          				@else
							<label class="control-label" for="title">To:</label>
						@endif
						{{ Form::text('to',Input::old('to', isset($privateMessage) ? $privateMessage->sender : null) , array('class'=>'form-control', 'id'=>'to','placeholder'=>'To'))}} </p>
						{{{ $errors->first('to', ':message') }}}
					
					</div>
				</div>
				<!-- ./ post title -->

				<!-- Content -->
				<div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Content</label>
						
						<!--{{ Form::textarea('content', Input::old('title', isset($post) ? $post->content : null), array('class'=>'ckeditor', 'rows'=>'10'))}} </p>
						{{{ $errors->first('content', ':message') }}}-->
						{{ Form::textarea('content', Input::old('content', isset($privateMessage) ? $content : null), array('id'=>'elm1', 'rows'=>'15', 'cols' => '130'))}} </p>
						{{{ $errors->first('content', ':message') }}}
						
					</div>
				</div>
				<!-- ./ content -->
			</div>
			<!-- ./ general tab -->

			

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
@section('scripts')
 <script>
$(function() {

	$( "#to" ).autocomplete(
	{
		 source:'search',
		 minLength: 2,
	})

});
</script>
@stop
