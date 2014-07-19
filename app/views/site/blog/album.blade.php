@extends('site.layouts.default')
@section('styles')
		<link rel="stylesheet" href="{{asset('assets/css/preettyphoto/prettyPhoto.css')}}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<style type="text/css" media="screen">

			
			p { font-size: 1.2em; }
			
			ul li { display: inline; }
			

			

		</style>
@stop
@section('content')
		<h3 style="color: #1AC4BF">{{ link_to(URL::to($post->id), $post->title, $attributes = array(), $secure = null);}}

			<div class="pull-right">
				
				<a href="{{{ URL::previous() }}}" class="btn btn-small"><span class="glyphicon glyphicon-circle-arrow-left"</span> Back</a>
			 	
			</div>
		</h3>
		<!--<div class="galleria">-->
		<div>
			<ul class="gallery clearfix">
			@foreach ($album as $picture)
				
				<li><a href="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" rel="LoveDining[gallery]"><img src="{{URL::to('/images/'.$post->album_name.'/'.$picture)}}" width="20%" height="20%" alt="" /></a></li>
			
			@endforeach		
				</ul>
				
		</div>
	

@stop
@section('scripts')
		<script src="{{asset('assets/js/jquery.prettyPhoto.js')}}" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='LoveDining']").prettyPhoto();
				
				$(".gallery:first a[rel^='LoveDining']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
				$(".gallery:gt(0) a[rel^='LoveDining']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='LoveDining']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='LoveDining']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>       
@stop