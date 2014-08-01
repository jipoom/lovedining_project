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
	
	<p><h4>Page statistic</p></h4>
	<table id="page" class="display">
		<thead>
			
			<tr>
				<th class="col-md-2">Date</th>
				<th class="col-md-2">Page</th>
				<th class="col-md-2">IP Address</th>
				<th class="col-md-2">Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	
	<table id="review" class="display">
		<thead>
			
			<tr>
				<th class="col-md-2">Date</th>
				<th class="col-md-2">Review</th>
				<th class="col-md-2">IP Address</th>
				<th class="col-md-2">Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	
	<table id="pageCount" class="display">
		<thead>
			
			<tr>
				<th class="col-md-2">Page</th>
				<th class="col-md-2"># of access</th>
				<th class="col-md-2">Last Access</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	
	<table id="reviewCount" class="display">
		<thead>
			
			<tr>
				<th class="col-md-2">Review Name</th>
				<th class="col-md-2"># of access</th>
				<th class="col-md-2">Last Access</th>
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
			oTable = $('#page').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"aaSorting": [[ 0, "desc" ]],
				"bProcessing": true,
		        "bServerSide": true,
		         "aoColumnDefs": [
			      { "bSearchable": false, "aTargets": [ 1 ] }
			    ],
		        "sAjaxSource": "{{ URL::to('admin/stat/page_data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
	
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#review').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"aaSorting": [[ 0, "desc" ]],
				"bProcessing": true,
		        "bServerSide": true,
		         "aoColumnDefs": [
			      { "bSearchable": false, "aTargets": [ 1 ] }
			    ],
		        "sAjaxSource": "{{ URL::to('admin/stat/review_data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
	
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#pageCount').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"aaSorting": [[ 0, "desc" ]],
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/stat/pageCount_data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#reviewCount').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"aaSorting": [[ 0, "desc" ]],
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/stat/reviewCount_data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop
	