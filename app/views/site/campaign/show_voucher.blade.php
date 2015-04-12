@extends('site.layouts.modal_voucher')

{{-- Content --}}
@section('content')

<img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="125" class ="logo">
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
@if($campaign->show_firstname == 1)
	<p>
	First name: {{$userCampaign->user_firstname}}
	</p>
@endif
@if($campaign->show_lastname == 1)
	<p>
	Last name: {{$userCampaign->user_lastname}}
	</p>
@endif
<p>
Code: {{$userCampaign->campaign_code}}
</p>
@if($campaign->remark1 != "")
	<p>
	Remark*: {{$campaign->remark1}}
	</p>
@endif
@if($campaign->remark2 != "")
	<p>
	Remark*: {{$campaign->remark2}}
	</p>
@endif

Date expired: {{$campaign->expiry_date}}

@stop
@section('scripts')

@stop
