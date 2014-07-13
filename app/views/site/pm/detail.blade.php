@extends('site.layouts.pm')

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
			
			<div class="pull-right">
				
				<a href="{{{ URL::previous() }}}" class="btn btn-small"><span class="glyphicon glyphicon-circle-arrow-left"</span> Back</a>
			 	
			</div>
		</h3>
	</div>

	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($post)){{ URL::to('admin/blogs/' . $post->id . '/edit') }}@endif" autocomplete="off">
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
                        <label class="control-label" for="title">Subject: </label>{{ $privateMessage->title}}<p>
                        
						
          	
						 <label class="control-label" for="title">From: </label>{{$privateMessage->sender}}<p></p>
						 
						 {{$privateMessage->created_at}}<p></p>
						 
						 <label class="control-label" for="title">Message: </label>	<p>
						 {{$privateMessage->content}}				
					</div>
				</div>
				<!-- ./ post title -->

			</div>
			<!-- ./ general tab -->

			

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<a href="{{{ URL::to('message_service/'.$privateMessage->id.'/delete') }}}" class="btn btn-small btn-danger iframe"> Remove</a>
				<a href="{{{ URL::to('message_service/reply/'.$privateMessage->id) }}}" class="btn btn-small btn-success iframe"> Reply</a>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>

@stop

@section('scripts')
		<script type="text/javascript">
			$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		</script>	
@stop