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
	<style>
	img {
		max-width: 100%;
		width: auto\9; /* ie8 */
	}
</style>
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
	img.resize {
		width: auto; /* you can use % */
		height: 400px;
	}
</style>

@stop

{{-- Content --}}
@section('content')
<div class="ads-right-home pull-right">
	<!-- Searchbox -->
	<div id="tfnewsearch">
		
		<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder = "{{(Session::get('Lang') == 'TH') ? 'ค้นหา ชื่อร้าน ชื่อรีวิว หรือสถานที่': 'search'}} "size="25" maxlength="120" onkeypress="return runScript(event)">
		<input type="submit" value="Go" id = "go" class="tfbutton" onclick ="searchAction(this.value)"> 
		
		
		<div class="tfclear"></div>
	</div>
<!-- .Ads -->

	<div class="col-md-12">
		<a href="" class="ads"><img src="{{$adsSide}}" alt=""></a>
	</div>
</div>

<!-- ./ Ads -->
<div class="col-md-highlight">

	<h3 style="color: #1AC4BF">{{ $post->title }}</h3>
	<h4 style="color: #1AC4BF">{{ $post->title_2 }}</h4>
	<div>
		<span class="badge badge-info pull-right">Posted {{{ $post->date() }}}</span>
	</div>
	<br>
	<div class="col-md-3 pull-right">
		<div class="movieinfo" >

			<h4>{{ $post->restaurant_name }}</h4>
			<h5>Tel: {{ $post->tel }}</h5>
			<h5> 
			{{$post->address2}}

			{{$post->address1}}

			@if($post->tumbol)
			แขวง{{$post->tumbol}}
			@endif

			@if($post->amphur)
			{{$post->amphur}}
			@endif

			{{$post->province->province_name_en}}
			
			{{$post->zip}}
			
			@if(Session::get('Lang') == 'TH')
				@if($post->route)
					<p></p>
					การเดินทาง: {{$post->route}}
				@endif
			@elseif(Session::get('Lang') == 'EN')
				@if($post->route_en)
					<p></p>
					Travel: {{$post->route_en}}
				@endif
			@elseif(Session::get('Lang') == 'CN')	
				@if($post->route_cn)
					<p></p>
					Travel: {{$post->route_cn}}
				@endif
			@endif	
			@if(count($post->foodType)>0)
				<h5>
				@if(Session::get('Lang') == 'TH')
					ประเภทอาหาร:
				@elseif(Session::get('Lang') == 'EN')
					Cuisine:
				@elseif(Session::get('Lang') == 'CN')
					Cuisine:
				@endif	
				@foreach($post->foodType as $temp)
				<li>
					{{$temp['name']}}
				</li> 
				@endforeach </h5>
			@endif
			
			@if(count($post->dressing)>0)
				<h5>
				@if(Session::get('Lang') == 'TH')
					การแต่งกาย:
				@elseif(Session::get('Lang') == 'EN')
					Attire:
				@elseif(Session::get('Lang') == 'CN')
					Attire:
				@endif	
				@foreach($post->dressing as $dress)
				<li>
					{{$dress['name']}}
				</li> 
				@endforeach </h5>
			@endif
			
			
			</h5>
			<input type="hidden" id="province" value= {{String::tidy($post->
			province) }}/>
			@if(Auth::user() && Auth::user()->hasRole('admin'))
			<h5>Category:
			@foreach($post->category as $cat_name)
			<li>
				{{$cat_name['category_name']}}
			</li> @endforeach </h5>
			@endif

			@if($post->latitude!="" && $post->longitude!=null)
			<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
			<script>
								/*var geocoder;
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
				*/
				function initialize() {
				var myLatlng = new google.maps.LatLng({{$post->latitude}},{{$post->longitude}});
				var mapOptions = {
				zoom: 16,
				center: myLatlng
				}
				var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

				var marker = new google.maps.Marker({
				position: myLatlng,
				map: map
				});
				}

				google.maps.event.addDomListener(window, 'load', initialize);
			</script>

			<div id="googleMap" style="width:auto;height:140px;"></div>

			<a href="http://maps.google.com/?q={{$post->latitude}},{{$post->longitude}}"><img src="{{{ asset('assets/img/map.png') }}}" title="View map in full screen"></a>

			@endif
		</div>

		<!-- ./ picture album -->
		
		<div class="movieinfo" style="padding: 5px 0px 50px 10px; margin: 30px 0px 30px 0px" >
			<?php $album = Picture::directoryToArray(Config::get('app.image_path') . '/' . $post -> album_name, true); ?>

			<!-- picture div -->
			<div>

				<ul class="gallery clearfix bxslider">
					@foreach ($album as $picture)

					<li>
						<a href="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" rel="LoveDining[gallery]"><img src="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" alt="" class ="thumbnail"/></a>
					</li>

					@endforeach
				</ul>
			</div>
			<!-- picture div -->
			<div align="center">
			<a href="{{{ URL::to($post->id.'/album') }}}"><img src="{{{ asset('assets/img/GalleryIcon.png') }}}" title="View full album" width="150px"></a>
			</div>
		</div>
		<!-- ./ picture album -->
	</div>
	<div class="col-md-9">
		<p>
			@if(Session::get('Lang') == 'TH')
				{{ $post->content() }}
			@elseif(Session::get('Lang') == 'EN')
				@if($post->content_en() == "")
					No content available in English!!
				@else
					{{ $post->content_en() }}
				@endif	
			@elseif(Session::get('Lang') == 'CN')
				@if($post->content_cn() == "")
					No content available in Chinese!!
				@else
					{{ $post->content_cn() }}
				@endif	
			@endif
		</p>
		<div class="fb-like" data-href="{{Request::url()}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

		<hr />
		<p></p>

		<p></p>
		

		
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
		
		@endforeach
		@else
		
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

		<form  method="post" action="{{{ URL::to($post->url()) }}}">
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
</div>
<!-- . Ads -->
<div class="ads-foot">
	<div class="col-md-12">
		<a href="" class="ads"><img src="{{$adsFoot}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->

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
<!-- .crop -->
<script src="{{asset('assets/js/jquery.resizecrop-1.0.3.min.js')}}"></script>
<!-- /TinyMCE -->
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.prettyPhoto.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
	$(document).ready(function() {
		$('.album').resizecrop({
	      width:'300',
	      height:'300'
	    });  
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
			adaptiveHeight : true
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
