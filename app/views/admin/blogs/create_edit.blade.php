@extends('admin.layouts.default')

{{-- Content --}}
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
	<!-- AutoComplete -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<!-- /AutoComplete -->
	<!-- Dropdown Checklist -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/smoothness-1.8.13/jquery-ui-1.8.13.custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/ui.dropdownchecklist.themeroller.css')}}">
    <!-- /Dropdown Checklist -->
@stop
@section('content')
	 <!-- /In case admin enter invalid info -->
	 @if(!Input::old('album_name'))
	 	<?php $dir = $randAlbumName;?>
 	 @else
 	 	<?php $dir = Input::old('album_name');?>
	 @endif 		
	<div class="page-header">
		<h3>
			{{{ $title }}}
			
			<div class="pull-right">
				@if (isset($post))
					<a href="{{ URL::to('admin/blogs').'/'.$dir.'/'.$post->id }}" class="btn btn-danger">Cancel</a>
			 	@else
			 		<a href="{{ URL::to('admin/blogs').'/'.$dir.'/new' }}" class="btn btn-danger">Cancel</a>			 	
			 	@endif
			</div>
		</h3>
	</div>
	
	
	<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab-general" data-toggle="tab">General</a>
			</li>
			<li>
				<a href="#tab-en" data-toggle="tab">English</a>
			</li>
			<li>
				<a href="#tab-cn" data-toggle="tab">Chinese</a>
			</li>
		</ul>


	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($post)){{ URL::to('admin/blogs/' . $post->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
				<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">ชื่อรีวิว</label>
						{{ Form::text('title',Input::old('title', isset($post) ? $post->title : null) , array('class'=>'form-control', 'placeholder'=>'ชื่อรีวิว'))}} </p>
						{{{ $errors->first('title', ':message') }}}
                    </div>
                </div>
                <!-- Post Title_2 -->
				<div class="form-group {{{ $errors->has('title2') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">ชื่อรีวิว ย่อย</label>
						{{ Form::text('title2',Input::old('title2', isset($post) ? $post->title_2 : null) , array('class'=>'form-control', 'placeholder'=>'ชื่อรีวิว ย่่อย'))}} </p>
						{{{ $errors->first('title2', ':message') }}}
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('restaurant_name') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">ชื่อร้านอาหาร</label>
						{{ Form::text('restaurant_name', Input::old('restaurant_name', isset($post) ? $post->restaurant_name : null), array('class'=>'form-control', 'placeholder'=>'ชื่อร้านอาหาร'))}} </p>
						{{{ $errors->first('restaurant_name', ':message') }}}
					</div>
				</div>
				
				<div class="form-group {{{ $errors->has('meta_description') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Meta Title</label>
						{{ Form::text('meta_title', Input::old('meta_title', isset($post) ? $post->meta_title : null), array('class'=>'form-control', 'placeholder'=>'Meta Title'))}} </p>
						{{{ $errors->first('meta_title', ':message') }}}
					</div>
				</div>
				
				<div class="form-group {{{ $errors->has('meta_description') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Meta Description</label>
						{{ Form::text('meta_description', Input::old('meta_description', isset($post) ? $post->meta_description : null), array('class'=>'form-control', 'placeholder'=>'Meta Description'))}} </p>
						{{{ $errors->first('meta_description', ':message') }}}
					</div>
				</div>
				
				<div class="form-group {{{ $errors->has('meta_keyword') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Meta Keywords</label>
						{{ Form::text('meta_keyword', Input::old('meta_keyword', isset($post) ? $post->meta_keyword : null), array('class'=>'form-control', 'placeholder'=>'Meta Keywords'))}} </p>
						{{{ $errors->first('meta_keyword', ':message') }}}
					</div>
				</div>
				
				<div class="form-group {{{ $errors->has('restaurant_name') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Slug</label>
						{{ Form::text('slug', Input::old('slug', isset($post) ? $post->slug : null), array('class'=>'form-control', 'placeholder'=>'Slug'))}} </p>
						{{{ $errors->first('slug', ':message') }}}
					</div>
				</div>
				
				<!-- Category -->					 
			   <div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">Category</label><p>  						 	
			    		{{Form::select('category_id_temp[]', $category, Input::old('category_id_temp[]',(isset($post))? $selectedCategories : null) , array('id' => 's12','class' => 's12', 'multiple'));}}    
				 	</div>
				</div>
				<!-- /Category -->	
				
				<!-- Food Type -->					 
			   <div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">ประเภทอาหาร</label><p>  
						 	
			    		{{Form::select('foodType_id_temp[]', $foodType, Input::old('foodType_id_temp[]',(isset($post))? $selectedFoodTypes : null) , array('id' => 's12','class' => 's12', 'multiple'));}}    
				 	</div>
				</div>
				<!-- /Food Type -->	
				
				<!-- Dressing -->					 
			   <div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">การแต่งกาย</label><p>   
			    		{{Form::select('dressing_id_temp[]', $dressing, Input::old('dressing_id_temp[]',(isset($post))? $selectedDressings : null) , array('id' => 's12','class' => 's12', 'multiple'));}}    
				 	</div>
				</div>
				<!-- /Dressing -->	
				
				
				<!-- Meal -->					 
			   <div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">มื้ออาหาร</label><p>   
			    		{{Form::select('meal_id_temp[]', $meal, Input::old('meal_id_temp[]',(isset($post))? $selectedMeals : null) , array('id' => 's12','class' => 's12', 'multiple'));}}    
				 	</div>
				</div>
				<!-- /Meal -->	
				<div class="form-group {{{ $errors->has('tel') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	
						 <label class="control-label" for="title">เบอร์โทร</label>
						{{ Form::text('tel', Input::old('tel', isset($post) ? $post->tel : null), array('class'=>'form-control', 'placeholder'=>'เบอร์โทรศัพท์ (eg. 021234567, 0987654321)'))}} </p>
						{{{ $errors->first('tel', ':message') }}}<p>
					</div>
				</div>
	

				<div class="form-group {{{ $errors->has('latitude') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	
						 <label class="control-label" for="title">latitude</label>
						{{ Form::text('latitude', Input::old('latitude', isset($post) ? $post->latitude : null), array('class'=>'form-control', 'placeholder'=>'latitude'))}} </p>
						{{{ $errors->first('latitude', ':message') }}}<p>
					</div>
				</div>
				<div class="form-group {{{ $errors->has('latitude') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	
						 <label class="control-label" for="title">longitude</label>
						{{ Form::text('longitude', Input::old('longitude', isset($post) ? $post->longitude : null), array('class'=>'form-control', 'placeholder'=>'longitude'))}} </p>
						{{{ $errors->first('longitude', ':message') }}}<p>
					</div>
				</div>
				<label class="control-label" for="title">ที่อยู่</label></P>
				<div class="form-group">
                    <div class="col-md-12">

						 {{ Form::text('address1', Input::old('address1', isset($post) ? $post->address1 : null), array('placeholder'=>'address line 1')) }} 
					    {{ Form::text('address2', Input::old('address2', isset($post) ? $post->address2 : null), array('placeholder'=>'address line 2')) }} 
					      </p>  
					    				   
                       	 	
                      </P>
                        {{ Form::text('tumbol', Input::old('tumbol', isset($post) ? $post->tumbol : null), array('placeholder'=>'แขวง', 'id' => 'tumbol')) }} 
					    {{{ $errors->first('tumbol', ':message') }}}
                      
                        {{ Form::text('amphur', Input::old('amphur', isset($post) ? $post->amphur : null), array('placeholder'=>'เขต', 'id' => 'amphur')) }}  					  
                        {{{ $errors->first('amphur', ':message') }}}<p> </P>
                        	
                    
                        {{Form::select('province', $allProvince, Input::old('province',isset($post)? $post->province : null));}}    
				 		
                       
                        
                        {{ Form::text('zip', Input::old('zip', isset($post) ? $post->zip : null), array('placeholder'=>'รหัสไปรษณีย์')) }}<p> </P>
                     
                         <label class="control-label" for="title">วิธีการเดินทาง</label>
                      	{{ Form::text('route', Input::old('zip', isset($post) ? $post->route : null), array('class'=>'form-control','placeholder'=>'วิธีการเดินทาง')) }} </p>  
                     
                      	
                        <!-- <label class="control-label" for="title">ชื่ออัลบััมรูป(ภาษาอังกฤษหรือตัวเลขเท่านั้น)</label></P>
                         {{ Form::text('album_name', Input::old('album_name', isset($post) ? $post->album_name : null), array('placeholder'=>'ชื่ออัลบั้ม', 'id' => 'album_name')) }} 
                         {{{ $errors->first('album_name', ':message') }}}<p>
                         -->	
                         <!-- /In case admin enter invalid info --> 
                         @if(!Input::old('album_name') && !isset($post))
 						 	<?php mkdir(Config::get('app.image_path') . '/' . $randAlbumName);?>
 						 	<?php mkdir(Config::get('app.image_path') . '/' . $randAlbumName.'/banner');?>
 						 	{{ Form::hidden('album_name', Input::old('album_name', isset($post) ? $post->album_name : $randAlbumName), array('id'=>'album_name')) }} </p>  
                         @else
                         	{{ Form::hidden('album_name', Input::old('album_name', isset($post) ? $post->album_name : Input::old('album_name')), array('id'=>'album_name')) }} </p>  
                         
 						 @endif 	
                         {{ Form::hidden('post', Input::old('post', isset($post) ? $post : null), array('id'=>'post')) }} </p>  
                         {{ Form::hidden('review_id', Input::old('review_id', isset($post) ? $post->id : 0), array('id'=>'review_id')) }} </p>  
 						
 					</div>
				</div> 	
				<div class="form-group">
                    <div class="col-md-12"
						 <!-- Selection Published Date -->
						 <label class="control-label" for="timestamp">Published At: </label>	
						<input type="radio" name="radio1" id="published_now" value="now"> Now 
    					<input type="radio" name="radio1" id="published_specified" value="specified" checked="checked">	Specify															
						{{ Form::text('publishedAt',Input::old('publishedAt', isset($post) ? $post->published_at : null), array('id'=>'publishedDate'))}} </p>
						{{{ $errors->first('publishedAt', ':message') }}}
					</div>
				</div> 	
				<div class="form-group">
                    <div class="col-md-12"
						 <!-- Selection Expiry Date -->
						 <label class="control-label" for="timestamp">Expired At: </label>						 
						 @if(isset($post))
						 	@if($post->is_permanent == 1)
								<input type="radio" name="radio2" id="expired_unknown" value="permanent" checked="checked"> Permanent  						
    							<input type="radio" name="radio2" id="expired_specified" value="specified" > Specify
    							{{ Form::text('expiredAt',Input::old('expiredAt', null), array('id'=>'expiredDate'))}} </p>
								{{{ $errors->first('expiredAt', ':message') }}}
								{{ Form::hidden('expired_at', Input::old('expired_at', 1), array('id'=>'permanent')) }} </p>  
                       
    						@else	
    							<input type="radio" name="radio2" id="expired_unknown" value="permanent" > Permanent   						
    							<input type="radio" name="radio2" id="expired_specified" value="specified" checked="checked"> Specify
    							{{ Form::text('expiredAt',Input::old('expiredAt', $post->expired_at), array('id'=>'expiredDate'))}} </p>
								{{{ $errors->first('expiredAt', ':message') }}}
								{{ Form::hidden('expired_at', Input::old('expired_at', 0), array('id'=>'permanent')) }} </p>
    						@endif	
    					 @else
    					 	<input type="radio" name="radio2" id="expired_unknown" value="permanent" checked="checked"> Permanent
    						<input type="radio" name="radio2" id="expired_specified" value="specified" > Specify
    						{{ Form::text('expiredAt',Input::old('expiredAt', null), array('id'=>'expiredDate'))}} </p>
							{{{ $errors->first('expiredAt', ':message') }}}
							{{ Form::hidden('expired_at', Input::old('expired_at', 1), array('id'=>'permanent')) }} </p>
    					 @endif												
						
					</div>
				</div> 	
				
				<div class="form-group">
                    <div class="col-md-12">
 						<p><label class="control-label" for="profilePic">Profile Picture</label></p>
                          <div id="picture">
                          	@if(isset($post) && $post->profile_picture_name!="")

                          		<img src="{{Config::get('app.image_base_url').'/'.$post->album_name.'/'.$post->profile_picture_name}}" height="180" width="260"/>
                          		
                          	@else
                          		<img src="http://placehold.it/260x180" alt="">
                          	@endif
		                   
		             	</div>
		        	</div>
				</div>  
		        <div class="button-group">
		                	 {{ Form::hidden('profilePic', Input::old('profilePic', isset($post) && $post->profile_picture_name!="" ? $post->profile_picture_name : null), array('id'=>'featured_image')) }} </p>  
		             
		                   <!-- <input type="hidden" id="featured_image" placeholder="Profile Picture" readonly name="profilePic" /> -->
		                    <button type="button" class="browse" id="imageUpload" > Browse Image</button>
		        </div>
                <div class="form-group {{{ $errors->has('tel') ? 'error' : '' }}}">
                    <div class="col-md-12">
                          <p><label class="control-label" for="content">Content</label></p>
						<!--{{ Form::textarea('content', Input::old('title', isset($post) ? $post->content : null), array('class'=>'ckeditor', 'rows'=>'10'))}} </p>
						{{{ $errors->first('content', ':message') }}}-->
	
               
               
         
						
						{{ Form::textarea('content', Input::old('content', isset($post) ? $post->content : null), array('id'=>'elm1', 'rows'=>'25', 'cols' => '130'))}} </p>
						{{{ $errors->first('content', ':message') }}}
		
					</div>
				</div>
				<!-- ./ post title -->

				
			
			
			</div>
			<!-- ./ General tab -->
			<!-- / en tab -->
			<div class="tab-pane" id="tab-en">
				<p></p>
				 <label class="control-label" for="title">Describe how to travel to the restaurant</label>
                      	{{ Form::text('route_en', Input::old('route_en', isset($post) ? $post->route_en : null), array('class'=>'form-control','placeholder'=>'Describe how to travel to the restaurant')) }} </p>  
                 <label class="control-label" for="title">Content in English</label>    
				{{ Form::textarea('content_en', Input::old('content_en', isset($post) ? $post->content_en : null), array('id'=>'elm2', 'rows'=>'25', 'cols' => '130'))}} </p>
			</div>	
			<!-- ./ en tab -->
			<!-- / cn tab -->
			<div class="tab-pane" id="tab-cn">
				<p></p>
				 <label class="control-label" for="title">Describe how to travel to the restaurant (in Chinese)</label>
                      	{{ Form::text('route_cn', Input::old('route_cn', isset($post) ? $post->route_cn : null), array('class'=>'form-control','placeholder'=>'Describe how to travel to the restaurant (in Chinese)')) }} </p>  
                 <label class="control-label" for="title">Content in Chinese</label>       
				{{ Form::textarea('content_cn', Input::old('content_cn', isset($post) ? $post->content_cn : null), array('id'=>'elm3', 'rows'=>'25', 'cols' => '130'))}} </p>
			</div>	
			<!-- ./ cn tab -->
		</div>		
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
@section('scripts')
<!-- AutoComplete -->
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<!-- /AutoComplete -->
<script>
$(function() {
	var province = $("#province").val();
	var amphur = $("#amphur").val();
	$('#province').autocomplete(
	{
		 source:'{{URL::to("admin/find/province")}}',
		 minLength: 2,
	})
	$('#amphur').autocomplete(
	{
		 source:'{{URL::to("admin/find/amphur")}}',
		 minLength: 2,
	})
	$('#tumbol').autocomplete(
	{
		 source:'{{URL::to("admin/find/tumbol")}}',
		 minLength: 2,
	})

});
</script>

<!-- DatePicker -->
<script src="{{asset('assets/js/jquery.simple-dtpicker.js')}}"></script>
<script>

//DatePicker
$(function(){
		$('*[name=expiredAt]').appendDtpicker();
		$('*[name=publishedAt]').appendDtpicker();
});

</script>
<!-- /DatePicker -->

<!-- TinyMCE -->
<script type="text/javascript" src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>
<script>
// This must be set to the absolute path from the site root.
//var roxyFileman = '/fileman/index.html?integration=tinymce4';
//var roxyFileman = '{{ URL::to('/assets/fileman/index.html?integration=tinymce4') }}';
  $(function() {
    tinymce.init({
  selector: "textarea",
   width: "300",
   height: "500",
  
  // ===========================================
  // INCLUDE THE PLUGIN
  // ===========================================
	
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste emoticons"
  ],
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image emoticons",
	
  // ===========================================
  // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
  // ===========================================
	
  relative_urls: false,
  file_browser_callback : elFinderBrowser
	
});
});

function elFinderBrowser (field_name, url, type, win) {
  var dir = $("#album_name").val();
  tinymce.activeEditor.windowManager.open({

    file: '{{URL::to('admin/elfinder/tinymce')."/"}}'+dir,// use an absolute path!
    //file: 'http://localhost/elfinder2_1/elfinder.html',
    title: 'elFinder 2.0',
    width: 900,
    height: 450,
    resizable: 'yes'
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
}
</script>
<!-- /TinyMCE -->

<script type="text/javascript">
			$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
</script>

<!-- gen album name -->
<script>
	/*function mkDir() {
		var newDir = $("#album_name").val();
		var id = $("#review_id").val();
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("post").value = xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "{{ URL::to('admin/blogs/makeDir/') }}/"+ newDir+"/"+id , true);
		xmlhttp.send();

	}*/
</script>

<!-- dropdown checklist js -->
<script type="text/javascript" src="{{asset('assets/js/ui.dropdownchecklist.js')}}"></script>   
<!-- gen album name -->
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
                        $(".s12").dropdownchecklist( { 
                        	firstItemChecksAll: true,
                        	emptyText: "Please select ...", width: 150 
                        	} );	
                    });
                    
                    function processFile(url,name){
                        $('#picture').html('<img src="' + url + '" height="180" width="260"/>');
                        $('#featured_image').val(name);
                    }
                    /*new Date(unixTimestamp*1000);
                    var expiry = $("#expired_date").val()
                    if(expiry == 1)    
                    	$("#publishedDate").hide();*/
                   // $("#expiredDate").hide();
                    var permanentSet = $("#permanent").val()
               
                    if(permanentSet == 1)    
                    {
                    	$("#expiredDate").hide()
                    	
                    }
				    $("#published_now").click(function () {
				    	$("#publishedDate").val(null);
				        $("#publishedDate").hide();
				    });
				    $("#published_specified").click(function () {
				        $("#publishedDate").show();
				    });
				    
				  
				    $("#expired_unknown").click(function () {
				    	$("#expiredDate").val(null);
				        $("#expiredDate").hide();
				    });
				    $("#expired_specified").click(function () {	    	
				        $("#expiredDate").show();
				    });
                                       
                </script>



@stop
