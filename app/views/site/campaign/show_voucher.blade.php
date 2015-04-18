@extends('site.layouts.modal_voucher')

{{-- Content --}}
@section('content')
<div class="" style="border-style: ridge; border-width: 5px; border-color: #C0C0C0; margin: 0px 30px 20px 30px; padding: 0px 30px 20px 30px; background-size:10%; background-image: url({{{ asset('assets/img/wm.png') }}});">
	<div style="float: left; width: 30%; margin-top: 1cm; margin-bottom: 10px;"><img src="{{{ asset('assets/img/voucher.png') }}}" alt="Voucher" height="150">
	</div>
	<div style="float: right; width: 25%; padding: 10px; margin: 10px;"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="150" >
	</div>
	<div style="float: right; width: 25%; padding: 10px; margin: 10px;">
		@if($campaign->hotel_logo!="")
		<a href="{{{ $campaign->url() }}}" ><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="150"></a>
		@else
		<a href="{{{ $campaign->url() }}}"><img src="http://placehold.it/260x180" alt="" height="150"></a>
		@endif
	</div>

	<div style="clear: both; margin: 0px; padding: 0px; ">
		<div style="color: #313131; font-size: 20pt; font-style: oblique; margin: 10px; padding: 10px;">
			<p>
				{{$campaign->name}}
			</p>
		</div>

		<div style="color: #424242; font-size: 14pt; ">
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
		</div>
		<div style="color: red; font-size: 12pt;">
			Date expired: {{$campaign->expiry_date}}
		</div>
		<div style="float: right; margin: 20px; padding: 20px;">
			@if($campaign->remark1 != "")
			<p>
				Remark*: {{$campaign->remark1}}
			</p>
			@endif
			@if($campaign->remark2 != "")
			<p>
				Remark**: {{$campaign->remark2}}
			</p>
			@endif
		</div>
	</div>
</div>
@stop
@section('scripts')

@stop
