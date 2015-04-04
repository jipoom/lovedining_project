@extends('admin.layouts.modal')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
 	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
 
	#sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@stop
{{-- Content --}}
@section('content')
	
	<!--<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
	</ul>-->
	{{-- Edit Category Form --}}
	<div id="selected_banner">
	<h4>Reviews selected to be highlight(s)</h4>
	<p></p>
	<hr>
	<p></p>
	<div class="pull-right">
			<button id="save" class="btn btn-success">save order</button>
	</div>
	<ul id="sortable">
		@foreach(Post::where('is_highlight','=',1)->orderBy('rank')->get() as $post)
	    <li class="ui-state-default" id='{{$post->id}}'>{{$post->title}}  <p align="right"><a href="{{{ URL::to('admin/home/highlight/remove/'.$post->id) }}}" class="btn btn-xs btn-danger">remove</a></p></li>
	    @endforeach

	</ul>
	</div>
	<form class="form-horizontal" method="post" action="" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

	
	
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<table id="blogs" class="display">
						<thead>

							<tr>

								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.title') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
								<th class="col-md-2">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
								<th class="col-md-2">Highlight</th>
								<th class="col-md-2">Set to Highlight</th>

							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<!-- Form Actions -->
					<div class="form-group">
						<div class="col-md-12">
							<button type="reset" class="btn btn-danger">Reset</button>
							<button type="submit" class="btn btn-success">
								Submit
							</button>
						</div>
					</div>

			</div>
			<!-- ./ general tab -->

	
	</form>
@stop
@section('scripts')

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
			"sAjaxSource" : "{{ URL::to('admin/home/customhighlight') }}",
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
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>
  $(function() {
    $( "#sortable" ).sortable({
        update : function () {
	    //var order = $('#sortable').sortable('toArray').toString();
            //alert(order)
	}
    }).disableSelection();
    $( "#sortable" ).disableSelection();
    $( "#save" ).click(saveOrder);
    function saveOrder(){
        order = $('#sortable').sortable('toArray').toString();
        var result = $.ajax({
	          url: "{{URL::to('admin/home/highlight_order/setHighlightRank')}}",
	          data : { order : order},
	          dataType:"text",
	          async: false
	          }).responseText;
      	if(result == "1"){
      		window.location.reload();
      	}
      	else{
      		alert("ploblem exists reordering highlight, please try again")
      	}
	      		// enable textbox
    }
  });
  </script>
@stop
