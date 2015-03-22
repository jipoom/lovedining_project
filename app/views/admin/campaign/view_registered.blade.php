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
		{{{ $title }}}	
	</h3>
</div>
@if (count($userCampaign) > 0)
	<P><a target = '_blank' href="{{{ URL::to('admin/campaign/'.$campaign.'/export') }}}" class="btn btn-default btn-xs">Export table to PDF</a></p>
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
	
@endif
@stop