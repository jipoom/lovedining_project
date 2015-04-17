<?php
require_once(public_path().'/mpdf60/mpdf.php');

?>
@extends('site.layouts.default')

@section('styles')
<!-- put style here -->
@stop
{{-- Content --}}
@section('content')
<?php ob_start(); ?>
<div class="" style="border-style: ridge; border-width: 5px; border-color: #C0C0C0; margin: auto 30px 30px 30px; padding: auto 30px 30px 30px; background-color: #eeeeff;" align="center;">
<div style="float: left; width: 28%; margin-top: 1cm;"><h1 style="">VOUCHER</h1></div>
<div style="float: right; width: 28%;"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="150" class ="logo"></div>
<div style="float: right; width: 28%;">
@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
	<?php
	$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/',true);
	?>
		<a href="{{$campaign->url()}}"  class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" height="150"/></a>		

@else
		@if($campaign->hotel_logo!="")			
				<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="150"></a>
		@else
				<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt="" height="150"></a>
		@endif
@endif
</div>
<div style="clear: both; margin: 0pt; padding: 0pt; ">
<div style="font-family: Shruti; font-style: oblique; color: aaaaff;">
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
</div>
</div>
<?Php
		$html = ob_get_contents();
		ob_end_clean();
		$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
		$pdf->SetDisplayMode('fullpage');
		//$stylesheet = '<style>'.file_get_contents(asset('bootstrap/css/bootstrap.min.css')).'</style>';
		//$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output(storage_path().'/'.$userCampaign->id.'.pdf','F');?>
<p>
	<div class="btn btn-default" id = "open_pdf" style="margin: auto;"><a href="{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}" id="open_pdf" target="_blank">à¹€à¸›à¸´à¸” Voucher</a></div>
</p>
@stop
@section('scripts')
<script>
$( document ).ready(function() {
	$("#open_pdf").hide();
setTimeout(function(){showDownload()},1000);
});
function showDownload(){
	alert('à¸ªà¸£à¹‰à¸²à¸‡à¹„à¸Ÿà¸¥à¹Œ  PDF à¸ªà¸³à¹€à¸£à¹‡à¸ˆ');
	$("#title").text("à¸ªà¸£à¹‰à¸²à¸‡à¹„à¸Ÿà¸¥à¹Œ  PDF à¸ªà¸³à¹€à¸£à¹‡à¸ˆ");
	$("#open_pdf").show();
}
</script>
@stop