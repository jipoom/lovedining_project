<h3>
			@if(isset($mode))
				@if($mode == "recent")
				แสดงตามรีวิวล่าสุด
				@elseif($mode == "random")
				แสดงแบบสุ่ม
				@elseif($mode == "popular")
				แสดงตามความนิยม
				@endif
			@endif
			</h3>
<?php for($i=0;$i<count($highlight);$i+=2)
{
?>
<input type="hidden" name="newMode" id = "newMode" value="{{isset($mode) ? $mode : null}}" />
<div class="col-md-10">

	<div class="col-md-6">

		

		<!-- Post Content -->

		<div class="col-md-6">	
			<strong><a href="{{{ $highlight[$i]->url() }}}">{{ String::title($highlight[$i]->title) }}</a></strong>		
			<?php $hightlightPics = Picture::directoryToArray(Config::get('app.image_path').'/'.$highlight[$i]->album_name,true); ?>
			@if(count($hightlightPics) > 1)
			<ul class="bxslider_hightlight">
				@foreach($hightlightPics as $hightlightPic)
				<li>
					<a href="{{{ $highlight[$i]->url() }}}" class = "thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$hightlightPic}}" align="middle"/></a>		
				</li>
				@endforeach
		
			</ul>
			@else
				@if($highlight[$i]->profile_picture_name!="")
				<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$highlight[$i]->profile_picture_name}}" alt=""></a>
				@else
				<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				@endif
			@endif
			
			
			
		<p></p>
		</div>
		

		<!-- ./ post content -->
		
	</div>

	<!-- new Column -->
	@if(($i+1)<count($highlight))
	<div class="col-md-6">

		
	
		<!-- Post Content -->
		<div class="col-md-6">
			<strong><a href="{{{ $highlight[$i+1]->url() }}}">{{ String::title($highlight[$i+1]->
			title) }}</a></strong>
			<?php $hightlightPics = Picture::directoryToArray(Config::get('app.image_path').'/'.$highlight[$i+1]->album_name,true); ?>
			@if(count($hightlightPics)>1)
			<ul class="bxslider_hightlight">
				@foreach($hightlightPics as $hightlightPic)
				<li>
					<a href="{{{ $highlight[$i]->url() }}}"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$hightlightPic}}" align="middle"/></a>		
				</li>
				@endforeach
		
			</ul>
			@else
				@if($highlight[$i+1]->profile_picture_name!="")
				<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$highlight[$i+1]->profile_picture_name}}" alt=""></a>
				@else
				<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				@endif
			@endif
			
		</div>
		
	
		<!-- ./ post content -->
	
	</div>

@endif
<!-- /new Column -->
</div>

<?php
}
?>
