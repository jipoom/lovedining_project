@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.introduction') }}} ::
@parent
@stop

@section('styles')

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
    width:auto; /* you can use % */
    height: 500px;
	}
	
</style>
@stop

{{-- Content --}}
@section('content')

<!-- .Ads -->
<div class="ads-right pull-right">
	<div class="col-md-12">
		<a href="" class="thumbnail"><img src="http://placehold.it/260x800" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->
<h4 style="color: #282828">
{{{ Lang::get('site.introduction') }}}
</h4>
@if(count($randReviews)>0)
<div class="col-md-10">
	<ul class="bxslider">
		@foreach($randReviews as $review)
		<li>
			<a href="{{$review->id}}"><img src="{{Config::get('app.image_base_url').'/'.$review->album_name.'/'.$review->profile_picture_name}}" title="{{$review->title}}" align="middle"/></a>
		</li>
		@endforeach

	</ul>
</div>
@endif


@stop

@section('scripts')

<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.bxslider').bxSlider({
			mode : 'horizontal',
			infiniteLoop : true,
			auto : true,
			autoStart : true,
			autoDirection : 'next',
			autoHover : true,
			pause : 3000,
			autoControls : false,
			pager : true,
			pagerType : 'full',
			controls : true,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 750,
			adaptiveHeight: true
		});
		
	}); 
</script>
@stop
