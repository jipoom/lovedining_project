<?php
require_once (public_path() . '/mpdf60/mpdf.php');
?>
@extends('site.layouts.default')

@section('styles')
<!-- put style here -->
@stop
{{-- Content --}}
@section('content')
<?php ob_start(); ?>
<div class="" style="border-style: ridge; border-width: 5px; border-color: #C0C0C0; margin: 0px 30px 0px 30px; padding: 0px 30px 0px 30px; background-size:10%; background-image: url({{{ asset('assets/img/wm.png') }}});"  align="center;">
	<div style="float: left; width: 46%; margin-top: 1cm; margin-bottom: 10px;"><img src="{{{ asset('assets/img/voucher.png') }}}" alt="Voucher" height="200">
	</div>
	<div style="float: right; position: absolute; right:0px; width: 25%; padding: 0px; margin: 0px;"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="150px" class ="logo">
	</div>
	<div style="float: right; position: absolute; right:0px; width: 25%; padding: 0px; margin: 0px;">
		@if($campaign->hotel_logo!="")
		<a href="{{{ $campaign->url() }}}" ><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="150"></a>
		@else
		<a href="{{{ $campaign->url() }}}"><img src="http://placehold.it/260x180" alt="" height="150"></a>
		@endif
	</div>

	<div style="clear: both; margin: 0pt; padding: 0pt; ">
		<div style="color: #313131; font-size: 20pt; font-style: oblique; margin: 0px; padding: 0px; line-height: 30%">
			<p>
				{{$campaign->name}}
			</p>
		</div>

		<div style="color: #424242; letter-spacing: 0.1em; font-size: 14pt; line-height: 80%;">
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
		<div style="float: right; line-height: 50%">
			@if($campaign->remark1 != "")
			<p>
				* {{$campaign->remark1}}
			</p>
			@endif
			@if($campaign->remark2 != "")
			<p>
				** {{$campaign->remark2}}
			</p>
			@endif
		</div>
	</div>
</div>
<?Php
	$html = ob_get_contents();
	ob_end_clean();
	$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
	$pdf -> SetDisplayMode('fullpage');
	//$stylesheet = '<style>'.file_get_contents(asset('bootstrap/css/bootstrap.min.css')).'</style>';
	//$pdf->WriteHTML($stylesheet, 1);
	$pdf -> WriteHTML($html, 2);
	$pdf -> Output(storage_path() . '/' . $userCampaign -> id . '.pdf', 'F');
?>
<p>
	<div class="btn btn-default" id = "open_pdf" style="margin: auto;">
		<a href="{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}" id="open_pdf" target="_blank">เปิด Voucher</a>
	</div>
</p>
@stop
@section('scripts')
<script>
	$(document).ready(function() {
		$("#open_pdf").hide();
		setTimeout(function() {
			showDownload()
		}, 1000);
	});
	function showDownload() {
		alert('สร้างไฟล์  PDF สำเร็จ');
		$("#title").text("สร้างไฟล์  PDF สำเร็จ");
		$("#open_pdf").show();
	}
</script>
@stop
