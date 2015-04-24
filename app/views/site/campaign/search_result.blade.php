@foreach ($campaigns as $campaign)
<div class="row">
	<div class="col-md-8">


		<!-- Post Content -->
		<div class="row">
			<div class="col-md-6">
		@if(Auth::check() || Session::get('socialUser.isLogin')) 
				
				@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
					<?php
					$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/',true);
					?>
				
						<div>																																	
						<a href="{{$campaign->url()}}"  class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>		
						</div>
				@else
						@if($campaign->hotel_logo!="")			
								<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
						@else
								<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
						@endif
				@endif
					
				@if(!User::checkIfUserSeeCampaign($campaignUserRead,$campaign->id))
					<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
				@endif	
		@else
			@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
				<?php
				$banner = Picture::directoryToArray(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/',true);
				?>
			
					<div>																																	
					<a href="{{$campaign->url()}}"  class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" align="middle" /></a>		
					</div>
			@else
					@if($campaign->hotel_logo!="")			
							<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
					@else
							<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
					@endif
			@endif
		@endif	
			</div>
			<div class="col-md-6">
				
				<h4><strong><a href="{{{ $campaign->url() }}}">{{ String::title($campaign->name) }}</a></strong></h4>
				
				<p>
					{{ String::tidy(Str::limit($campaign->description, 200)) }}
				</p>
				<br/>
				<?php $startDate =  new DateTime($campaign->start_date); ?>
				<?php $endDate =  new DateTime($campaign->expiry_date); ?>
				@if($startDate->format('Y') == $endDate->format('Y'))
					<p>Valid {{{ $startDate->format('d M') }}} - {{{ $endDate->format('d M Y') }}}</p>
				@else
					<p>Valid {{{ $startDate->format('d M Y') }}} - {{{ $endDate->format('d M Y') }}}</p>
				@endif
				
				<a href="{{{ $campaign->url() }}}"  style="color:#0D8FA9;">more detail</a>
				|
				<a href="{{{ Post::find($campaign->post_id)->url() }}}"  style="color:#0D8FA9;">review</a>
				|
				<a href="{{{ $campaign->url() }}}"  style="color:#0D8FA9;">get voucher</a>
				
			</div>
		</div>
		<!-- ./ post content -->

	
	</div>
</div>

<hr />
@endforeach
