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
<?php for($i=0;$i<count($highlight) && $i<6;$i+=3)
{
?>
<input type="hidden" name="newMode" id = "newMode" value="{{isset($mode) ? $mode : null}}" />
<div class="col-md-12" style="padding: 0; margin: 0">

		<!-- Post Content -->

		<div class="col-md-hl" style="left: 0; margin-right: 15px; padding: 0; margin-bottom: 15px;">	
			<!--
			<div class="non-semantic-protector">
				<!-- ribbons and other content in here 
				<div class="ribbon">
					<div class="ribbon-stitches-top"></div>
					<div class="ribbon-content">
						
						<a href="{{{ $highlight[$i]->url() }}}">{{ Str::limit($highlight[$i]->title, 35, "...") }}</a>
					</div><div class="ribbon-stitches-bottom"></div>
				</div>
			</div>
			-->
			@if(!(count(glob(Config::get('app.image_path').'/'.$highlight[$i]->album_name)) === 0))				
				@if($highlight[$i]->profile_picture_name!="")
					<a href="{{{ $highlight[$i]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i]->album_name.'/'.$highlight[$i]->profile_picture_name}}" class ="hl"></a>
				@else
					<a href="{{{ $highlight[$i]->url() }}}" class=""><img src="http://placehold.it/260x180" alt=""></a>
				@endif
				
				
			@endif
			<a href="{{{ $highlight[$i]->url() }}}">{{ $highlight[$i]->title }}<p>{{$highlight[$i]->title_2}}</p></a>
		</div>
		<!-- ./ post content -->

	<!-- new Column -->
	@if(($i+1)<count($highlight))
		<!-- Post Content -->
		<div class="col-md-hl" style="margin-right: 15px; padding: 0; margin-bottom: 15px;" >
			
	
			@if(!(count(glob(Config::get('app.image_path').'/'.$highlight[$i+1]->album_name)) === 0))
	
				@if($highlight[$i+1]->profile_picture_name!="")
					<a href="{{{ $highlight[$i+1]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+1]->album_name.'/'.$highlight[$i+1]->profile_picture_name}}" class ="hl"/></a>
				@else
					<a href="{{{ $highlight[$i+1]->url() }}}" class=""><img src="http://placehold.it/260x180" alt=""></a>
				@endif
				
			@endif
			<a href="{{{ $highlight[$i+1]->url() }}}">{{ $highlight[$i+1]->title }}<p>{{$highlight[$i+1]->title_2}}</p></a>
			<!--
			<div class="non-semantic-protector">
				
				<div class="ribbon">
					<div class="ribbon-stitches-top"></div>
					<div class="ribbon-content">
						<a href="{{{ $highlight[$i+1]->url() }}}">{{ Str::limit($highlight[$i+1]->title, 35, "...") }}</a>
					</div><div class="ribbon-stitches-bottom"></div>
				</div>
			</div>
			-->
		</div>
		<!-- ./ post content -->
		
		<!-- new Column -->
		@if(($i+2)<count($highlight))
			<!-- Post Content -->
			<div class="col-md-hl" style="margin-right: 15px; padding: 0; margin-bottom: 15px;" >
				
		
				@if(!(count(glob(Config::get('app.image_path').'/'.$highlight[$i+2]->album_name)) === 0))
		
					@if($highlight[$i+2]->profile_picture_name!="")
						<a href="{{{ $highlight[$i+2]->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$highlight[$i+2]->album_name.'/'.$highlight[$i+2]->profile_picture_name}}" class ="hl"/></a>
					@else
						<a href="{{{ $highlight[$i+2]->url() }}}" class=""><img src="http://placehold.it/260x180" alt=""></a>
					@endif
					
				@endif
				<a href="{{{ $highlight[$i+2]->url() }}}">{{ $highlight[$i+2]->title }}<p>{{$highlight[$i+2]->title_2}}</p></a>
				<!--
				<div class="non-semantic-protector">
					
					<div class="ribbon">
						<div class="ribbon-stitches-top"></div>
						<div class="ribbon-content">
							<a href="{{{ $highlight[$i+1]->url() }}}">{{ Str::limit($highlight[$i+1]->title, 35, "...") }}</a>
						</div><div class="ribbon-stitches-bottom"></div>
					</div>
				</div>
				-->
			</div>
			<!-- ./ post content -->
	
		@endif
		<!-- /new Column -->
	
	@endif
	<!-- /new Column -->
	
	
</div>
<?php
}
?>
