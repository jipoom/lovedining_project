@extends('site.layouts.default')

@section('sort')

{{-- Content --}}
@section('content')
<div class="col-md-8">
	<h3> @if($mode == "date")
	เรียงลำดับตาม  Recently published
	@elseif($mode == "reviewName")
	เรียงลำดับตามชื่อรีวิว
	@elseif($mode == "restaurantName")
	เรียงลำดับตามชื่อร้านอาหาร
	@elseif($mode == "popularity")
	เรียงลำดับตามความนิยม
	@endif </h3>
</div>
<!-- .Ads -->
<div class="ads-right pull-right">
	<div class="col-md-12">
		<a href="" class="thumbnail"><img src="http://placehold.it/260x800" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->
<!-- Sorting Menu goes here -->
{{ $posts->links() }}
<div class="col-md-3 pull-right">

	<form class ="form-dropdown">
		Sort by:
		<select name="sort" id ="mode" onchange="showReviews(this.value)">
			@if($mode == "date")
			<option value="date" selected>Recently published</option>
			@else
			<option value="date">Recently published</option>
			@endif
			@if($mode == "reviewName")
			<option value="reviewName" selected>Review Name</option>
			@else
			<option value="reviewName">Review Name</option>
			@endif
			@if($mode == "restaurantName")
			<option value="restaurantName" selected>Restaurant Name</option>
			@else
			<option value="restaurantName">Restaurant Name</option>
			@endif
			@if($mode == "popularity")
			<option value="popularity" selected>Popularity</option>
			@else
			<option value="popularity">Popularity</option>
			@endif
		</select>
	</form>

</div>
<?php for($i=0;$i<count($posts);$i+=2)
{
?>
@if($yetToPrint)

<input type ="hidden" id ="category" value= {{$posts[$i]->
category_id}}></input>
<?php $yetToPrint = false; ?>
@endif

<div class="col-md-10">

	<div class="col-md-6">

		<!-- Post Title -->
		<div class="col-md-12">
			<h4><strong><a href="{{{ $posts[$i]->url() }}}">{{ String::title($posts[$i]->title) }}</a></strong></h4>
		</div>

		<!-- ./ post title -->

		<!-- Post Content -->

		<div class="col-md-6">
			@if($posts[$i]->profile_picture_name!="")
			<a href="{{{ $posts[$i]->url() }}}" class="thumbnail"><img src="{{$posts[$i]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $posts[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($posts[$i]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($posts[$i]->district); }}, {{ String::tidy($posts[$i]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($posts[$i]->tel); }}
			</p>
		</div>

		<!-- ./ post content -->

		<!-- Post Footer -->

		<div class="col-md-12">
			<p></p>
			<p>

				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $posts[$i]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $posts[$i]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span><a href="{{{ $posts[$i]->url() }}}#comments">{{$posts[$i]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $posts[$i]->comments()->count()) }}</a>
			</p>
		</div>

		<!-- ./ post footer -->
	</div>

	<!-- new Column -->
	@if(($i+1)<count($posts))
	<div class="col-md-6">

		<!-- Post Title -->
	
		<div class="col-md-12">
			<h4><strong><a href="{{{ $posts[$i+1]->url() }}}">{{ String::title($posts[$i+1]->
			title) }}</a></strong></h4>
		</div>
	
		<!-- ./ post title -->
	
		<!-- Post Content -->
		<div class="col-md-6">
			@if($posts[$i+1]->profile_picture_name!="")
			<a href="{{{ $posts[$i+1]->url() }}}" class="thumbnail"><img src="{{$posts[$i+1]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $posts[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($posts[$i+1]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($posts[$i+1]->district); }}, {{ String::tidy($posts[$i+1]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($posts[$i+1]->tel); }}
			</p>
		</div>
	
		<!-- ./ post content -->
	
		<!-- Post Footer -->
	
		<div class="col-md-12">
			<p></p>
			<p>
	
				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $posts[$i+1]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $posts[$i+1]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $posts[$i+1]->url() }}}#comments">{{$posts[$i+1]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $posts[$i+1]->comments()->count()) }}</a>
			</p>
		</div>
	
		<!-- ./ post footer -->
	</div>

@endif
<!-- /new Column -->
</div>

<?php
}
?>

@stop
@section('scripts')
<!-- Sort Review -->
<script>
	function showReviews(mode) {
		var categoryId = $("#category").val();
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
				document.getElementById("mode").value = mode;
			}
		}
		xmlhttp.open("GET", categoryId + "/" + mode, true);
		xmlhttp.send();

	}
</script>
<!-- End Sort Review -->

@stop
