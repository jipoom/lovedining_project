<?php
require_once(public_path().'/mpdf60/mpdf.php');

?>
@extends('admin.layouts.default')

<script language="JavaScript" src="{{asset('assets/js/datepicker/ts_picker.js')}}"></script>


@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
	<!-- AutoComplete -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<!-- /AutoComplete -->
@stop
{{-- Content --}}
@section('content')

<div class="page-header">
	<h3>
		Converting table to PDF ....

	</h3>
</div>
@if (count($userCampaign) > 0)
	<?php ob_start(); ?>
	<h3>{{{ $title }}}</h3>
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
			@if($campaign->opt1_name != '')
				<td><center>{{$campaign->opt1_name}}</center></td>
			@endif
			@if($campaign->opt2_name != '')
				<td><center>{{$campaign->opt2_name}}</center></td>
			@endif
			@if($campaign->opt3_name != '')
				<td><center>{{$campaign->opt3_name}}</center></td>
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
				<td><center>{{$user->user_dob}}</center></td>
			@endif
			@if($campaign->show_cid == 1)
				<td><center>{{$user->user_cid}}</center></td>
			@endif
			@if($campaign->opt1_name != '')
				<td><center>{{$user->opt1}}</center></td>
			@endif
			@if($campaign->opt2_name != '')
				<td><center>{{$user->opt2}}</center></td>
			@endif
			@if($campaign->opt3_name != '')
				<td><center>{{$user->opt3}}</center></td>
			@endif
			<td><center>{{$user->campaign_code}}</center></td>
			<td><center>{{$user->created_at}}</center></td>
		</tr>
		@endforeach
	</table>
	<?Php
		$html = ob_get_contents();
		ob_end_clean();
		$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
		
		$pdf->SetDisplayMode('fullpage');
		$pdf->WriteHTML($html, 2);
		$pdf->Output(storage_path().'/campaign.pdf','F');?>
	<div id="show_file"><p><a href="{{{ URL::to('admin/campaign/stream_pdf') }}}" id="open_pdf">เปิดไฟล์ที่นี่</a></p></div>
@endif
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
