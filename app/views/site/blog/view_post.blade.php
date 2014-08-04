@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($post->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
@parent

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
@parent

@stop

@section('styles')
<style>img {
    max-width: 100%;
    height: auto;
    width: auto\9; /* ie8 */
}</style>
<link rel="stylesheet" href="{{asset('assets/css/preettyphoto/prettyPhoto.css')}}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />

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
    height: 400px;
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
<div class="col-md-10">
	<h3 style="color: #1AC4BF">{{ $post->title }}</h3>
	<div>
		<span class="badge badge-info pull-right">Posted {{{ $post->date() }}}</span>
	</div>
	<br>
	<p>
		{{ $post->content() }}
	</p>
	<div class="fb-like" data-href="{{Request::url()}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

	<hr />
	<p></p>

	<h4>ร้านอาหาร: {{ $post->restaurant_name }}</h4>
	<h5>โทร: {{ $post->tel }}</h5>
	<h5>ที่อยู่:
	@if($post->street_addr)
	{{$post->street_addr}}
	@endif
	&nbsp
	@if($post->soi)
	ซอย{{$post->soi}}
	@endif
	&nbsp
	@if($post->road)
	ถนน{{$post->road}}
	@endif
	&nbsp
	@if($post->subdistrict)
	แขวง{{$post->subdistrict}}
	@endif
	&nbsp
	@if($post->district)
	เขต{{$post->district}}
	@endif
	&nbsp
	@if($post->province)
	{{$post->province}}
	@endif
	&nbsp
	@if($post->zip)
	{{$post->zip}}
	@endif </h5>
	<input type="hidden" id="province" value= {{String::tidy($post->
	province) }}/>

	@if($post->district!="" && $post->province!=null)
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script>
		var geocoder;
		var map;
		function initialize() {
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(13.7500, 100.4833);
			var mapOptions = {
				zoom : 16,
				center : latlng
			}

			map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
		}

		function codeAddress(location) {
			// var address = document.getElementById('address').value;
			//var address = 'Arlington, VA';
			var address = location;
			geocoder.geocode({
				'address' : address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
						map : map,
						position : results[0].geometry.location
					});
				} else {
					alert('Geocode was not successful for the following reason: ' + status);
				}
			});
		}


		google.maps.event.addDomListener(window, 'load', initialize);
	</script>

	<body onload="codeAddress({{'\''.$address.'\''}})">
		<div id="googleMap" style="width:400px;height:280px;"></div>
		@endif
		<p></p>
		{{ link_to(URL::to($post->id.'/album'), 'Gallery', $attributes = array('class' => 'btn btn-default'), $secure = null);}}
		
		<!-- ./ picture album -->
		<?php $album = Picture::directoryToArray(Config::get('app.image_path').'/'.$post->album_name,true); ?>

		<!-- picture div -->
		<div>

		<ul class="gallery clearfix bxslider">
			@foreach ($album as $picture)
		
			<li><a href="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" class = "thumbnail" rel="LoveDining"><img src="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" alt="" /></a></li>

			@endforeach
		</ul>
		</div>
		<!-- picture div -->
		
		<!-- ./ picture album -->
		
		<hr />
		<a id="comments"></a>
		<h4>{{{ $comments->count() }}} Comments</h4>

		@if ($comments->count())
		@foreach ($comments as $comment)
		<div class="row">
			<div class="col-md-1">
				<img class="thumbnail" src="http://placehold.it/60x60" alt="">
			</div>
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-11">
						<span class="muted">{{{ $comment->author->username }}}</span>
						&bull;
						{{{ $comment->date() }}}
					</div>

					<div class="col-md-11">
						<hr />
					</div>

					<div class="col-md-11">
						{{ $comment->content() }}
					</div>
				</div>
			</div>
		</div>
		<hr />
		@endforeach
		@else
		<hr />
		@endif

		@if ( ! Auth::check())
		You need to be logged in to add comments.
		<br />
		<br />
		Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
		@elseif ( ! $canComment )
		You don't have the correct permissions to add comments.
		@else

		@if($errors->has())
		<div class="alert alert-danger alert-block">
			<ul>
				@foreach ($errors->all() as $error)
				<li>
					{{ $error }}
				</li>
				@endforeach
			</ul>
		</div>
		@endif

		<form  method="post" action="{{{ URL::to($post->id) }}}">
			<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
			<textarea class="col-md-12 input-block-level" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>
			


			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" class="btn btn-default" id="submit" value="Add a Comment" />
				</div>
			</div>
		</form>
		@endif

</div>
@stop

@section('scripts')

<script type="text/javascript">
	$(".iframe").colorbox({
		iframe : true,
		width : "80%",
		height : "80%"
	}); 
</script>
<!-- for facebook like and share -->
<script>
	( function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id))
				return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=566292166825639&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk')); 
</script>
<!-- TinyMCE -->
<script type="text/javascript" src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
	$(function() {
		tinymce.init({
			selector : "textarea",

			// ===========================================
			// INCLUDE THE PLUGIN
			// ===========================================

			menubar : false,
			plugins : ["jbimages emoticons"],

			// ===========================================
			// PUT PLUGIN'S BUTTON on the toolbar
			// ===========================================

			toolbar : "jbimages emoticons",

			// ===========================================
			// SET RELATIVE_URLS to FALSE (This is required for images to display properly)
			// ===========================================

			relative_urls : false

		});
	}); 
</script>
<!-- /TinyMCE -->
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.prettyPhoto.js')}}" type="text/javascript" charset="utf-8"></script>
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
			pager : false,
			pagerType : 'full',
			controls : true,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 300,
			adaptiveHeight: true
		});
		$("area[rel^='LoveDining']").prettyPhoto();

			$(".gallery:first a[rel^='LoveDining']").prettyPhoto({
				animation_speed : 'normal',
				theme : 'light_square',
				slideshow : 3000,
				autoplay_slideshow : false
			});
			$(".gallery:gt(0) a[rel^='LoveDining']").prettyPhoto({
				animation_speed : 'fast',
				slideshow : 10000,
				hideflash : true
			});

			$("#custom_content a[rel^='LoveDining']:first").prettyPhoto({
				custom_markup : '<div id="map_canvas" style="width:260px; height:265px"></div>',
				changepicturecallback : function() {
					initialize();
				}
			});

			$("#custom_content a[rel^='LoveDining']:last").prettyPhoto({
				custom_markup : '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
				changepicturecallback : function() {
					_bsap.exec();
				}
			});
	}); 
</script>

	
@stop
