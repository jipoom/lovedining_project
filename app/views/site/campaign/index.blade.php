@extends('site.layouts.default')
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
    width:1100px; /* you can use % */
    height: auto;
	}	
	img.hl{
    width:300px; /* you can use % */
    height: auto;
	}

    
}
</style>
@stop
{{-- Content --}}
@section('content')

<ul class="bxslider" style="margin-bottom: 0px; padding-bottom: 0px;">
		@foreach($home as $temp)

			@if(!(count(glob(Config::get('app.image_path').'/'.$temp->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
				<?php
				$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$temp->album_name.'/banner/',true);
				?>
			
				<li>
					<div>																																	
					<a href="{{$temp->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$temp->album_name.'/banner/'.$banner[0]}}" title="" align="middle" /></a>		
					</div>
				</li>
			@endif
		@endforeach

	</ul>
<br />


@foreach ($campaigns as $campaign)
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $campaign->url() }}}">{{ String::title($campaign->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-6">
				@if(Auth::check()) 
				
				@if($campaign->hotel_logo!="")			
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
				@else
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				@endif
					
				@if(False)
					<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
				@endif	
		@else
			<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>		
		@endif	
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($campaign->description, 200)) }}
				</p>
				<strong><a href="{{{ $campaign->url() }}}"  style="color:#0D8FA9;">More info</a></strong>
				
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $campaign->start_date }}}
					| <span class="glyphicon glyphicon-comment"></span> {{5}} {{ \Illuminate\Support\Pluralizer::plural('Comment', 5) }}
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach



@stop
@section('scripts')
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		
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
			slideWidth : 1600,
			adaptiveHeight: true
		});
			
	}); 
</script>
@stop
