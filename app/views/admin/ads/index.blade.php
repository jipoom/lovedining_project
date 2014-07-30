@extends('admin.layouts.default')

{{-- Content --}}
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
@stop
@section('content')
		
	<div class="page-header">
		<h3>
			{{{ $title }}}
			
		</h3>
	</div>
	
	<p><h4>Home Page</p></h4>
	<ul>
		<li><a href="{{{ URL::to('admin/elfinder/tinymce')."/".Config::get('app.ads_sidebar_prefix')."Home" }}}" class="iframe"><span class="glyphicon glyphicon-bullhorn"></span> Side Bar</a></li>					
		<li><a href="{{{ URL::to('admin/elfinder/tinymce')."/".Config::get('app.ads_footer_prefix')."Home" }}}" class="iframe"><span class="glyphicon glyphicon-bullhorn"></span> Footer</a></li>					
	</ul>
	<p><h4>Category Pages</h4></p>
	@foreach($categories as $category)
	{{$category->category_name}}
	<ul>
		<li><a href="{{{ URL::to('admin/elfinder/tinymce')."/".Config::get('app.ads_sidebar_prefix').$category->album_name }}}" class="iframe"><span class="glyphicon glyphicon-bullhorn"></span> Side Bar</a></li>					
		<li><a href="{{{ URL::to('admin/elfinder/tinymce')."/".Config::get('app.ads_footer_prefix').$category->album_name }}}" class="iframe"><span class="glyphicon glyphicon-bullhorn"></span> Footer</a></li>					
	</ul>
	@endforeach

@stop
	