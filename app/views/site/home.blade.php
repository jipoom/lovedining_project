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

@if(count($randReviews)>0)
<div class="col-md-10">
	<ul class="bxslider">
		@foreach($randReviews as $review)
		<li>
			<a href="{{$review->id}}"><img src="{{$review->profile_picture_name}}" title="{{$review->title}}" height="500" width="750"/></a>
		</li>
		@endforeach

	</ul>
</div>
@endif
{{{ Lang::get('site.introduction') }}}

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
			slideWidth : 750
		});
	}); 
</script>
@stop
