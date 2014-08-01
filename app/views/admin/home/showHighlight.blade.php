<h3>
			@if($mode == "recent")
			แสดงตามรีวิวล่าสุด
			@elseif($mode == "random")
			แสดงแบบสุ่ม
			@elseif($mode == "popular")
			แสดงตามความนิยม
			@endif
			</h3>
<?php for($i=0;$i<count($highlight);$i+=2)
{
?>
<input type="hidden" name="newMode" id = "newMode" value="{{$mode}}" />
<div class="col-md-10">

	<div class="col-md-6">

		<!-- Post Title -->
		<div class="col-md-12">
			<h4><strong><a href="{{{ $highlight[$i]->url() }}}">{{ String::title($highlight[$i]->title) }}</a></strong></h4>
		</div>

		<!-- ./ post title -->

		<!-- Post Content -->

		<div class="col-md-6">
			@if($highlight[$i]->profile_picture_name!="")
			<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$highlight[$i]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($highlight[$i]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($highlight[$i]->district); }}, {{ String::tidy($highlight[$i]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($highlight[$i]->tel); }}
			</p>
		</div>

		<!-- ./ post content -->

		<!-- Post Footer -->

		<div class="col-md-12">
			<p></p>
			<p>

				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $highlight[$i]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $highlight[$i]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $highlight[$i]->url() }}}#comments">{{$highlight[$i]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $highlight[$i]->comments()->count()) }}</a>
			</p>
		</div>

		<!-- ./ post footer -->
	</div>

	<!-- new Column -->
	@if(($i+1)<count($highlight))
	<div class="col-md-6">

		<!-- Post Title -->
	
		<div class="col-md-12">
			<h4><strong><a href="{{{ $highlight[$i+1]->url() }}}">{{ String::title($highlight[$i+1]->
			title) }}</a></strong></h4>
		</div>
	
		<!-- ./ post title -->
	
		<!-- Post Content -->
		<div class="col-md-6">
			@if($highlight[$i+1]->profile_picture_name!="")
			<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$highlight[$i+1]->profile_picture_name}}" alt=""></a>
			@else
			<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			@endif
		</div>
		<div class="col-md-6">
			<p>
				{{ String::tidy($highlight[$i+1]->restaurant_name) }}
			</p>
			<p>
				{{ String::tidy($highlight[$i+1]->district); }}, {{ String::tidy($highlight[$i+1]->province); }}
			</p>
			<p>
				Tel:
				{{ String::tidy($highlight[$i+1]->tel); }}
			</p>
		</div>
	
		<!-- ./ post content -->
	
		<!-- Post Footer -->
	
		<div class="col-md-12">
			<p></p>
			<p>
	
				<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $highlight[$i+1]->author->username }}}</span>
				| <span class="glyphicon glyphicon-calendar"></span><!--Sept 16th, 2012-->
				{{{ $highlight[$i+1]->date() }}}
				| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $highlight[$i+1]->url() }}}#comments">{{$highlight[$i+1]->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $highlight[$i+1]->comments()->count()) }}</a>
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