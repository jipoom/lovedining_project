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
</style>

@stop

{{-- Content --}}
@section('content')


<div class="row">
	<div class="col-md-12">
		<!-- Post Title -->
		<!-- ./ post title -->

		<!-- Post Content -->
		<ul class="bxslider" style="margin-bottom: 0px; padding-bottom: 0px;">
			@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->post->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
					<?php
					$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->post->album_name.'/banner/',true);
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
		<div class="row">
			
			<div class="col-md-9">
				<h4>รายละเอียดโครงการ</h4>
				<p>
					{{ String::tidy($campaign->description) }}
				</p>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-9">
				<h4>ระยะเวลาโครงการ</h4>
				<div class="col-md-6  pull-left">
				
				<p>
				<p><span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $campaign->start_date }}}</p>
				<p><span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $campaign->expiry_date }}}</p>

				<span class="glyphicon glyphicon-comment"></span> {{UserCampaign::where('campaign_id','=',$campaign->id)->count()}} {{ \Illuminate\Support\Pluralizer::plural('member', UserCampaign::where('campaign_id','=',$campaign->id)->count()) }} registered
				</p>
				@if($campaign->remark1 != "")
					<p>
						<font color="red">*{{$campaign->remark1}}</font>
					</p>
				@endif
				@if($campaign->remark2 != "")
					<p>
						<font color="red">*{{$campaign->remark2}}</font>
					</p>
				@endif
				</div>
				<div class="col-md-6 pull-right movieinfo" style="padding: 5px; margin: 0px" >
				<?php $album = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post -> album_name, true); ?>

					<!-- picture div -->
					<div>
		
						<ul class="gallery clearfix bxslider">
							@foreach ($album as $picture)
		
							<li>
								<a href="{{URL::to('/images/'.$campaign -> post -> album_name.'/'.$picture)}}" rel="LoveDining[gallery]"><img src="{{URL::to('/images/'.$campaign -> post->album_name.'/'.$picture)}}" alt="" class ="thumbnail"/></a>
							</li>
		
							@endforeach
						</ul>
					</div>
				</div>	
					<div class="btn-default">
					<a href="{{{ Post::find($campaign->post_id)->url() }}}">Review</a>
					</div>
			</div>

		</div>
					
				
		<div class="row">
			<div class="col-md-8">
				<p></p>
				
			</div>
		</div>
		<hr />
		@if ( ! (Auth::check()  || Session::get('socialUser.isLogin')))
			You need to be logged in to register for this Voucher.
			<br />
			<br />
			Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
			<br />
			<br />
		@else
			@if(Auth::check())
				@if($campaign->allow_duplicate_user == 1)
					<div class="row">
						<div class="col-md-12">
						  <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-default btn-xs">กดรับสิทธิ์</a>
						</div> 
					</div>
				@elseif ($campaign->allow_duplicate_user == 0 && count(UserCampaign::where('campaign_id','=',$campaign->id)->where('user_id','=',Auth::user() -> id)->first()) > 0)
					You already registered for this voucher!!
					<p />
					Click <a href="{{{ URL::to('user/login') }}}">here</a> to see your voucher.
					<p />
				@else
					<div class="row">
						<div class="col-md-12">
						  <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-default btn-xs">กดรับสิทธิ์</a>
						</div> 
					</div>
				@endif

			@elseif(Session::get('socialUser.isLogin'))
				@if($campaign->allow_duplicate_user == 1)
					<div class="row">
						<div class="col-md-12">
						  <a href="{{{ URL::to('campaign/register/'.$campaign->id.'/'.Session::get('Lang')) }}}" class="btn btn-default btn-xs">กดรับสิทธิ์</a>
						</div> 
					</div>
				@else
					You need to be logged in to the website to register for this Voucher.
					<br />
					<br />
					Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
					<br />
					<br />
				@endif
			@endif
		@endif
	</div>
</div>

@stop

@section('scripts')
<!-- datepicker -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.prettyPhoto.js')}}" type="text/javascript" charset="utf-8"></script>
		<!-- datepicker -->
<script>
  $(function() {
     $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      maxDate: "-1y",
      yearRange: "c-70:c+10"
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
