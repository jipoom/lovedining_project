@extends('admin.layouts.modal')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">
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
	<table style="width:50%">
	@foreach(Post::where('is_highlight','=',1)->get() as $post)
		<tr>
			<td>
				{{$post->title}} 
			</td>
			<td>
				<a href="{{{ URL::to('admin/home/highlight/remove/'.$post->id) }}}" class="btn btn-xs btn-danger">remove</a>
			</td>
		</tr>
	@endforeach
	</table>
	<hr>
	<p></p>
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
@stop
