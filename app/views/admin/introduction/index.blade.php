@extends('admin.layouts.default')

{{-- Content --}}
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
@stop
@section('content')
		
	<div class="page-header">
		<h3>
			{{{ $title }}}
			
		</h3>
	</div>


	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($post)){{ URL::to('admin/introduction/' . $introduction->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
				<!-- General tab -->
			<div class="tab-pane active" id="tab-general">

			<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
					<div class="col-md-12">
						{{ Form::textarea('content', Input::old('title', isset($introduction) ? $introduction->content : null), array('id'=>'elm1', 'rows'=>'25', 'cols' => '130'))}} </p>
						{{{ $errors->first('content', ':message') }}}
						

					</div>
				</div>
				
			
			
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


@stop
