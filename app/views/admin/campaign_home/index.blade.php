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
		<a href="#tab-general" data-toggle="tab" id="banner_tab">Banner</a>
	</li>
</ul>
<p></p>
<div id="selected_banner">
<h4>Campaigns selected to be banner(s)</h4>
<p></p>
<table style="width:50%">
@foreach(Campaign::where('is_home','=',1)->get() as $temp)
	<tr>
		<td>
			{{$temp->name}} 
		</td>
		<td>
			<a href="{{{ URL::to('admin/campaign_home/banner/remove/'.$temp->id) }}}" class="btn btn-xs btn-danger">remove</a>
		</td>
	</tr>
@endforeach
</table>
<hr>
<p></p>
</div>
<form class="form-horizontal" method="post" action="{{URL::to('admin/campaign_home/setBanner')}}" autocomplete="off">
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

								<th class="col-md-2">Name</th>
								<th class="col-md-2"># of users</th>
								<th class="col-md-2">Start Date</th>
								<th class="col-md-2">Expiry Date</th>
								<th class="col-md-2">Home</th>
								<th class="col-md-2">Set to Banner</th>

							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<!-- Form Actions -->
					<div class="form-group">
						<div class="col-md-12">
							<a href="{{ URL::to('admin/campaign_home') }}" class="btn btn-danger">Reset</a>
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
	</div>
	<!-- ./ tabs content -->
	</div>

</form>
@stop

{{-- Scripts --}}
@section('scripts')
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$( "#highlight_tab" ).click(function() {
  		$( "#selected_banner" ).hide()
	});
	$( "#banner_tab" ).click(function() {
  		$( "#selected_banner" ).show()
	});
</script>
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
				"aTargets" : [4]
			}, {
				"bVisible" : false,
				"aTargets" : [4]
			}],
			"sAjaxSource" : "{{ URL::to('admin/campaign_home/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "90%",
					height : "90%"
				});
			},
			"fnRowCallback" : function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				if (aData[4] == 1) {
					$(nRow).css('font-weight', 'bold');
				}
			}
		});
	}); 
</script>

@stop