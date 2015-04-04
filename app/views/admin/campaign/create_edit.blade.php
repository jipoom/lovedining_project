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
	<!-- Tabs -->
		<!--<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>-->
	<!-- ./ tabs -->
	 @if(!Input::old('album_name'))
	 	<?php $dir = $randAlbumName;?>
 	 @else
 	 	<?php $dir = Input::old('album_name');?>
	 @endif 	
	 <div class="page-header">
		<h3>
			{{{ $title }}}
			
			<div class="pull-right">
				@if (isset($campaign))
					<a href="{{ URL::to('admin/campaign').'/'.$dir.'/'.$campaign->id }}" class="btn btn-danger">Cancel</a>
			 	@else
			 		<a href="{{ URL::to('admin/campaign').'/'.$dir.'/new' }}" class="btn btn-danger">Cancel</a>			 	
			 	@endif
			</div>
		</h3>
	</div>
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
						
						 <label class="control-label" for="postId">Review: </label>
						 {{ Form::text('review',Input::old('to', isset($campaign) ? Post::find($campaign->post_id)->title : null) , array('class'=>'form-control', 'id'=>'review','placeholder'=>'Review Name'))}} </p>
						 {{{ $errors->first('review', ':message') }}}
						
						 
						 <!-- Selection Expiry Date -->
						 <label class="control-label" for="timestamp">Start Date: </label>
															
						
						{{ Form::text('startDate',Input::old('startDate', isset($campaign) ? $campaign->start_date : null))}} </p>
						{{{ $errors->first('startDate', ':message') }}}

						 
						 <!-- Selection Expiry Date -->
						 <label class="control-label" for="timestamp">Expiry Date: </label>
															
						
						{{ Form::text('expiryDate',Input::old('expiryDate', isset($campaign) ? $campaign->expiry_date : null))}} </p>
						{{{ $errors->first('expiryDate', ':message') }}}


						</p>
						 <label class="control-label" for="description">Detail: </label>
						 {{ Form::textarea('description', Input::old('description', isset($campaign) ? $campaign->description : null), array('rows'=>'5'))}} </p>
						 {{{ $errors->first('description', ':message') }}}	</p>
						 
						  <label class="control-label" for="description">Remark 1: </label>
						 {{ Form::text('remark1',Input::old('remark1', isset($campaign) ? $campaign->remark1 : null))}} </p>
						{{{ $errors->first('remark1', ':message') }}}</p>
						
						<label class="control-label" for="description">Remark 2: </label>
						 {{ Form::text('remark2',Input::old('remark2', isset($campaign) ? $campaign->remark2 : null))}} </p>
						{{{ $errors->first('remark2', ':message') }}}</p>
						
						<label class="control-label" for="description">Optional field 1 Name: (Leave it empty to ignore this field) </label>
						 {{ Form::text('opt1_name',Input::old('opt1_name', isset($campaign) ? $campaign->opt1_name : null))}} </p>
						{{{ $errors->first('opt1_name', ':message') }}}</p>
						
						<label class="control-label" for="description">Optional field 2 Name: (Leave it empty to ignore this field)</label>
						 {{ Form::text('opt2_name',Input::old('opt2_name', isset($campaign) ? $campaign->opt2_name : null))}} </p>
						{{{ $errors->first('opt2_name', ':message') }}}</p>
							
						<label class="control-label" for="description">Optional field 3 Name: (Leave it empty to ignore this field)</label>
						 {{ Form::text('opt3_name',Input::old('opt3_name', isset($campaign) ? $campaign->opt3_name : null))}} </p>
						{{{ $errors->first('opt3_name', ':message') }}}</p>
								
						<label class="control-label" for="description">Allow duplicate registration?</label>
						@if(isset($campaign))
							@if($campaign->allow_duplicate_user == 1)
								{{ Form::radio('dupRegis', 1,Input::old('dupRegis',true)) }} Yes
								{{ Form::radio('dupRegis', 0, Input::old('dupRegis',false)) }} No</p>
							@else
								{{ Form::radio('dupRegis', 1,Input::old('dupRegis',false)) }} Yes
								{{ Form::radio('dupRegis', 0, Input::old('dupRegis',true)) }} No</p>
							@endif
						@else
							{{ Form::radio('dupRegis', 1,Input::old('dupRegis',false)) }} Yes
							{{ Form::radio('dupRegis', 0, Input::old('dupRegis',true)) }} No</p>
						@endif
						<br><label>Field Management</label></br>
						{{ Form::checkbox('show_firstname',1,Input::old('show_firstname', isset($campaign) ? $campaign->show_firstname : 1)) }} Include Name</p>
						{{ Form::checkbox('show_lastname',1,Input::old('show_lastname', isset($campaign) ? $campaign->show_lastname : 1)) }} Include Lastname</label></p>
						{{ Form::checkbox('show_cid',1,Input::old('show_cid', isset($campaign) ? $campaign->show_cid : 1)) }} Include ID</label></p>
						{{ Form::checkbox('show_dob',1,Input::old('show_dob', isset($campaign) ? $campaign->show_dob : 1)) }} Include Date of Birth</label></p>
						{{ Form::checkbox('show_email',1,Input::old('show_email', isset($campaign) ? $campaign->show_email : 1)) }} Include Email</label></p>
						{{ Form::checkbox('show_tel',1,Input::old('show_tel', isset($campaign) ? $campaign->show_tel : 1)) }} Include Tel</label></p>
						
						{{ Form::checkbox('isActive',1,Input::old('isActive', isset($campaign) ? $campaign->isActive : 0)) }}<label class="control-label" for="description"> Activate/Deactivate</label></p>
						
						
						<div class="form-group">
		                    <div class="col-md-12">
		 						<p><label class="control-label" for="hotelLogo">Hotel Logo</label></p>
		                          <div id="picture">
		                          	@if(isset($campaign) && $campaign->hotel_logo!="")
		
		                          		<img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" height="180" width="260"/>
		                          		
		                          	@else
		                          		<img src="http://placehold.it/260x180" alt="">
		                          	@endif
				                   
				             	</div>
				        	</div>
						</div>  
				        <div class="button-group">
				                	 {{ Form::hidden('hotel_logo', Input::old('hotel_logo', isset($campaign) && $campaign->hotel_logo!="" ? $campaign->hotel_logo : null), array('id'=>'featured_image')) }} </p>  
				             
				                   <!-- <input type="hidden" id="featured_image" placeholder="Profile Picture" readonly name="profilePic" /> -->
				                    <button type="button" class="browse" id="imageUpload" > Browse Image</button>
				        </div>
								
						
						 @if(!Input::old('album_name') && !isset($campaign))
						 	<?php mkdir(Config::get('app.image_path') . '/' . $randAlbumName);?>
						 	<?php mkdir(Config::get('app.image_path') . '/' . $randAlbumName.'/banner');?>
						 	{{ Form::hidden('album_name', Input::old('album_name', isset($campaign) ? $campaign->album_name : $randAlbumName), array('id'=>'album_name')) }} </p>  
	                     @else
	                     	{{ Form::hidden('album_name', Input::old('album_name', isset($campaign) ? $campaign->album_name : Input::old('album_name')), array('id'=>'album_name')) }} </p>  
	                     
						 @endif 	
					
					</div>
				</div>
				<!-- ./ post title -->

			</div>
			<!-- ./ general tab -->

			

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Save</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>


@stop
@section('scripts')
<script src="{{asset('assets/js/jquery.popupWindow.js')}}"></script>
<script type="text/javascript"> 
$(document).ready(function(){
	var dir = $("#album_name").val();
    $('#imageUpload').popupWindow({ 
        windowURL:'{{URL::to('admin/elfinder/default')."/"}}'+dir, 
        windowName:'Filebrowser',
        height:490, 
        width:950,
        centerScreen:1
    }); 
    // <!-- Apply dropdown check list to the selected items  -->

});

function processFile(url,name){
    $('#picture').html('<img src="' + url + '" height="180" width="260"/>');
    $('#featured_image').val(name);
}
</script>
<!-- DatePicker -->
<script src="{{asset('assets/js/jquery.simple-dtpicker.js')}}"></script>
<script>
//DatePicker
$(function(){
		$('*[name=expiryDate]').appendDtpicker();
		$('*[name=startDate]').appendDtpicker();
});
</script>
<!-- /DatePicker -->
<!-- AutoComplete -->
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<!-- /AutoComplete -->
<script>
$(function() {

	$('#review').autocomplete(
	{
		 source:'{{URL::to('admin/campaign/search')}}',
		 minLength: 2,
	})

});
</script>
@stop
