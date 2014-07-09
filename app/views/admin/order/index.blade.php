@extends('admin.layouts.order')

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
				<button type="button" value = "name" class="btn btn-small btn-info iframe" onclick="changeOrder(this.value)"> เรียงตามตัวอักษร</button>
				<button type="button" value = "numReviews" class="btn btn-small btn-info iframe" onclick="changeOrder(this.value)"> เรียงตามจำนวนรีวิว</button>
				<button type="button" value = "popularity" class="btn btn-small btn-info iframe" onclick="changeOrder(this.value)"> เรียงตามความนิยม</button>
				<!--<a href="{{{ URL::to('admin/order/custom') }}}" class="btn btn-small btn-info iframe"> กำหนดรูปแบบเอง</a>-->
				@if($mode!=null)
					<button type="button" value = "{{$mode}}" class="btn btn-small btn-info iframe" onclick="saveOrder(this.value)"><span class="glyphicon glyphicon-plus-sign"></span> บันทึก</button>
				@else
					<button type="button" value = "name" class="btn btn-small btn-info iframe" onclick="saveOrder(this.value)"><span class="glyphicon glyphicon-plus-sign"></span> บันทึก</button>
				@endif
				
			</div>
		</h3>
	</div>
		<table id="blogs" class="table table-striped table-hover">
		<thead>
			
			<tr>
				<th class="col-md-4">{{{ Lang::get('admin/category/table.title') }}} 
					@if($mode==null) 
						(default) 
					@elseif ($mode=="name") 
						(เรียงลำดับตามชื่อ)
					@elseif ($mode=="numReviews") 
						(เรียงลำดับตามจำนวนรีวิว)
					@elseif ($mode=="popularity") 
						(เรียงลำดับตามความนิยม)
					@endif
					
				</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
			<?php $i = 1;?>
			@foreach ($categories as $category)
				<h5><strong>{{$i++." ".$category->category_name }}</strong></h5>
			@endforeach
	
@stop

{{-- Scripts --}}
@section('scripts')
	<script>
	
	
	
function changeOrder(mode) {
  if (mode=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("showCategory").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","order/"+mode,true);
  xmlhttp.send();

}

function saveOrder(mode) {
  if (mode=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("showCategory").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","order/save/"+mode,true);
  xmlhttp.send();

}
</script>

@stop