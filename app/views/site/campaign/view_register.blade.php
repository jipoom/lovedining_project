@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($campaign->title) }}} ::
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
	.col-md-9 img {
		max-width: 100%;
		height: auto;
		width: auto\9; /* ie8 */
	}
	ul.bxslider {
		margin: 0;
		padding: 0;
	}
	.bx-wrapper img {
		margin: 0 auto;
	}
	img.resize {
		width: 1100px; /* you can use % */
		height: auto;
	}
	img.hl {
		width: 300px; /* you can use % */
		height: auto;
	}
	}
</style>
<link rel="stylesheet" href="{{asset('assets/css/preettyphoto/prettyPhoto.css')}}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
		width: auto; /* you can use % */
		height: 400px;
	}
	#voucher {
		display: block;
		margin: 10px;
	}
	#voucher_logo {
		text-align: center;
	}
	#voucher_image {
		height: 200px;
	}
	@media (max-width: 768px) {
		#voucher_image {
			height: 100px;
		}
	}
	
	#voucher p {
		padding-left: 30px;
	}
</style>

@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div id="voucher" class="">
		<!-- Post Title -->
		<!-- ./ post title -->

		<!-- Post Content -->
		<ul class="bx-wrapper" style="margin-bottom: 0px; padding-bottom: 0px;">
			@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->post->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post -> album_name . '/banner/', true);
			?>
			<div>
				<a href="{{$campaign->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$campaign->post->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>
			</div>
			@else
			@if($campaign->hotel_logo!="")
			<a href="{{{ $campaign->url() }}}"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
			@else
			<a href="{{{ $campaign->url() }}}"></a>
			@endif
			@endif

		</ul>
			<div id="section" class="">
				<h3>{{String::tidy($campaign->post->restaurant_name)}}</h3>
				<p>
					{{ String::tidy($campaign->description) }}
				</p>
				<br/>
				<div id="voucher_logo">
					<img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="100" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="hotel_logo" height="100">
				</div>
			</div>
		<div class="row">

			<div class="col-md-9">
				<h4>Information</h4>
				<p>
					{{ String::tidy($campaign->description) }}
				</p>
			</div>
		</div>
		<div class="row">

			<div class="col-md-12">
				<h4>Validity</h4>
				<?php $startDate =  new DateTime($campaign->start_date); ?>
				<?php $endDate =  new DateTime($campaign->expiry_date); ?>
				<p>
				@if($startDate->format('Y') == $endDate->format('Y'))
					{{{ $startDate->format('d M') }}} to {{{ $endDate->format('d M Y') }}}
				@else
					{{{ $startDate->format('d M Y') }}} to {{{ $endDate->format('d M Y') }}}
				@endif
			
				@if($campaign->remark1 != "")
					{{$campaign->remark1}}
				@endif
				@if($campaign->remark2 != "")
					{{$campaign->remark2}}
				</p>
				<br/>
				@endif
				
				<div class="row">

					<div class="col-md-9">
						<h4>Location</h4>
						<p>
							{{$campaign->post->address2}}
		
							{{$campaign->post->address1}}
		
							@if($campaign->post->tumbol)
								แขวง{{$campaign->post->tumbol}}
							@endif
		
							@if($campaign->post->amphur)
								{{$campaign->post->amphur}}
							@endif
		
							{{$campaign->post->province->province_name}}
							
							{{$campaign->post->zip}}
					
						</p>
					</div>
				</div>
				
				<br />
				<br />
				<div id="voucher_panel">
					<center style="color:#0D8FA9;"><a href="{{{ Post::find($campaign->post_id)->url() }}}" target="_blank" style="color:#0D8FA9;">review</a>
						| <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" style="color:#0D8FA9;" onclick="showRegister()">get voucher</a>
					</center>
				</div>
				<div id="register_panel" style="display: none;">
					<center style="color:#0D8FA9;"><a href="{{{ Post::find($campaign->post_id)->url() }}}" target="_blank" style="color:#0D8FA9;">review</a>
					</center>
				</div>
				@if ( ! (Auth::check()  || Session::get('socialUser.isLogin')))
				You need to be logged in to register for this Voucher.
				<br />
				<br />
				Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
				<br />
				<br />
				@else
				@if(Auth::check() || Session::get('socialUser.isLogin'))
				@if ($campaign->allow_duplicate_user == 1)
				<div class="row">
					<div class="col-md-12">
						| <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-danger">get voucher</a>
					</div>
				</div>
				<br />
				@elseif(Auth::check())
				@if (count(UserCampaign::where('campaign_id','=',$campaign->id)->where('user_id','=',Auth::user() -> id)->first()) > 0)
				You already registered for this voucher!!
				<p />
				<?php $userCampaign = UserCampaign::where('user_id','=',Auth::id())->where('campaign_id','=',$campaign->id)->first()?>
				Click <a href="{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}" target="_blank">here</a> to see your voucher.
				<p />
				@else
				<div class="row">
					<div class="col-md-12">
						| <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-danger">get voucher</a>
					</div>
				</div>
				<br />
				@endif
		
				@elseif(Session::get('socialUser.isLogin'))
				@if (count(UserCampaign::where('campaign_id','=',$campaign->id)->where('social_id','=',Session::get('socialUser.id'))->first()) > 0)
				You already registered for this voucher!!
				<p />
				<?php $userCampaign = UserCampaign::where('social_id','=',Session::get('socialUser.id'))->where('campaign_id','=',$campaign->id)->first()?>
				Click <a href="{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}" target="_blank">here</a> to see your voucher.
				<p />
				@else
				<div class="row">
					<div class="col-md-12">
						| <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-danger">get voucher</a>
					</div>
				</div>
				<br />
				@endif
				@endif
				@endif
				@endif

				
			
				<div class="" style="padding: 5px 0px 4px 10px;  margin: 0px; text-align: center;" >

					<?php $album = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post -> album_name, true); ?>

					<!-- picture div -->
					<div>

						<ul class="gallery clearfix bxslider">
							@foreach ($album as $picture)

							<li>
								<a href="{{URL::to('/images/'.$campaign -> post -> album_name.'/'.$picture)}}" rel="LoveDining[gallery]"><img src="{{URL::to('/images/'.$campaign -> post->album_name.'/'.$picture)}}" alt="{{$campaign->name}}" id="voucher_image"/></a>
							</li>

							@endforeach
						</ul>
					</div>
				</div>

			</div>
		</div>
		
		<br />
		
		
	</div>
</div>

@stop

@section('scripts')
<!-- datepicker -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.prettyPhoto.js')}}"></script>
<!-- datepicker -->
<script>
	$(document).ready(function() {
		
	});
	function showRegister(){
		alert("click");
	}
	$(function() {
		$("#datepicker").datepicker({
			changeMonth : true,
			changeYear : true,
			maxDate : "-1y",
			yearRange : "c-70:c+10"
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
			slideWidth : 200,
			adaptiveHeight : true,
			minSlides: 3,
  			maxSlides: 6
		});
		$("area[rel^='LoveDining']").prettyPhoto();

		$(".gallery:first a[rel^='LoveDining']").prettyPhoto({
			animation_speed : 'normal',
			theme : 'light_square',
			slideshow : 3000,
			autoplay_slideshow : false,
			deeplinking:false
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
