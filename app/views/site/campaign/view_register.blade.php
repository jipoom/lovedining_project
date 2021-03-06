@extends('site.layouts.default')
@section('title')
{{ String::tidy($campaign->name) }} ::
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
	}
	#voucher {
		display: block;
		margin: 10px;
	}
	#voucher_logo {
		float:right;
		width: 50%;
		text-align: right;
	}
	#section {
		float:right;
		width: 50%;
		margin-top: -24px;
	}

	#voucher p {
		padding-left: 30px;
	}
	#register_zone {
		display: block;
		border: 2px solid #0D8FA9;
		padding: 20px 10px 20px 10px;
		margin-bottom: 20px;
		float: left;
		width: 100%;
	}
	@media screen and (max-width: 768px) {
		#voucher_logo 
		{
			width: 100%;
			text-align: center;
		}
		#section {
			width: 100%;
			margin-top: 0px;
		}
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
			@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> album_name . '/banner/', true);
			?>
			<div>
				<a href="{{$campaign->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>
			</div>
			@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post->album_name . '/banner/', true);
			?>
			<div>
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" alt="Banner" align="middle" /></center>
			</div>
			
			@endif

			</ul>
			<br/>
			<br/>
			<div>

				<div id="voucher_logo">
					<img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="100" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/hotel_logo/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
					<?php
					$hotelLogo = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign ->album_name . '/hotel_logo/', true);
					?>
			
						<img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/hotel_logo/'.$hotelLogo[0]}}" alt="Hotel"height="100"/>
				
					@else
					
						<img src="http://placehold.it/100x100" alt="" height="100">
					
					@endif
				</div>
				<div id="section" class="">
					<h3>{{String::tidy($campaign->post->restaurant_name)}}</h3>
					<p>
						{{ String::tidy($campaign->name) }}
					</p>
					<br/>
			
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
			
				<div class="row">

					<div class="col-md-9">
						<h4>Location</h4>
						<p>
							{{$campaign->post->address1}}
		
							{{$campaign->post->address2}}
		
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
				<h4>Term & Conditions</h4>
				<p>
					{{ String::tidy($campaign->condition) }}
				</p>
				<br />
				<div class="fb-like" data-href="{{Request::url()}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
				<br />
				<br />
				@if((!$errors->isEmpty()))
				<div id="voucher_nav_panel" style="display: none;">
				@else
				<div id="voucher_nav_panel">
				@endif
					<center style="color:#0D8FA9;"><a href="{{{ Post::find($campaign->post_id)->url() }}}" class="btn btn-primary" target="_blank">review</a>
						<button class="btn btn-success" onclick="showRegister()">get voucher</button>
					</center>
				</div>
				@if((!$errors->isEmpty()))
				<div id="register_panel" style="display: block;">
				@else
				<div id="register_panel" style="display: none;">
				@endif
				<div id="register_zone">
				@if ( ! (Auth::check()  || Session::get('socialUser.isLogin')))
					<div>
					<div style="height: 100%; width: 50%; float: left; padding-right: 10%; border-right: 1px solid #0D8FA9;">
						<form class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
						    <input type="hidden" name="_token" value="{{ csrf_token() }}">
						    <fieldset>
						    	<p>
						    		<font size="4">Sign in</font>
						    	</p>
						        <div class="form-group">
						            <label class="col-md-4 control-label" for="email"><font size="2px">username</font></label>
						            <div class="col-md-8">
						                <input class="form-control" tabindex="1"  type="text" name="email" id="email" value="{{ Input::old('email') }}">
						            </div>
						        </div>
						        <div class="form-group">
						            <label class="col-md-4 control-label" for="password">
						                <font size="2px">password</font>
						            </label>
						            <div class="col-md-8">
						                <input class="form-control" tabindex="2"  type="password" name="password" id="password">
						            </div>
						        </div>
						        
						        <div class="form-group">
						            <div class="col-md-offset-2 col-md-10">
						                <div class="checkbox">
						                    <label for="remember">{{ Lang::get('confide::confide.login.remember') }}
						                        <input type="hidden" name="remember" value="0">
						                        <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
						                    </label>
						                </div>
						            </div>
						        </div>
							
								
						        @if ( Session::get('error') )
						        <div class="alert alert-danger">{{ Session::get('error') }}</div>
						        @endif
						
						        @if ( Session::get('notice') )
						        <div class="alert">{{ Session::get('notice') }}</div>
						        @endif
						
						        <div class="form-group">
						            <div class="col-md-offset-2 col-md-10">
						                <button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide::confide.login.submit') }}</button>
						                <a class="btn btn-default" href="{{{URL::to('user/forgot')}}}">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
						            </div>
						        </div>
						        <hr />
						        <div class="form-group">
						            <div class="col-md-offset-2 col-md-10">
						                <a href = "{{{URL::to('user/fb')}}}" class="btn btn-primary">Login with Facebook</a>
						            </div>
						        </div>
						    </fieldset>
						</form>
					</div>
					</div>
					<div style="height: 100%; width: 45%; float: right;">
					 	
						<font size="4">I am new to Lovedinings</font> 
						<br />
						<br />
						
						<a href="{{{ URL::to('user/create') }}}" class="btn btn-warning" target="_blank">Create my account</a>
					</div>
				@else
					@if(Session::get('socialUser.isLogin'))
						<?php $statement = ($campaign->allow_duplicate_user == 0 && count(UserCampaign::where('campaign_id','=',$campaign->id)->where('social_id','=',Session::get('socialUser.id'))->first()) == 0);?>
					@elseif(Auth::check())
						<?php $statement = ($campaign->allow_duplicate_user == 0 && count(UserCampaign::where('campaign_id','=',$campaign->id)->where('user_id','=',Auth::user() -> id)->first()) == 0);?>
					@endif
					@if ($campaign->allow_duplicate_user == 1 || $statement)
					<div class="row">
						<div class="col-md-12">
							<center><h4><font color="#0D8FA9">Requested Information</font> </h4></center>
							<br/>
			
							<form class="form-horizontal" name = "form_register" method="post" action="" autocomplete="off">
								<!-- CSRF Token -->
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<!-- ./ csrf token -->
								
								<!-- Left Column -->
								<div class="col-md-12">
									@if($campaign->show_firstname == 1)
									<label class="control-label" for="Firstname"> Firstname</label>&nbsp;<font color="red">{{{ $errors->first('firstname', ':message') }}}</font>
									{{ Form::text('firstname',Input::old('firstname', Session::get('socialUser.isLogin') ? Session::get('socialUser.first_name') : Auth::user() -> firstname) , array('class'=>'form-control', 'placeholder'=>'Fistname'))}} </p>
			
									@endif
									@if($campaign->show_lastname == 1)
									<label class="control-label" for="Lastname"> Lastname</label>&nbsp;<font color="red">{{{ $errors->first('lastname', ':message') }}}</font>
									{{ Form::text('lastname',Input::old('lastname', Session::get('socialUser.isLogin') ? Session::get('socialUser.last_name') : Auth::user() -> lastname) , array('class'=>'form-control', 'placeholder'=>'Lastname'))}} </p>
			
									@endif
									
									@if($campaign->show_email == 1)
									<label class="control-label" for="Email"> Email</label>&nbsp;<font color="red">{{{ $errors->first('email', ':message') }}}</font>
									{{ Form::text('email',Input::old('email', Session::get('socialUser.isLogin') ? Session::get('socialUser.email') : Auth::user() -> email) , array('class'=>'form-control', 'placeholder'=>'Email'))}} </p>
			
									@endif

									@if($campaign->show_cid == 1)
									<label class="control-label" for="Cid"> Citizen ID</label>&nbsp;<font color="red">{{{ $errors->first('cid', ':message') }}}</font>
									{{ Form::text('cid',Input::old('cid', isset($cid) ? $cid : null) , array('class'=>'form-control', 'placeholder'=>'ID Card'))}} </p>
			
									@endif
									@if($campaign->show_dob == 1)
									<label class="control-label" for="dob"> Date of Birth</label>&nbsp;<font color="red">{{{ $errors->first('dob', ':message') }}}</font>
									<br/>
									<input type="text" name ="dob" id="datepicker" class = "form-control-static" placeholder="MM/DD/YYYY" readonly="true">
									<br/>
			
									@endif
									@if($campaign->show_tel == 1)
									<label class="control-label" for="Tel"> Tel</label>&nbsp;<font color="red">{{{ $errors->first('tel', ':message') }}}</font>
									{{ Form::text('tel',Input::old('tel', isset($tel) ? $tel: null) , array('class'=>'form-control', 'placeholder'=>'Tel'))}} </p>
			
									@endif
									
									@if($campaign->opt1_name != '')
									<label class="control-label" for="opt1"> {{{$campaign->opt1_name}}}</label>&nbsp;<font color="red">{{{ $errors->first('opt1', ':message') }}}</font>
									{{ Form::text('opt1',Input::old('opt1', isset($opt1) ? $opt1: null) , array('class'=>'form-control', 'placeholder'=>$campaign->opt1_name))}}</p>
			
									@endif
									@if($campaign->opt2_name != '')
									<label class="control-label" for="opt2"> {{{$campaign->opt2_name}}}</label>&nbsp;<font color="red">{{{ $errors->first('opt2', ':message') }}}</font>
									{{ Form::text('opt2',Input::old('opt2', isset($opt2) ? $opt2: null) , array('class'=>'form-control', 'placeholder'=>$campaign->opt2_name))}}</p>
			
									@endif
									@if($campaign->opt3_name != '')
									<label class="control-label" for="opt3"> {{{$campaign->opt3_name}}}</label>&nbsp;<font color="red">{{{ $errors->first('opt3', ':message') }}}</font>
									{{ Form::text('opt3',Input::old('opt3', isset($opt3) ? $opt3: null) , array('class'=>'form-control', 'placeholder'=>$campaign->opt3_name))}}</p>
			
									@endif
								</div>
								<!-- ./ Optional -->
			
								<!-- Form Actions -->

								<div class="col-md-12">
									<center>
									<br/>
									<button type="submit" class="btn btn-primary">
										Request Voucher
									</button>
									</center>
								</div>
								<!-- ./ form actions -->
						</div>
						</form>
					</div>
					@else
						You already registered for this voucher!!
						<p />
						@if(Session::get('socialUser.isLogin'))
							<?php $userCampaign = UserCampaign::where('social_id','=',Session::get('socialUser.id'))->where('campaign_id','=',$campaign->id)->first()?>				
						@elseif(Auth::check())
							<?php $userCampaign = UserCampaign::where('user_id','=',Auth::id())->where('campaign_id','=',$campaign->id)->first()?>		
						@endif
						Click <a href="{{{ URL::to('campaign/voucher/'.$campaign->id.'/'.$userCampaign->id) }}}" target="_blank">here</a> to see your voucher.
						<p />
					@endif
				@endif	
				</div>
					<center style="color:#0D8FA9;"><a href="{{{ Post::find($campaign->post_id)->url() }}}" class="btn btn-primary" target="_blank">review</a>
					</center>
				</div>
				<br/>
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
		$("#register_panel").show();
		$("#voucher_nav_panel").hide();
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
  			maxSlides: 5
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
			hideflash : true,
			deeplinking:false
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
@stop
