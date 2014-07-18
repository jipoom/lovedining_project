@extends('site.layouts.default')
@section('styles')
		<style>
			.galleria{ width: 700px; height: 400px; background: #000 }
		</style>
@stop
@section('content')
		<h3 style="color: #1AC4BF">{{ link_to(URL::to($post->id), $post->title, $attributes = array(), $secure = null);}}

			<div class="pull-right">
				
				<a href="{{{ URL::previous() }}}" class="btn btn-small"><span class="glyphicon glyphicon-circle-arrow-left"</span> Back</a>
			 	
			</div>
		</h3>
		<div class="galleria">
			@foreach ($album as $picture)
				
				<a href='{{URL::to('/images/'.$post->album_name.'/'.$picture)}}'><img src="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" data-title="My title" data-description="My description"></a>
				
			@endforeach			
		</div>
	

@stop
@section('scripts')
        <script src="{{asset('assets/js/galleria-1.3.6.min.js')}}"></script>
		<script>		
			Galleria.loadTheme('{{asset('assets/js/galleria.classic.min.js')}}');
			Galleria.configure('imageCrop', false);
			Galleria.run('.galleria');			
		</script>
@stop