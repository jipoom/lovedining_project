@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	{{-- Edit Campaign Form --}}
	<form class="form-horizontal" name = "form_edit" method="post" action="@if (isset($campaign)){{ URL::to('admin/campaign/' . $campaign->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

	
	
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('category') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="campaign">ชื่อ Campaign</label>
						{{ Form::text('campaign',Input::old('campaign', isset($campaign) ? $campaign->name : null) , array('class'=>'form-control', 'placeholder'=>'Campaign name'))}} </p>
						{{{ $errors->first('campaign', ':message') }}}
						
						 <label class="control-label" for="title">ร้านอาหาร</label>
						
						 {{ Form::select('restaurant_name', $restaurant, Input::old('restaurant_name', isset($campaign) ? Campaign::find($campaign->post_id): null)); }} </p>  
						
						 <!-- Selection Expiry Date -->
						 <label class="control-label" for="title">Expiry Date</label>
						 <input type="Text" name="timestamp" value="">
<a href="javascript:show_calendar('document.form_edit.timestamp', document.form_edit.timestamp.value);"><img src="{{asset('assets/js/datepicker/cal.gif')}}" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
						
					
						
					</div>
				</div>
				<!-- ./ post title -->

			</div>
			<!-- ./ general tab -->

			

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>

<script language="JavaScript" src="{{asset('assets/js/datepicker/ts_picker.js')}}"></script>
@stop
