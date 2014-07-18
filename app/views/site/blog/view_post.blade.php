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
<h3 style="color: #1AC4BF">{{ $post->title }}</h3>
<div>
	<span class="badge badge-info pull-right">Posted {{{ $post->date() }}}</span>
</div>
<br>
<p>{{ $post->content() }}</p>
<div class="fb-like" data-href="{{Request::url()}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>


<hr />
<p></p>

<h4>ร้านอาหาร: {{ $post->restaurant_name }}</h4>
<h5>โทร: {{ $post->tel }}</h5>
<h5>ที่อยู่:
@if($post->street_addr)
	{{$post->street_addr}}
@endif
&nbsp
@if($post->soi)
	ซอย{{$post->soi}}
@endif
&nbsp
@if($post->road)
	ถนน{{$post->road}}
@endif
&nbsp
@if($post->subdistrict)
	แขวง{{$post->subdistrict}}
@endif
&nbsp
@if($post->district)
	เขต{{$post->district}}
@endif	
&nbsp
@if($post->province)
	{{$post->province}}
@endif	
&nbsp
@if($post->zip)
	{{$post->zip}}
@endif	
</h5>
<input type="hidden" id="province" value= {{String::tidy($post->province) }}/>


   <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
       <script>
	var geocoder;
	var map;
	function initialize() {
	  geocoder = new google.maps.Geocoder();
	  var latlng = new google.maps.LatLng(13.7500, 100.4833);
	  var mapOptions = {
	    zoom: 16,
	    center: latlng
	  }
	 
	  map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
	}
	function codeAddress(location) {
	 // var address = document.getElementById('address').value;
	  //var address = 'Arlington, VA';
	  var address = location;
	  geocoder.geocode( { 'address': address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      map.setCenter(results[0].geometry.location);
	      var marker = new google.maps.Marker({
	          map: map,
	          position: results[0].geometry.location
	      });
	    } else {
	      alert('Geocode was not successful for the following reason: ' + status);
	    }
	  });
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>

<body onload="codeAddress({{'\''.$address.'\''}})">
<div id="googleMap" style="width:400px;height:280px;"></div>
<p></p>
{{ link_to(URL::to($post->id.'/album'), 'Gallery', $attributes = array('class' => 'btn btn-default'), $secure = null);}}
<hr />
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
				{{ $comment->content() }}
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


<form  method="post" action="{{{ URL::to($post->id) }}}">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

	<textarea class="col-md-12 input-block-level" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>

	<div class="form-group">
		<div class="col-md-12">
			<input type="submit" class="btn btn-default" id="submit" value="Add a Comment" />
		</div>
	</div>
</form>
@endif


@stop

@section('scripts')
		<script type="text/javascript">
			$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		</script>	
@stop
