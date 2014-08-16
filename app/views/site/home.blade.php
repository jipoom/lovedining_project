@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.introduction') }}} ::
@parent
@stop

@section('styles')
<link href="{{asset('bootstrap/css/image.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/jquery.bxslider.css')}}" rel="stylesheet" />
<style>
	ul.bxslider {
		margin: 0;
		padding: 0;
	}
	
	.bx-wrapper img {
    margin: 0 auto;
	}
	img.resize{
    width:950px; /* you can use % */
    height: auto;
	}
	

    
}
</style>
@stop

{{-- Content --}}
@section('content')
<!-- .Ads -->
<div class="ads-right checkscreen" style="background-color: #D43F3A;">
	<div class="col-md-12">
		<a href="" class="thumbnail"><img src="http://placehold.it/260x800" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->
<div class="col-md-10">

<h4 style="color: #282828">
{{{ Lang::get('site.introduction') }}}
</h4>


<div class="col-md-12">
	
	<ul class="bxslider">
		@foreach($home as $post)
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$post->album_name.'/banner/',true);
			?>
			@if(count($banner) > 0)
				<li>
					<div class="crop">
					<a href="{{$post->id}}"><img src="{{Config::get('app.image_base_url').'/'.$post->album_name.'/banner/'.$banner[0]}}" title="{{$post->title}} {{$post->province}}" align="middle" class="resize"/></a>		
					</div>
				</li>
			@endif
		@endforeach

	</ul>

@include('highlight')

</div>
</div>
@stop

@section('scripts')
<!-- .crop -->
<script src="{{asset('assets/js/jquery.resizecrop-1.0.3.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.banner').resizecrop({
	      width:950,
	      height:500

	    });
		$('.highlight').resizecrop({
	      width:500,
	      height:300

	    });  
	    $('.single_highlight').resizecrop({
	      width:383,
	      height:300

	    });  
		$('.bxslider').bxSlider({
			mode : 'fade',
			infiniteLoop : true,
			auto : true,
			autoStart : true,
			autoDirection : 'next',
			autoHover : true,
			pause : 3000,
			autoControls : false,
			pager : true,
			pagerType : 'full',
			controls : false,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 950,
			adaptiveHeight: true
		});
		
		$('.bxslider_highlight').bxSlider({
			mode : 'horizontal',
			infiniteLoop : true,
			auto : true,
			autoStart : true,
			autoDirection : 'next',
			autoHover : true,
			pause : 3000,
			autoControls : false,
			pager : false,
			pagerType : 'full',
			controls : false,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 950,
			adaptiveHeight: true,
			moveSlides: 1
		});
		
		

		
	}); 
</script>

@stop
