@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($post->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
@parent

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
@parent

@stop

{{-- Content --}}
@section('content')
<h3>{{ $post->title }}</h3>
<p>ร้านอาหาร: {{ $post->restaurant_name }}</p>
<p>โทร: {{ $post->tel }}</p>
<p>ที่อยู่:
{{ String::tidy($post->street_addr) }}&nbsp
แขวง{{ String::tidy($post->subdistrict) }},	&nbsp
เขต{{ String::tidy($post->district) }},&nbsp
จังหวัด{{ String::tidy($post->province) }}	&nbsp
{{ String::tidy($post->zip) }}	&nbsp</p>

<input type="hidden" id="province" value= {{String::tidy($post->province) }}/>

   <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA1XbMiDxx_BTCY2_FkPh06RRaGTYH6UMl8mADNa0YKuWNNa8VNxQEerTAUcfk
yrr6OwBovxn7TDAH5Q"></script>
        <script type="text/javascript">
        var map;
        function initialize() {
          map = new GMap2(document.getElementById("map_canvas"));
          map.setCenter(new GLatLng(15.563999, 101.999066), 15);
          
          var mapTypeControl = new GMapTypeControl();
          var topRight = new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(10,10));
          var bottomRight = new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(10,10));
                map.addControl(mapTypeControl, topRight);
                GEvent.addListener(map, "dblclick", function() {
                  map.removeControl(mapTypeControl);
                  map.addControl(new GMapTypeControl(), bottomRight);
                });
                map.addControl(new GSmallMapControl());
                searchPlace();
        }
        function showAddress() {
			if (geocoder) {
			geocoder.getLatLng(
			{{String::tidy($post->province) }},
			function(point) {
			if (!point) {
			alert("ไม่เจอสถานที่ ที่ต้องการค้นหา");
			} else {
			map.setCenter(point, 15);
			var marker = new GMarker(point);
			map.addOverlay(marker);
			marker.openInfoWindowHtml(address);}
			}
			);
		}
	}
       
        </script>
        <body onload="initialize()" onunload="GUnload()">
        <div id="map_canvas" style="width: 40%; height: 300px; border: 1px solid black;"></div>
        <br/>
  </body>

<br><h4><label>Review</h4>
<p>{{ $post->content() }}</p>


<div>
	<span class="badge badge-info">Posted {{{ $post->date() }}}</span>
</div>
<hr />
<p></p>


<a id="comments"></a>
<h4>{{{ $comments->count() }}} Comments</h4>

@if ($comments->count())
@foreach ($comments as $comment)
<div class="row">
	<div class="col-md-1">
		<img class="thumbnail" src="http://placehold.it/60x60" alt="">
	</div>
	<div class="col-md-11">
		<div class="row">
			<div class="col-md-11">
				<span class="muted">{{{ $comment->author->username }}}</span>
				&bull;
				{{{ $comment->date() }}}
			</div>

			<div class="col-md-11">
				<hr />
			</div>

			<div class="col-md-11">
				{{{ $comment->content() }}}
			</div>
		</div>
	</div>
</div>
<hr />
@endforeach
@else
<hr />
@endif

@if ( ! Auth::check())
You need to be logged in to add comments.<br /><br />
Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
@elseif ( ! $canComment )
You don't have the correct permissions to add comments.
@else

@if($errors->has())
<div class="alert alert-danger alert-block">
<ul>
@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<h4>Add a Comment</h4>
<form  method="post" action="{{{ URL::to($post->id) }}}">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

	<textarea class="col-md-12 input-block-level" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>

	<div class="form-group">
		<div class="col-md-12">
			<input type="submit" class="btn btn-default" id="submit" value="Submit" />
		</div>
	</div>
</form>
@endif
@stop
