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
<div class="ads-right checkscreen">
	<div class="col-md-12">
		<a href="" class="thumbnail"><img src="{{$adsSide}}" alt=""></a>
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
			@if(!(count(glob(Config::get('app.image_path').'/'.$post->album_name.'/banner/')) === 0))
				<?php
				$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$post->album_name.'/banner/',true);
				?>
			
				<li>
					<div class="crop">																																	
					<a href="{{$post->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$post->album_name.'/banner/'.$banner[0]}}" title="{{$post->title}}, {{(Session::get('Lang') == 'TH') ? $post->province->province_name: $post->province->province_name_en}}" align="middle" class="resize"/></a>		
					</div>
				</li>
			@endif
		@endforeach

	</ul>

@include('highlight')

</div>

<!-- . Ads -->
<div class="ads-foot">
	<div class="col-md-12">
		<a href="" class="thumbnail"><img src="{{$adsFoot}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->

</div>

@stop

@section('scripts')
<!-- .crop -->
<script src="{{asset('assets/js/jquery.resizecrop-1.0.3.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.highlight').resizecrop({
	      width:'400',
	      height:'250',
	      vertical : 'center',
		  horizontal : 'center'

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
