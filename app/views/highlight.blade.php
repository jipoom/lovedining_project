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

		<div class="col-md-6_5 thumbnail" style="padding: 5 5 5 0; margin: 5 0 5 0;">	
		
<div class="non-semantic-protector"> 
   <!-- ribbons and other content in here -->

			<div class="ribbon"><div class="ribbon-stitches-top"></div><div class="ribbon-content">
				<a href="{{{ $highlight[$i]->url() }}}">{{ String::title($highlight[$i]->title) }}</a>
				</div><div class="ribbon-stitches-bottom"></div></div>
	</div>
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
			
			

		
		</div>
		

		<!-- ./ post content -->
		


	<!-- new Column -->
	@if(($i+1)<count($highlight))

		
	
		<!-- Post Content -->
		<div class="col-md-6_5 thumbnail" style="padding: 5 0 5 5; margin: 5 0 5 0;" >
			<div class="non-semantic-protector"> 
   <!-- ribbons and other content in here -->

			<div class="ribbon"><div class="ribbon-stitches-top"></div><div class="ribbon-content">
				<a href="{{{ $highlight[$i+1]->url() }}}">{{ String::title($highlight[$i+1]->title) }}</a>
				</div><div class="ribbon-stitches-bottom"></div></div>
	</div>
			
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

		</div>
		
	
		<!-- ./ post content -->
	


@endif
<!-- /new Column -->
</div>

<?php
}
?>
