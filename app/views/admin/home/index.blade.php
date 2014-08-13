@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Blogs administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Blogs administration index @stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3> {{{ $title }}} </h3>
</div>

<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">Banner</a>
	</li>
	<li>
		<a href="#tab-highlight" data-toggle="tab">Highlight</a>
	</li>
	<li>
		<a href="{{{ URL::to('admin/elfinder/tinymce')."/".Config::get('app.banner') }}}" class="iframe">Upload banner images</a>
	</li>
</ul>
<p></p>
<form class="form-horizontal" method="post" action="{{URL::to('admin/home/setHome')}}" autocomplete="off">
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
					<table id="blogs" class="display">
						<thead>

							<tr>

								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.title') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
								<th class="col-md-2">Home</th>
								<th class="col-md-2">Set to Banner</th>

							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<!-- Form Actions -->
					<div class="form-group">
						<div class="col-md-12">
							<a href="{{ URL::to('admin/home') }}" class="btn btn-danger">Reset</a>
							<button type="submit" class="btn btn-success">
								Submit
							</button>
						</div>
					</div>

					<!-- ./ form actions -->

				</div>
			</div>
		</div>
		<!-- ./ General tab -->
		<!-- Highlight Tab -->
		<div class="tab-pane" id="tab-highlight">

			<div>
			<button type="button" value = "recent" class="btn btn-small btn-info" onclick="changeOrder(this.value)">
			แสดงตามรีวิวล่าสุด
			</button>
			<button type="button" value = "random" class="btn btn-small btn-info" onclick="changeOrder(this.value)">
			แสดงแบบสุ่ม
			</button>
			<button type="button" value = "popular" class="btn btn-small btn-info" onclick="changeOrder(this.value)">
			แสดงตามความนิยม
			</button>
			<!--<a href="{{{ URL::to('admin/order/custom') }}}" class="btn btn-small btn-info iframe"> กำหนดรูปแบบเอง</a>-->

			<button type="button" value = "{{$mode}}" class="btn btn-small btn-info" onclick="saveOrder(this.value)">
			<span class="glyphicon glyphicon-plus-sign"></span> บันทึก
			</button>

			<div id = "showHighlight">
			@include('admin/home/showHighlight')
			</div>
			<!-- ./showHighlight-->

	</div>
	<!-- ./Highlight Tab -->
	</div>
	<!-- ./ tabs content -->
	</div>

</form>
@stop

{{-- Scripts --}}
@section('scripts')
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.bxslider_hightlight').bxSlider({
			mode : 'horizontal',
			infiniteLoop : true,
			auto : true,
			autoStart : true,
			autoDirection : 'next',
			autoHover : true,
			pause : 3000,
			autoControls : false,
			pager : false,
			pagerType : 'full',
			controls : true,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 750,
			adaptiveHeight: true
		});
		
	}); 
</script>
<script>
	function changeOrder(mode) {
		if (mode == "") {
			document.getElementById("txtHint").innerHTML = "";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("showHighlight").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "home/highlight/" + mode, true);
		xmlhttp.send();

	}

	function saveOrder(mode) {
		changeMode = $("#newMode").val();
		if (changeMode != "") {
			mode = changeMode;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("showCategory").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "home/highlight/save/" + mode, true);
		xmlhttp.send();

	}
</script>

<script type="text/javascript">
	

	var oTable;
	$(document).ready(function() {
		oTable = $('#blogs').dataTable({
			"sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ records per page"
			},
			"aaSorting" : [[3, "desc"]],
			"bProcessing" : true,
			"bServerSide" : true,

			"aoColumnDefs" : [{
				"bSearchable" : false,
				"aTargets" : [3]
			}, {
				"bVisible" : false,
				"aTargets" : [3]
			}],
			"sAjaxSource" : "{{ URL::to('admin/home/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%"
				});
			},
			"fnRowCallback" : function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				if (aData[3] == 1) {
					$(nRow).css('font-weight', 'bold');
				}
			}
		});
	}); 
</script>

@stop