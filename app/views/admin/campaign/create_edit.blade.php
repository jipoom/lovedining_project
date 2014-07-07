@extends('admin.layouts.modal')

<script language="JavaScript" src="{{asset('assets/js/datepicker/ts_picker.js')}}"></script>



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
						
						 <label class="control-label" for="postId">ร้านอาหาร</label>
						
						 {{ Form::select('postId', $restaurant, Input::old('postId', isset($campaign) ? $campaign->post_id: null)); }} </p>  
						
						 <!-- Selection Expiry Date -->
						 <label class="control-label" for="timestamp">Expiry Date</label>
															
						
						{{ Form::text('expiryDate',Input::old('expiryDate', isset($campaign) ? $campaign->expiry_date : null))}} </p>
						{{{ $errors->first('campaign', ':message') }}}


						</p>
						 <label class="control-label" for="description">Description</label>
						 {{ Form::textarea('description', Input::old('description', isset($campaign) ? $campaign->description : null), array('rows'=>'5'))}} </p>
						 {{{ $errors->first('description', ':message') }}}	
						
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


@stop
