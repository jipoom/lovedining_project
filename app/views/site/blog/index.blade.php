@extends('site.layouts.default')
	<title> @section('title')
			@if(isset($categoryId) && $categoryId != "undefined")
				LoveDining - {{Category::find($categoryId)->category_name}}
			@else
				LoveDining - Search Result
			@endif	
			@show </title>
@section('sort')

{{-- Content --}}
@section('content')
<div class="col-md-8"  style="position:absolute;">
	<!--<h3> 
	@if(Session::get('Lang') == 'TH')
		@if($mode == "date")
		เรียงลำดับตามวันที่ล่าสุด
		@elseif($mode == "reviewName")
		เรียงลำดับตามชื่อรีวิว
		@elseif($mode == "restaurantName")
		เรียงลำดับตามชื่อร้านอาหาร
		@elseif($mode == "popularity")
		เรียงลำดับตามความนิยม
		@endif 
	@elseif(Session::get('Lang') == 'EN')
		@if($mode == "date")
		Sort by recently published
		@elseif($mode == "reviewName")
		Sort by review name
		@elseif($mode == "restaurantName")
		Sort by restaurant name
		@elseif($mode == "popularity")
		Sort by popularity
		@endif 
	@elseif(Session::get('Lang') == 'CN')
		@if($mode == "date")
		Sort by recently published
		@elseif($mode == "reviewName")
		Sort by review name
		@elseif($mode == "restaurantName")
		Sort by restaurant name
		@elseif($mode == "popularity")
		Sort by popularity
		@endif 
	@endif-->
		</h3>
</div>


	
<!-- .Ads -->
<div class="ads-right-home pull-right">	
	<!-- Searchbox -->
	<div id="tfnewsearch">
		
		<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder = "{{(Session::get('Lang') == 'TH') ? 'ค้นหา ชื่อร้าน ชื่อรีวิว หรือสถานที่': 'search'}} "size="28" maxlength="120" onkeypress="return runScript(event)">
		<input type="submit" value="Go" id = "go" class="tfbutton" onclick ="searchActionDefault(this.value)"> 
		
		
		<div class="tfclear"></div>
	</div>
	<div class="col-md-12">
		<a href="" class="ads"><img src="{{$adsSide}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->
<!-- Sorting Menu goes here 

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

</div> -->
<?php for($i=0;$i<count($posts);$i+=2)
{
?>
@if($yetToPrint)

<input type ="hidden" id ="category" value= {{$categoryId}}></input>

<?php $yetToPrint = false; ?>
@endif

<div class="col-md-highlight" style="padding: 0; margin: 0;"="col-md-9">

	<div class="col-md-6">
		<!-- Post Title -->
		<!--<div class="col-md-12">
				<h4><strong><a href="{{{ $posts[$i]->url() }}}">{{ String::title($posts[$i]->title) }}<p>{{String::title($posts[$i]->title_2)}}</p></a></strong></h4>
		</div>-->
		<!-- ./ post title -->

		<!-- Post Content -->

		<div class="col-md-12">
			
		@if(Auth::check()) 
				
			@if($posts[$i]->profile_picture_name!="")			
				<a href="{{{ $posts[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$posts[$i]->album_name.'/'.$posts[$i]->profile_picture_name}}" alt=""></a>
			@else
				<a href="{{{ $posts[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
				
			@if(!User::checkIfUserRead($postUserRead,$posts[$i]->id))
				<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
			@endif	
		@else
			<a href="{{{ $posts[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$posts[$i]->album_name.'/'.$posts[$i]->profile_picture_name}}" alt=""></a>		
		@endif	
		</div>
		<div class="col-md-12" style="font-size: 13px">
			<!-- Post Title -->

			<h4><strong><a href="{{{ $posts[$i]->url() }}}">{{ String::title($posts[$i]->title) }}<p>{{String::title($posts[$i]->title_2)}}</p></a></strong></h4>
	
		<!-- ./ post title -->
			<p>
				{{ String::tidy($posts[$i]->restaurant_name) }}
			</p>
			<p>
				@if(Session::get('Lang') == 'TH')
					<!-- {{ String::tidy($posts[$i]->amphur); }}, {{ String::tidy($posts[$i]->province->province_name); }} -->
					{{Str::limit(preg_replace('%(([<][/]*[ก-๙a-zA-Z0-9 =/_{}:\".-]*[>]*)+)|(&nbsp;)%', '', $posts[$i]->content()), 150, '...')}}
				@else
					{{ String::tidy($posts[$i]->amphur); }}, {{ String::tidy($posts[$i]->province->province_name_en); }}
				@endif
				
			</p>
			<!--<p>
				Tel:
				{{ String::tidy($posts[$i]->tel); }}
			</p>-->
		</div>

		<!-- ./ post content -->

		<!-- Post Footer -->

		<div class="col-md-12">
			<p></p>
			<p>

				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $posts[$i]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $posts[$i]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $posts[$i]->url() }}}#comments">{{$posts[$i]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $posts[$i]->comments()->count()) }}</a>
			<hr />
			</p>
		</div>

		<!-- ./ post footer -->
	</div>

	<!-- new Column -->
	@if(($i+1)<count($posts))
	<div class="col-md-6">
		
		<!-- Post Title -->
		<!--<div class="col-md-12">
			<h4><strong><a href="{{{ $posts[$i+1]->url() }}}">{{ String::title($posts[$i+1]->
			title) }}<p>{{String::title($posts[$i+1]->title_2)}}</p></a></strong></h4>
			</div> -->
		<!-- ./ post title -->
	
		<!-- Post Content -->
		<div class="col-md-12">
			@if(Auth::check()) 
				@if($posts[$i+1]->profile_picture_name!="")			
					<a href="{{{ $posts[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$posts[$i+1]->album_name.'/'.$posts[$i+1]->profile_picture_name}}" alt=""></a>
				@else
					<a href="{{{ $posts[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				@endif
					
				@if(!User::checkIfUserRead($postUserRead,$posts[$i+1]->id))
					<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
				@endif
			@else
				<a href="{{{ $posts[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$posts[$i+1]->album_name.'/'.$posts[$i+1]->profile_picture_name}}" alt=""></a>			
			@endif	
		</div>
		<div class="col-md-12" style="font-size: 13px">
			<h4><strong><a href="{{{ $posts[$i+1]->url() }}}">{{ String::title($posts[$i+1]->title) }}<p>{{String::title($posts[$i+1]->title_2)}}</p></a></strong></h4>
	
			<p>
				{{ String::tidy($posts[$i+1]->restaurant_name) }}
			</p>
			<p>
				@if(Session::get('Lang') == 'TH')
					<!--{{ String::tidy($posts[$i+1]->amphur); }}, {{ String::tidy($posts[$i+1]->province->province_name); }} -->
					{{Str::limit(preg_replace('%(([<][/]*[ก-๙a-zA-Z0-9 =/_{}:\".-]*[>]*)+)|(&nbsp;)%', '', $posts[$i]->content()), 150, '...')}}
				@else
					{{ String::tidy($posts[$i+1]->amphur); }}, {{ String::tidy($posts[$i+1]->province->province_name_en); }}
				@endif
			</p>
			<!--<p>
				Tel:
				{{ String::tidy($posts[$i+1]->tel); }}
			</p>-->
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
			<hr />
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
<div class="col-md-8 pull-right">
	{{ $posts->links() }}
</div>
<!-- . Ads -->
<div class="ads-foot">
	<div class="col-md-12">
		<a href="" class="ads"><img src="{{$adsFoot}}" alt=""></a>
	</div>
</div>
<!-- ./ Ads -->

@stop

@section('scripts')



@stop
