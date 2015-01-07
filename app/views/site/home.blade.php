@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.introduction') }}} ::
@parent
@stop

@section('styles')
<link href="{{asset('bootstrap/css/image.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/jquery.bxslider.css')}}" rel="stylesheet" />
<style>
	ul.bxslider {
		margin: 0;
		padding: 0;
	}
	
	.bx-wrapper img {
    margin: 0 auto;
	}
	img.resize{
    width:1100px; /* you can use % */
    height: auto;
	}	
	img.hl{
    width:300px; /* you can use % */
    height: auto;
	}

    
}
</style>
@stop

{{-- Content --}}
@section('content')


<div class="col-md-12">
<!-- Welcome --> <!--
<h4 style="color: #282828">
{{{ Lang::get('site.introduction') }}}
</h4>
<!-- Welcome -->
	
	<ul class="bxslider" style="margin-bottom: 0px; padding-bottom: 0px;">
		@foreach($home as $post)
			@if(!(count(glob(Config::get('app.image_path').'/'.$post->album_name.'/banner/')) === 0))
				<?php
				$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$post->album_name.'/banner/',true);
				?>
			
				<li>
					<div>																																	
					<a href="{{$post->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$post->album_name.'/banner/'.$banner[0]}}" title="{{$post->title}}, {{(Session::get('Lang') == 'TH') ? $post->province->province_name: $post->province->province_name_en}}" align="middle" /></a>		
					</div>
				</li>
			@endif
		@endforeach

	</ul>
<br />
<div class="col-md-highlight" style="padding: 0; margin: 0;">

@include('highlight')
</div>

<!-- Searchbox -->
<div id="tfnewsearch">
	
	<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder = "{{(Session::get('Lang') == 'TH') ? 'ค้นหา ชื่อร้าน ชื่อรีวิว หรือสถานที่': 'search'}} "size="25" maxlength="120" onkeypress="return runScript(event)">
	<input type="submit" value="Go" id = "go" class="tfbutton" onclick ="searchAction(this.value)"> 
	
	
	<div class="tfclear"></div>
</div>
<!-- .Ads -->
<div class="ads-right-home checkscreen" >
	<div class="col-md-12 ads">
		<a href="" ><img src="{{$adsSide}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->

<!-- . Ads -->
<div class="ads-foot">
	<div class="col-md-9">
		<a href="" class="ads"><img src="{{$adsFoot}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->

</div>

@stop

@section('scripts')
<!-- .crop -->
<script src="{{asset('assets/js/jquery.resizecrop-1.0.3.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.highlight').resizecrop({
	      width:'400',
	      height:'250',
	      vertical : 'center',
		  horizontal : 'center'

	    });  
	    $('.single_highlight').resizecrop({
	      width:383,
	      height:300

	    });  
		$('.bxslider').bxSlider({
			mode : 'fade',
			infiniteLoop : true,
			auto : true,
			autoStart : true,
			autoDirection : 'next',
			autoHover : true,
			pause : 3000,
			autoControls : false,
			pager : false,
			pagerType : 'full',
			controls : false,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 1600,
			adaptiveHeight: true
		});
		
		$('.bxslider_highlight').bxSlider({
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
			controls : false,
			captions : true,
			speed : 500,
			randomStart : true,
			responsive : true,
			slideWidth : 950,
			adaptiveHeight: true,
			moveSlides: 1
		});
		
		

		
	}); 
</script>
<!-- Search Review -->
			<script>
				/*function searchAction(mode) {
					var word = $("#keywords_home").val();
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
							document.getElementById("reload").innerHTML = xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET", "{{{ URL::to('search') }}}/" + word, true);
					xmlhttp.send();

				}

				function runScript(e) {
					if (e.keyCode == 13) {
						if($("#keywords_home").val()!=null)
							searchAction("go");
						else if($("#subscribe").val()!=null)
							subscribeAction("go");
					}
				}*/
			</script>
			<!-- End Search Review -->
@stop
