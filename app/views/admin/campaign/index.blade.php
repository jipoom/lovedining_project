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
		<h3>
			{{{ $title }}}

			<div class="pull-right">
				<a href="{{{ URL::to('admin/campaign/create') }}}" class="btn btn-small btn-info"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="campaign" class="display">
		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/campaign/table.title') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/campaign/table.restaurant') }}}</th>
				<th class="col-md-2">Start Date</th>
				<th class="col-md-2">{{{ Lang::get('admin/campaign/table.expire') }}}</th>
				<th class="col-md-2">Status</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#campaign').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"aaSorting": [[ 3, "desc" ]],
				"bProcessing": false,
		        "bServerSide": true,
		        "aoColumnDefs": [
			      { "bSearchable": false, "aTargets": [ 4,5 ] }
			    ],
		        "sAjaxSource": "{{ URL::to('admin/campaign/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
		
	</script>

@stop