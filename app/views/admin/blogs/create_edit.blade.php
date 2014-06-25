@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<!--<li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>-->
		</ul>
	<!-- ./ tabs -->

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
                        <label class="control-label" for="title">ชื่อรีวิว</label>
						{{ Form::text('title',Input::old('title', isset($post) ? $post->title : null) , array('class'=>'form-control', 'placeholder'=>'ชื่อรีวิว'))}} </p>
						{{{ $errors->first('title', ':message') }}}
                       
                        <label class="control-label" for="title">ชื่อร้านอาหาร</label>
						{{ Form::text('restaurant_name', Input::old('title', isset($post) ? $post->restaurant_name : null), array('class'=>'form-control', 'placeholder'=>'ชื่อร้านอาหาร'))}} </p>
						{{{ $errors->first('restaurant_name', ':message') }}}
						
						 <label class="control-label" for="title">ประเภทร้านอาหาร</label>
						
						 {{ Form::select('category_id', $category, Input::old('title', isset($post) ? Category::find($post->category_id)->id : null)); }} </p>  
						
						 <label class="control-label" for="title">เบอร์โทร</label>
						{{ Form::text('tel', Input::old('title', isset($post) ? $post->tel : null), array('class'=>'form-control', 'placeholder'=>'เบอร์โทรศัพท์ (eg. 021234567, 0987654321)'))}} </p>
						{{{ $errors->first('tel', ':message') }}}<p>
						
						 <label class="control-label" for="title">ที่อยู่</label></P>
					    {{ Form::text('street_addr', Input::old('title', isset($post) ? $post->street_addr : null), array('placeholder'=>'เลขที่')) }} 
					    {{ Form::text('soi', Input::old('title', isset($post) ? $post->soi : null), array('placeholder'=>'ซอย')) }} 
					    {{ Form::text('road', Input::old('title', isset($post) ? $post->road : null), array('placeholder'=>'ถนน')) }} 
					    {{ Form::text('subdistrict', Input::old('title', isset($post) ? $post->subdistrict : null), array('placeholder'=>'แขวง')) }} </p>  
					    {{ Form::text('district', Input::old('title', isset($post) ? $post->district : null), array('placeholder'=>'เขต')) }}  
					    {{ Form::text('province', Input::old('title', isset($post) ? $post->province : null), array('placeholder'=>'จังหวัด')) }} 
					    {{ Form::text('zip', Input::old('title', isset($post) ? $post->zip : null), array('placeholder'=>'รหัสไปรษณีย์')) }} </p>  
                        
					</div>
				</div>
				<!-- ./ post title -->

				<!-- Content -->
				<div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Content</label>
						
						{{ Form::textarea('content', Input::old('title', isset($post) ? $post->content : null), array('class'=>'ckeditor', 'rows'=>'10'))}} </p>
						{{{ $errors->first('content', ':message') }}}
					</div>
				</div>
				<!-- ./ content -->
			</div>
			<!-- ./ general tab -->

			<!-- Meta Data tab -->
			
			<div class="tab-pane" id="tab-meta-data">
				<!-- Meta Title -->
				<div class="form-group {{{ $errors->has('meta-title') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-title">Meta Title</label>
						<input class="form-control" type="text" name="meta-title" id="meta-title" value="{{{ Input::old('meta-title', isset($post) ? $post->meta_title : null) }}}" />
						{{{ $errors->first('meta-title', '<span class="help-block">:message</span>') }}}
					</div>
				</div>
				<!-- ./ meta title -->

				<!-- Meta Description -->
				<div class="form-group {{{ $errors->has('meta-description') ? 'error' : '' }}}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="meta-description">Meta Description</label>
						<input class="form-control" type="text" name="meta-description" id="meta-description" value="{{{ Input::old('meta-description', isset($post) ? $post->meta_description : null) }}}" />
						{{{ $errors->first('meta-description', ':message') }}}
					</div>
				</div>
				<!-- ./ meta description -->

				<!-- Meta Keywords -->
				<div class="form-group {{{ $errors->has('meta-keywords') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-keywords">Meta Keywords</label>
						<input class="form-control" type="text" name="meta-keywords" id="meta-keywords" value="{{{ Input::old('meta-keywords', isset($post) ? $post->meta_keywords : null) }}}" />
						{{{ $errors->first('meta-keywords', '<span class="help-block">:message</span>') }}}
					</div>
				</div>
				<!-- ./ meta keywords -->
			</div>
			<!-- ./ meta data tab -->
		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
