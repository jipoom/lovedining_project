@extends('site.layouts.default')

@section('sort')


{{-- Content --}}
@section('content')
<div class="col-md-8">	
	<h3>
	@if($mode == "date")
		เรียงลำดับตาม  Recently published
	@elseif($mode == "reviewName")
		เรียงลำดับตามชื่อรีวิว
	@elseif($mode == "restaurantName")
		เรียงลำดับตามชื่อร้านอาหาร
	@elseif($mode == "popularity")
		เรียงลำดับตามความนิยม
	@endif
	</h3>
</div>


@foreach ($posts as $post)

@if($yetToPrint)
		<!-- Sorting Menu goes here -->
		<div class="col-lg-3 pull-right">
		 	<form>
		 	Sort by:<select name="sort" id ="mode" onchange="showReviews(this.value)">
			  <option value="date">Recently published</option>
			  <option value="reviewName">Review Name</option>
			  <option value="restaurantName">Restaurant Name</option>
			  <option value="popularity">Popularity</option>
			</select>	
			</form>
		</div>
		<input type ="hidden" id ="category" value= {{$post->category_id}}></input>
		<?php $yetToPrint = false; ?>
@endif

<div class="row">
	<div class="col-md-12">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $post->url() }}}">{{ String::title($post->title) }}</a></strong></h4>
			</div>			
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ $post->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
				<p><a class="btn btn-mini btn-default" href="{{{ $post->url() }}}">Read more</a></p>	
			</div>
			
		</div>
		<!-- ./ post content -->

		<!-- Post address -->
		<div class="row">
			<div class="col-md-8">
				จังหวัด{{ String::tidy($post->province) }}	&nbsp
			</div>
		</div>
		<!-- ./ post address -->
		
		
		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $post->url() }}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>
<hr />
@endforeach
{{ $posts->links() }}

<script>
function showReviews(mode) {
  var categoryId = $("#category").val();
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
      document.getElementById("reload").innerHTML=xmlhttp.responseText;
      document.getElementById("mode").value = mode;
    }
  }
  xmlhttp.open("GET",categoryId+"/"+mode,true);
  xmlhttp.send();

}
</script>

@stop
