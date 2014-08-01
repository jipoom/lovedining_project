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
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.categories') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
								<th class="col-md-2">Home</th>
								<th class="col-md-2">Set to Home</th>

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
			<h3>
			@if($mode == "recent")
			แสดงตามรีวิวล่าสุด
			@elseif($mode == "random")
			แสดงแบบสุ่ม
			@elseif($mode == "popular")
			แสดงตามความนิยม
			@endif
			</h3>
			<?php for($i=0;$i<count($highlight);$i+=2)
{
?>

<div class="col-md-10">

	<div class="col-md-6">

		<!-- Post Title -->
		<div class="col-md-12">
			<h4><strong><a href="{{{ $highlight[$i]->url() }}}">{{ String::title($highlight[$i]->title) }}</a></strong></h4>
		</div>

		<!-- ./ post title -->

		<!-- Post Content -->

		<div class="col-md-6">
			@if($highlight[$i]->profile_picture_name!="")
			<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$highlight[$i]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($highlight[$i]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($highlight[$i]->district); }}, {{ String::tidy($highlight[$i]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($highlight[$i]->tel); }}
			</p>
		</div>

		<!-- ./ post content -->

		<!-- Post Footer -->

		<div class="col-md-12">
			<p></p>
			<p>

				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $highlight[$i]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $highlight[$i]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $highlight[$i]->url() }}}#comments">{{$highlight[$i]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $highlight[$i]->comments()->count()) }}</a>
			</p>
		</div>

		<!-- ./ post footer -->
	</div>

	<!-- new Column -->
	@if(($i+1)<count($highlight))
	<div class="col-md-6">

		<!-- Post Title -->
	
		<div class="col-md-12">
			<h4><strong><a href="{{{ $highlight[$i+1]->url() }}}">{{ String::title($highlight[$i+1]->
			title) }}</a></strong></h4>
		</div>
	
		<!-- ./ post title -->
	
		<!-- Post Content -->
		<div class="col-md-6">
			@if($highlight[$i+1]->profile_picture_name!="")
			<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$highlight[$i+1]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($highlight[$i+1]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($highlight[$i+1]->district); }}, {{ String::tidy($highlight[$i+1]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($highlight[$i+1]->tel); }}
			</p>
		</div>
	
		<!-- ./ post content -->
	
		<!-- Post Footer -->
	
		<div class="col-md-12">
			<p></p>
			<p>
	
				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $highlight[$i+1]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $highlight[$i+1]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $highlight[$i+1]->url() }}}#comments">{{$highlight[$i+1]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $highlight[$i+1]->comments()->count()) }}</a>
			</p>
		</div>
	
		<!-- ./ post footer -->
	</div>

@endif
<!-- /new Column -->
</div>

<?php
}
?>
		</div>

	</div>
	<!-- ./Highlight Tab -->
	</div>
	<!-- ./ tabs content -->
	</div>

</form>
@stop

{{-- Scripts --}}
@section('scripts')
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
			"sAjaxSource" : "{{ URL::to('admin/home/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%"
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