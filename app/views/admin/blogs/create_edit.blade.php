@extends('admin.layouts.default')

{{-- Content --}}
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
	<!-- AutoComplete -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<!-- /AutoComplete -->
@stop
@section('content')
		
	<div class="page-header">
		<h3>
			{{{ $title }}}
			
			<div class="pull-right">
				@if (isset($post))
					<a href="{{ URL::to('admin/blogs').'/'.$randAlbumName.'/'.$post->id }}" class="btn btn-danger">Cancel</a>
			 	@else
			 		<a href="{{ URL::to('admin/blogs').'/'.$randAlbumName.'/new' }}" class="btn btn-danger">Cancel</a>			 	
			 	@endif
			</div>
		</h3>
	</div>
	
	<!--
	<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-content" data-toggle="tab" onclick="mkDir()">Review Content</a></li>
		</ul>

-->
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
                <div class="form-group {{{ $errors->has('restaurant_name') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">ชื่อร้านอาหาร</label>
						{{ Form::text('restaurant_name', Input::old('restaurant_name', isset($post) ? $post->restaurant_name : null), array('class'=>'form-control', 'placeholder'=>'ชื่อร้านอาหาร'))}} </p>
						{{{ $errors->first('restaurant_name', ':message') }}}
					</div>
				</div>
				<div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">ประเภทร้านอาหาร</label><p>

					 	 <?php $i=0; ?>
					 	 @foreach($category as $temp)
					 	 {{ Form::checkbox('category_id_temp[]', $temp->id, Input::old('category_id_temp[]',(isset($post) && $selectedCategories[$i]==1)? true : null))}}
					 	 	 {{ $temp->category_name}}
							 <P>	 
					 	 	 <?php $i++;?>
					 	 @endforeach
					 	 <p></p>
					 </div>
				</div>
				<div class="form-group {{{ $errors->has('tel') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	
						 <label class="control-label" for="title">เบอร์โทร</label>
						{{ Form::text('tel', Input::old('tel', isset($post) ? $post->tel : null), array('class'=>'form-control', 'placeholder'=>'เบอร์โทรศัพท์ (eg. 021234567, 0987654321)'))}} </p>
						{{{ $errors->first('tel', ':message') }}}<p>
					</div>
				</div>
				<div class="form-group">
                    <div class="col-md-12">
						 <label class="control-label" for="title">ที่อยู่</label></P>
						 {{ Form::text('street_addr', Input::old('street_addr', isset($post) ? $post->street_addr : null), array('placeholder'=>'เลขที่')) }} 
					    {{ Form::text('soi', Input::old('soi', isset($post) ? $post->soi : null), array('placeholder'=>'ซอย')) }} 
					    {{ Form::text('road', Input::old('road', isset($post) ? $post->road : null), array('placeholder'=>'ถนน')) }} 
					      </p>  
					    				   
                       	 	
                      </P>
                        {{ Form::text('tumbol', Input::old('tumbol', isset($post) ? $post->tumbol : null), array('placeholder'=>'แขวง', 'id' => 'tumbol')) }} </p>  
					    {{{ $errors->first('tumbol', ':message') }}}<p>
                      
                        {{ Form::text('amphur', Input::old('amphur', isset($post) ? $post->amphur : null), array('placeholder'=>'เขต', 'id' => 'amphur')) }}  					  
                        {{{ $errors->first('amphur', ':message') }}}<p>
                        
                        {{ Form::text('province', Input::old('province', isset($post) ? $post->province : null), array('placeholder'=>'จังหวัด', 'id' => 'province')) }} 
					    {{{ $errors->first('province', ':message') }}}<p>
                        
                        {{ Form::text('zip', Input::old('zip', isset($post) ? $post->zip : null), array('placeholder'=>'รหัสไปรษณีย์')) }} </p>  
                     
                      
                      	
                        <!-- <label class="control-label" for="title">ชื่ออัลบััมรูป(ภาษาอังกฤษหรือตัวเลขเท่านั้น)</label></P>
                         {{ Form::text('album_name', Input::old('album_name', isset($post) ? $post->album_name : null), array('placeholder'=>'ชื่ออัลบั้ม', 'id' => 'album_name')) }} 
                         {{{ $errors->first('album_name', ':message') }}}<p>
                         -->	 
                         	
                         {{ Form::hidden('album_name', Input::old('album_name', isset($post) ? $post->album_name : $randAlbumName), array('id'=>'album_name')) }} </p>  
                         {{ Form::hidden('post', Input::old('post', isset($post) ? $post : null), array('id'=>'post')) }} </p>  
                         {{ Form::hidden('review_id', Input::old('review_id', isset($post) ? $post->id : 0), array('id'=>'review_id')) }} </p>  
 					</div>
				</div> 	
				<div class="form-group">
                    <div class="col-md-12">
 						<p><label class="control-label" for="profilePic">Profile Picture</label></p>
                          <div id="picture">
                          	@if(isset($post) && $post->profile_picture_name!="")
                          		{{ HTML::image(Config::get('app.image_base_url').'/'.$post->album_name.'/'.$post->profile_picture_name, 'profile picture',array('class'=>'180', 'width'=>'260')) }}
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
	
               
               
         
						
						{{ Form::textarea('content', Input::old('title', isset($post) ? $post->content : null), array('id'=>'elm1', 'rows'=>'25', 'cols' => '130'))}} </p>
						{{{ $errors->first('content', ':message') }}}
		
					</div>
				</div>
				<!-- ./ post title -->

				
			
			
			</div>
				<!-- ./ General tab -->
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
		$('*[name=expiryDate]').appendDtpicker();
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
  tinymce.activeEditor.windowManager.open({

    file: '{{URL::to('admin/elfinder/tinymce')."/".$randAlbumName}}',// use an absolute path!
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
	function mkDir() {
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

	}
</script>
<!-- gen album name -->
	<script src="{{asset('assets/js/jquery.popupWindow.js')}}"></script>
	 <script type="text/javascript"> 
                    $(document).ready(function(){
                        $('#imageUpload').popupWindow({ 
                            windowURL:'{{URL::to('admin/elfinder/default')."/".$randAlbumName}}', 
                            windowName:'Filebrowser',
                            height:490, 
                            width:950,
                            centerScreen:1
                        }); 
                    });
                    
                    function processFile(url,name){
                        $('#picture').html('<img src="' + url + '" height="180" width="260"/>');
                        $('#featured_image').val(name);
                    }
                </script>



@stop
