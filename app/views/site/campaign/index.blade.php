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
	img.resize {
    width:1100px; /* you can use % */
    height: auto;
	}	
	img.hl {
    width:300px; /* you can use % */
    height: auto;
	}
	
	#content_header {
	  padding: 0px 0px 30px 0px;
	  width: 70%;
	  float: left;
	}
	#content_aside {
		padding: 20px 0px 30px 0px;
		float: right;	
	}
	
	@media (max-width: 768px) {
		#content_header {
			width: 100%;
		}
		#content_aside {
			display: none;
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
<div id="content_header">
<h3>Campaign of the month</h3>
</div>

<div id="content_aside">
<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder = "{{(Session::get('Lang') == 'TH') ? 'ค้นหา campaign': 'search'}} "size="25" maxlength="120" onkeypress="return runScript(event)">
<input type="submit" value="Go" id = "go" class="tfbutton" onclick ="searchAction(this.value)"> 
<p><font color="blue"><center>{{count($campaigns)}} {{ \Illuminate\Support\Pluralizer::plural('campaign', count($campaigns)) }} valid</center></font></p>

</div>
<div id="reload_campaign">
@foreach ($campaigns as $campaign)
<div class="row">
	<div class="col-md-8">


		<!-- Post Content -->
		<div class="row">
			<div class="col-md-6">
		@if(Auth::check() || Session::get('socialUser.isLogin')) 
				
				@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
					<?php
					$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/',true);
					?>
				
						<div>																																	
						<a href="{{$campaign->url()}}"  class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>		
						</div>
				@else
						@if($campaign->hotel_logo!="")			
								<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
						@else
								<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
						@endif
				@endif
					
				@if(!User::checkIfUserSeeCampaign($campaignUserRead,$campaign->id))
					<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
				@endif	
		@else
			@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
				<?php
				$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/',true);
				?>
			
					<div>																																	
					<a href="{{$campaign->url()}}"  class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>		
					</div>
			@else
					@if($campaign->hotel_logo!="")			
							<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
					@else
							<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
					@endif
			@endif
		@endif	
			</div>
			<div class="col-md-6">
				
				<h4><strong><a href="{{{ $campaign->url() }}}">{{ String::title($campaign->name) }}</a></strong></h4>
				
				<p>
					{{ String::tidy(Str::limit($campaign->description, 200)) }}
				</p>
				<br/>
				<?php $startDate =  new DateTime($campaign->start_date); ?>
				<?php $endDate =  new DateTime($campaign->expiry_date); ?>
				@if($startDate->format('Y') == $endDate->format('Y'))
					<p>Valid {{{ $startDate->format('d M') }}} - {{{ $endDate->format('d M Y') }}}</p>
				@else
					<p>Valid {{{ $startDate->format('d M Y') }}} - {{{ $endDate->format('d M Y') }}}</p>
				@endif
				<br/>
				<a href="{{{ $campaign->url() }}}"  style="color:#0D8FA9;">more detail</a>
				|
				<a href="{{{ Post::find($campaign->post_id)->url() }}}"  target="_blank" style="color:#0D8FA9;">review</a>
				
			</div>
		</div>
		<!-- ./ post content -->

	
	</div>
</div>

<hr />
@endforeach
</div>


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
<script>
	function searchAction(mode) {
		var word = $("#keywords").val();
		if (mode == "") {
			document.getElementById("txtHint").innerHTML = "";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("reload_campaign").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "{{{ URL::to('campaign/search') }}}/" + word, true);
		xmlhttp.send();

	}

	function runScript(e) {
		if (e.keyCode == 13) {
			searchActionDefault("go");
		}
	}
</script>

@stop
