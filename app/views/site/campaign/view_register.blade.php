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
</style>
<link rel="stylesheet" href="{{asset('assets/css/preettyphoto/prettyPhoto.css')}}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
<h3>รายละเอียด Campaign</h3>
<div class="col-md-3 pull-right">
	<div class="movieinfo" >
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
</div>
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<!-- ./ post title -->

		<!-- Post Content -->

		<div class="row">
			<div class="col-md-6">
			@if($campaign->hotel_logo!="")			
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
			@else
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
			
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy($campaign->description) }}
				</p>
			</div>
		</div>
						<p>
					<a href="{{{ Post::find($campaign->post_id)->url() }}}">Review</a>
					
					
					
				</p>
				
		<div class="row">
			<div class="col-md-8">
				<p></p>
				
			</div>
		</div>
		<hr />
		@if ( ! Auth::check())
			You need to be logged in to register for this Voucher.
			<br />
			<br />
			Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
			<br />
			<br />
		@else
			@if ($campaign->allow_duplicate_user == 0 && count(UserCampaign::where('campaign_id','=',$campaign->id)->where('user_id','=',Auth::user() -> id)->first()) > 0)
				You already registered for this voucher!!
				<p />
				Click <a href="{{{ URL::to('user/login') }}}">here</a> to see your voucher.
				<p />
			@else
				<div class="row">
					<div class="col-md-12">
					  <h3>ลงทะเบียนรับ Voucher</h3>
					  <form class="form-horizontal" name = "form_register" method="post" action="" autocomplete="off">
						<!-- CSRF Token -->
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<!-- ./ csrf token -->
					  @if($campaign->show_firstname == 1)
					 	<label class="control-label" for="Firstname"> Firstname</label> <font color="red">{{{ $errors->first('firstname', ':message') }}}</font>
									{{ Form::text('firstname',Input::old('firstname', isset($firstname) ? $firstname : Auth::user() -> firstname) , array('class'=>'form-control', 'placeholder'=>'Fistname'))}} </p>
									
					  @endif	
					  @if($campaign->show_lastname == 1)
					 	<label class="control-label" for="Lastname"> Lastname</label>  <font color="red">{{{ $errors->first('lastname', ':message') }}}</font>
									{{ Form::text('lastname',Input::old('lastname', isset($lastname) ? $lastname : Auth::user() -> lastname) , array('class'=>'form-control', 'placeholder'=>'Lastname'))}} </p>
									
						
					  @endif
					  @if($campaign->show_email == 1)
					 	<label class="control-label" for="Email"> Email</label>  <font color="red">{{{ $errors->first('email', ':message') }}}</font>
									{{ Form::text('email',Input::old('email', isset($email) ? $lastname : Auth::user() -> email) , array('class'=>'form-control', 'placeholder'=>'Email'))}} </p>
									
						
					  @endif	
					  @if($campaign->show_cid == 1)
					 	<label class="control-label" for="Cid"> Citizen ID</label>  <font color="red">{{{ $errors->first('cid', ':message') }}}</font>
									{{ Form::text('cid',Input::old('cid', isset($cid) ? $cid : null) , array('class'=>'form-control', 'placeholder'=>'ID Card'))}} </p>
									
						
					  @endif	
					  @if($campaign->show_tel == 1)
					 	<label class="control-label" for="Tel"> Tel</label>  <font color="red">{{{ $errors->first('tel', ':message') }}}</font>
									{{ Form::text('tel',Input::old('tel', isset($tel) ? $tel: null) , array('class'=>'form-control', 'placeholder'=>'Tel'))}} </p>
									
						
					  @endif
					  @if($campaign->show_dob == 1)
					 	<label class="control-label" for="dob"> Date of Birth</label>  <font color="red">{{{ $errors->first('dob', ':message') }}}</font>
									<p><input type="text" name ="dob" id="datepicker" class = "" placeholder="MM/DD/YYYY" readonly="true"></p>
					 	
					  @endif
					   @if($campaign->opt1_name != '')
					 	<label class="control-label" for="opt1"> {{{$campaign->opt1_name}}}</label>  <font color="red">{{{ $errors->first('opt1', ':message') }}}</font>
									<p><input type="text" name ="opt1" placeholder="{{{$campaign->opt1_name}}}"></p>
					 	
					  @endif
					  @if($campaign->opt2_name != '')
					 	<label class="control-label" for="opt2"> {{{$campaign->opt2_name}}}</label>  <font color="red">{{{ $errors->first('opt2', ':message') }}}</font>
									<p><input type="text" name ="opt2" placeholder="{{{$campaign->opt2_name}}}"></p>
					 	
					  @endif
					  @if($campaign->opt3_name != '')
					 	<label class="control-label" for="opt3"> {{{$campaign->opt3_name}}}</label>  <font color="red">{{{ $errors->first('opt3', ':message') }}}</font>
									<p><input type="text" name ="opt3" placeholder="{{{$campaign->opt3_name}}}"></p>
					 	
					  @endif
					  
					  <!-- Form Actions -->
						<div class="form-group">
							<div class="col-md-12">
								<button type="reset" class="btn btn-default">Reset</button>
								<button type="submit" class="btn btn-success">Save</button>
							</div>
						</div>
						<!-- ./ form actions -->
					</div>
					</form>
				</div>

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