@extends('admin.layouts.default')

<script language="JavaScript" src="{{asset('assets/js/datepicker/ts_picker.js')}}"></script>


@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
	<!-- AutoComplete -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<!-- /AutoComplete -->
	<style>
		#export {
			float: right;
			display: block;
			margin-bottom: 20px;
		}
		#table {
			display: block;
			width: 100%;
		}
	</style>
@stop
{{-- Content --}}
@section('content')

<div class="page-header">
	<h3>
		{{{ $title }}}	
	</h3>
</div>
@if (count($userCampaign) > 0)
	<div id="export">
		<p><a target = '_blank' href="{{{ URL::to('admin/campaign/'.$campaign->id.'/export_registered') }}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-down"></span> Export table to PDF</a>
		<a target = '_blank' href="{{{ URL::to('admin/campaign/'.$campaign->id.'/export_excel_registered') }}}" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Export table to Excel</a></p>
	</div>
	<div id="table">
		<br/>
		<br/>
		<br/>
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
				<th width="100">Date of Birth</th>
			@endif
			@if($campaign->show_cid == 1)
				<th>ID</th>
			@endif
			@if($campaign->opt1_name != '')
				<th>{{$campaign->opt1_name}}</th>
			@endif
			@if($campaign->opt2_name != '')
				<th>{{$campaign->opt2_name}}</th>
			@endif
			@if($campaign->opt3_name != '')
				<th>{{$campaign->opt3_name}}</th>
			@endif
			<th width="180">Code</th>
			<th width="170">Registered date</th>
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
	</div>
	
@endif
@stop