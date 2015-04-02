@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Blogs administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Blogs administration index @stop
@section('styles')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
@stop
{{-- Content --}}
@section('content')
<div class="page-header">
	<h3> {{{ $title }}} </h3>
</div>

<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab" id="banner_tab">Order management</a>
	</li>
</ul>
<p></p>
<div id="selected_banner">
<div class="pull-right">
			<a href="{{ URL::to('admin/campaign_home') }}" class="btn btn-danger">Reset</a>
			<button id="save" class="btn btn-success">save</button>

	</div>
</div>

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

					<ul id="sortable">
						@foreach($campaigns as $campaign)
					    <li class="ui-state-default" id='{{$campaign->id}}'>{{$campaign->name}} <p align="right">(expires at {{$campaign->expiry_date}})</p></li>
					    @endforeach

					</ul>

					<p></p>
					

					<!-- ./ form actions -->

				</div>
			</div>
		</div>
		<!-- ./ General tab -->
	</div>
	<!-- ./ tabs content -->
	</div>


@stop

{{-- Scripts --}}
@section('scripts')

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
	          url: "{{URL::to('admin/campaign_order/setOrder')}}",
	          data : { order : order},
	          dataType:"text",
	          async: false
	          }).responseText;
      	if(result == "1"){
      		window.location.reload();
      	}
      	else{
      		alert("ploblem exists reordering campaigns, please try again")
      	}
	      		// enable textbox
    }
  });
  </script>

@stop

