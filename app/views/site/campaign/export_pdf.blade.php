<?php
require_once(public_path().'/mpdf60/mpdf.php');

ini_set('max_execution_time', 300);
ini_set('memory_limit','1024M');
?>
@extends('admin.layouts.default')
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
@stop
@section("content")

<h4><div id="title">กำลังสร้างไฟล์ PDF...</div></h4>
<?php ob_start(); ?>
<table border="1">
  
		<tr>
			<th width="30"></th>
			@if($campaign->show_firstname == 1)
				<th>Firstname</th>
			@endif
			@if($campaign->show_lastname == 1)
				<th>Lastname</th>
			@endif
			@if($campaign->show_email == 1)
				<th>Email</th>
			@endif
			@if($campaign->show_tel == 1)
				<th>Tel</th>
			@endif
			@if($campaign->show_dob == 1)
				<th width="110">Date of Birth</th>
			@endif
			@if($campaign->show_cid == 1)
				<th>ID</th>
			@endif
			<th width="200">Code</th>
			<th width="200">Registered date</th>
		</tr>
		<?php $i = 1;?>
		@foreach($userCampaign as $user)
		<tr>
			
			<td>{{$i++}}</td>
			@if($campaign->show_firstname == 1)
				<td>{{$user->user_firstname}}</td>
			@endif
			@if($campaign->show_lastname == 1)
				<td>{{$user->user_lastname}}</td>
			@endif
			@if($campaign->show_email == 1)
				<td>{{$user->user_email}}</td>
			@endif
			@if($campaign->show_tel == 1)
				<td>{{$user->user_tel}}</td>
			@endif
			@if($campaign->show_dob == 1)
				<td>{{$user->user_dob}}</td>
			@endif
			@if($campaign->show_cid == 1)
				<td>{{$user->user_cid}}</td>
			@endif
			<td>{{$user->campaign_code}}</td>
			<td>{{$user->created_at}}</td>
		</tr>
		@endforeach
</table>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');

$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output(public_path().'/mpdf60/tmp/report.pdf','F');
//Redirect::to(asset('mpdf60/tmp/filename.pdf'));
//header('Location: http://myhost.com/mypage.php');
?>
<div id="show_file"><p><a href="{{asset('mpdf60/tmp/report.pdf')}}">เปิดไฟล์ที่นี่</a></p></div>

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

