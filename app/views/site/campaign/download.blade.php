<?php
require_once(public_path().'/mpdf60/mpdf.php');

?>
@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<?php ob_start(); ?>
<div class="" style="border-style: ridge; border-width: 5px; border-color: #C0C0C0; margin: auto 30px 30px 30px; padding: auto 30px 30px 30px; background-color: #eeeeff;" align="center;">
<p align="right;"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="150" class ="logo">

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
		$pdf->WriteHTML($html, 2);
		$pdf->Output(storage_path().'/'.$userCampaign->id.'.pdf','F');?>
<div class="btn btn-default" style="margin: auto;"><a href="{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}" id="open_pdf" target="_blank">เปิด Voucher</a></div>
@stop
@section('scripts')
<script>
$( document ).ready(function() {
	$("#show_file").hide();
setTimeout(function(){showDownload()},1000);
});
function showDownload(){
	alert('สร้างไฟล์  PDF สำเร็จ');
	$("#title").text("สร้างไฟล์  PDF สำเร็จ");
	$("#show_file").show();
}
</script>
@stop
