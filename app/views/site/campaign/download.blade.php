<?php
require_once (public_path() . '/mpdf60/mpdf.php');
?>
@extends('site.layouts.default')

@section('styles')
<!-- put style here -->
@stop
{{-- Content --}}
@section('content')
<?php ob_start(); ?>
<div style="width: 1000px; height: 448px; border: 1px solid">
<div class="Logo-Pane" style="float: left; width: 180px; height: 448px; background-color: #1b7f9f;">
	<div class="Logo" style="margin-top:15px">
		<!-- <center>Lovedining LOGO</center> -->
		<img src="{{{ Config::get('app.host_name').'/'.'assets/img/logolarge.png' }}}" alt="Logo"  height="180px" class ="logo">
		
		
	</div>
	<div class="Voucher" style="padding-top: 140px;">
		<!-- <center>Voucher</center> -->
		<img src="{{{ Config::get('app.host_name').'/'.'assets/img/EVoucher.png' }}}" width="180px" class ="Voucher">
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 810px; height: 448px;  display: block; background-color: #1b7f9f;">
	<div class="Banner-Pane" style="float: left; width: 610px; background-color: #1b7f9f; height: 190px;">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign ->album_name . '/banner/', true);
			?>
			<div class="banner_reserve">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" alt="Banner" align="middle" width="610px" height="190px"/></center>
			</div>
		@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post-> album_name . '/banner/', true);
			?>
			<div class="banner_main">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" width="90%" alt="Banner" align="middle" /></center>
			</div>
		@endif
		<div class="Owner-Pane" style="float: left; width: 610px; margin-top:3px; border-radius: 5px; margin-right:1%;background-color:white; height: 50px;">
			<div class="customer-detail" style="margin-top:5px;">
			@if($campaign->show_firstname == 1 || $campaign->show_lastname == 1)
				<p style="padding-left: 10px; font-size: 12px; line-height: 10%">
				<strong>Name:</strong> 
				@if($campaign->show_firstname == 1)
					{{$userCampaign->user_firstname}}
				@endif
				@if($campaign->show_lastname == 1)
					{{$userCampaign->user_lastname}}
				</p>
				@endif
			@endif	
			@if($campaign->show_email == 1 || $campaign->show_tel == 1)
				<p style="padding-left: 10px; font-size: 12px; line-height: 10%">
				<strong>Contacts:</strong> 
				@if($campaign->show_email == 1)
					{{$userCampaign->user_tel}}<strong> /</strong> 
				@endif
				@if($campaign->show_tel == 1)
					{{$userCampaign->user_email}}	
				@endif
				</p>
			@endif
			</div>
		</div>
		<div class="Main-Bottom" style="float: left; width: 610px; margin-top:3px; background-color:#1b7f9f; height:190px; ">
			<div class="Privilege-detail" style="float: left; background-color: white; width: 303px; height: 194px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 15px;line-height: 10%;font-size: 12px"><strong>Privilege Detail: </strong></p>
				<div style="font-size: 9px; padding-top: -10px;; padding-left: 15px; line-height: 140%; padding-bottom: -80px">{{ String::tidy($campaign->description) }}</div>
			</div>
			<div class="Term-Cond" style="float: left;  margin-left:4px; background-color: white; width: 303px; height: 194px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 15px;line-height: 10%;font-size: 12px"><strong>Term & Conditions</strong></p>
				<div style="font-size: 9px; padding-top: -10px;; padding-left: 15px; line-height: 140%; padding-bottom: -80px">
					{{$campaign->condition}}
				</div>

			</div>
		</div>
	</div>
	<div class="Detail-Pane" style="float: left; width: 196px; margin-left: 4px; background-color: white; height: 448px; ">
		@if($campaign->hotel_logo!="")
		<p style="text-align: center">
		<img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="63px">
		</p>
		@else
		<p>
		<img src="http://placehold.it/260x180" alt="" height="63px">
		</p>
		@endif
		<div class="restaurant-name" style="margin-top: 30px; height: 75px;">
		<p style="padding-left: 10px; font-size: 12px; line-height: 10%"><strong>Restaurant Name: </strong></p>
		<p style="padding-left: 15px; font-size: 12px; line-height: 100%;">{{String::tidy($campaign->post->restaurant_name)}}</p>
		</div >
		<div class="restaurant-address" style="height: 90px; word-wrap: break-word;">
			<p style="padding-left: 10px; font-size: 12px; line-height: 10%;"><strong>Address:</strong></p> 
			<p style="padding-left: 15px; font-size: 12px; line-height: 100%;">
			{{$campaign->post->address2}}
		
			{{$campaign->post->address1}}

			@if($campaign->post->tumbol)
				แขวง{{$campaign->post->tumbol}}
			@endif

			@if($campaign->post->amphur)
				{{$campaign->post->amphur}}
			@endif

			{{$campaign->post->province->province_name}}
			
			{{$campaign->post->zip}}
			
		</p></div>
		<p style="padding-left: 10px; line-height: 10%; font-size: 12px"><strong>Validity:</strong></p>
		<?php $startDate =  new DateTime($campaign->start_date); ?>
		<?php $endDate =  new DateTime($campaign->expiry_date); ?>
		@if($startDate->format('Y') == $endDate->format('Y'))
			<p style="padding-left: 15px;; font-size: 12px">{{{ $startDate->format('d M') }}} - {{{ $endDate->format('d M Y') }}}</p>
		@else
			<p style="padding-left: 15px;font-size: 12px">{{{ $startDate->format('d M Y') }}} - {{{ $endDate->format('d M Y') }}}</p>
		@endif
		<div class="code" style="margin-top:50px;">
			<p style="padding-left: 10px; line-height: 10%;font-size: 12px"><strong>Code:</strong></p>
			<p style="padding-left: 15px;line-height: 10%;font-size: 12px">{{$userCampaign->campaign_code}}</p>
		</div>
		
	</div>
</div>
</div>

<?Php
	$html = ob_get_contents();
	ob_end_clean();
	$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
	$pdf -> SetDisplayMode('fullpage');
	//$stylesheet = '<style>'.file_get_contents(asset('bootstrap/css/bootstrap.min.css')).'</style>';
	$pdf -> WriteHTML($html, 2);
	$pdf -> Output(storage_path() . '/' . $userCampaign -> id . '.pdf', 'F');
?>
<p>
	<div id = "convert_pdf" style="margin: auto;">
		<center>Converting Voucher to PDF <img src="{{ Config::get('app.host_name').'/'.'assets/img/ajax-loader.gif' }}"></center>
	</div>
</p>
@stop
@section('scripts')
<script>
	$(document).ready(function() {
		
		setTimeout(function() {
			showDownload()
		}, 2000);
	});
	function showDownload() {
		window.location.assign("{{{ URL::to('campaign/stream_pdf/'.$userCampaign->id) }}}");
	}
</script>
@stop
