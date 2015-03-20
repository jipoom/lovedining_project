@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@foreach ($campaigns as $campaign)
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $campaign->url() }}}">{{ String::title($campaign->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-6">
				@if(Auth::check()) 
				
				@if($campaign->hotel_logo!="")			
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>
				@else
					<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				@endif
					
				@if(False)
					<div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div>		
				@endif	
		@else
			<a href="{{{ $campaign->url() }}}" class="thumbnail"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt=""></a>		
		@endif	
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($campaign->description, 200)) }}
				</p>
				<strong><a href="{{{ $campaign->url() }}}"  style="color:#0D8FA9;">More info</a></strong>
				
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $campaign->start_date }}}
					| <span class="glyphicon glyphicon-comment"></span> {{5}} {{ \Illuminate\Support\Pluralizer::plural('Comment', 5) }}
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach



@stop
