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
<div class="col-md-12">

		<!-- Post Content -->

		<div class="col-md-6_5 thumbnail" style="left: 0; margin-right: 20px;">	
			<div class="non-semantic-protector">
				<!-- ribbons and other content in here -->
				<div class="ribbon">
					<div class="ribbon-stitches-top"></div>
					<div class="ribbon-content">
						
						<a href="{{{ $highlight[$i]->url() }}}">{{ Str::limit($highlight[$i]->title, 35, "...") }}</a>
					</div><div class="ribbon-stitches-bottom"></div>
				</div>
			</div>
			@if(!(count(glob(Config::get('app.image_path').'/'.$highlight[$i]->album_name)) === 0))
				<?php $hightlightPics = Picture::directoryToArray(Config::get('app.image_path').'/'.$highlight[$i]->album_name,true); ?>
				@if(count($hightlightPics) > 1)
				<ul class="bxslider_highlight bx-wrapper">
					@foreach($hightlightPics as $hightlightPic)
					<li>
						<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$hightlightPic}}" align="center" class ="highlight"/></a>		
					</li>
					@endforeach
			
				</ul>
				@else
					@if($highlight[$i]->profile_picture_name!="")
					<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$highlight[$i]->profile_picture_name}}"></a>
					@else
					<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
					@endif
				@endif	
			@endif
		</div>
		<!-- ./ post content -->

	<!-- new Column -->
	@if(($i+1)<count($highlight))
		<!-- Post Content -->
		<div class="col-md-6_5 thumbnail" style="right: 0; margin-left: 20px;" >
			<div class="non-semantic-protector">
				<!-- ribbons and other content in here -->
				<div class="ribbon">
					<div class="ribbon-stitches-top"></div>
					<div class="ribbon-content">
						<a href="{{{ $highlight[$i+1]->url() }}}">{{ Str::limit($highlight[$i+1]->title, 35, "...") }}</a>
					</div><div class="ribbon-stitches-bottom"></div>
				</div>
			</div>
	
			@if(!(count(glob(Config::get('app.image_path').'/'.$highlight[$i+1]->album_name)) === 0))
				<?php $hightlightPics = Picture::directoryToArray(Config::get('app.image_path').'/'.$highlight[$i+1]->album_name,true); ?>
				@if(count($hightlightPics)>1)
				<ul class="bxslider_highlight bx-wrapper">
					@foreach($hightlightPics as $hightlightPic)
					<li>
						<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$hightlightPic}}"  align="center" class ="highlight"/></a>		
					</li>
					@endforeach
			
				</ul>
				@else
					@if($highlight[$i+1]->profile_picture_name!="")
					<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$highlight[$i+1]->profile_picture_name}}" /></a>
					@else
					<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
					@endif
				@endif
			@endif
		</div>
		<!-- ./ post content -->
	
@endif
<!-- /new Column -->
</div>
<?php
}
?>
