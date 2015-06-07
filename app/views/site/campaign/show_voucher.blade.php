<?php
require_once (public_path() . '/mpdf60/mpdf.php');
?>
@extends('site.layouts.modal_voucher')

{{-- Content --}}
@section('content')
<div style="width: 1100px; height: 700px">
<div class="Logo-Pane" style="float: left; width: 300px; height: 700px; background-color: #1b7f9f;">
	<div class="Logo" style="padding: 40px;" >
		<!-- <center>Lovedining LOGO</center> -->
		<img src="{{{ asset('assets/img/logolarge.png') }}}" alt="Logo"  height="225px" class ="logo">
	</div>
	<div class="Voucher" style="padding-top: 200px;">
		<!-- <center>Voucher</center> -->
		<img src="{{{ asset('assets/img/EVoucher.png') }}}" width="300px" class ="Voucher">
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 800px; height: 700px; padding: 0px 10px 0px 10px; display: block; background-color: #1b7f9f;">
	<div class="Banner-Pane" style="float: left; width: 545px; margin-top: 10px; background-color: #1b7f9f; height: 475px">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign ->album_name . '/banner/', true);
			?>
			<div class="banner_reserve">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" alt="Banner" align="middle" width="545px" height="475px"/></center>
			</div>
		@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post-> album_name . '/banner/', true);
			?>
			<div class="banner_main">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" width="90%" alt="Banner" align="middle" /></center>
			</div>
		@endif
	</div>
	<div class="Detail-Pane" style="float: left; width: 30%;  margin-top: 10px; background-color: white; height: 475px">
		@if($campaign->hotel_logo!="")
		<p>
		<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="75px"></center>
		</p>
		<div class="restaurant-name" style="margin-top: 40px">
		<h4 style="padding-left: 10px;">{{String::tidy($campaign->post->restaurant_name)}}</h3>
		</div >
		<div class="restaurant-address" style="height: 100px; word-wrap: break-word; margin-top: 20px"><p style="padding-left: 10px;">
			Address: {{$campaign->post->address2}}
		
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
		<div class="campaign-detail" style="height: 160px; word-wrap: break-word;"><p style="padding-left: 10px;">Detail: {{ String::tidy($campaign->description) }}</p></div>
		<p style="padding-left: 10px;">Validity: {{$campaign->expiry_date}}</p>
		@else
		<img src="http://placehold.it/260x180" alt="" height="150">
		@endif
	</div>
	<div class="Owner-Pane" style="float: left; width: 69%; margin-top:13px; margin-right:1%;background-color:white; height: 195px">
		@if($campaign->show_firstname == 1)
		<div class="customer-detail" style="margin-top:10px;">
			<p style="padding-left: 10px;">
				<strong>Name</strong> {{$userCampaign->user_firstname}}
			@endif
			@if($campaign->show_lastname == 1)
				{{$userCampaign->user_lastname}}
			</p>
			@endif
			@if($campaign->show_email == 1)
			<p style="padding-left: 10px;">
				<strong>Email</strong> {{$userCampaign->user_email}}
			</p>
			@endif
			@if($campaign->show_cid == 1)
			<p style="padding-left: 10px;">
				<strong>ID No.</strong> {{$userCampaign->user_cid}}
			</p>
			@endif
			@if($campaign->show_tel == 1)
			<p style="padding-left: 10px;">
				<strong>MOBILE</strong> {{$userCampaign->user_tel}}
			</p>
		</div>
		@endif
	</div>
	<div class="Term-Pane" style="float: left; width: 30%; margin-top:13px; background-color: white; height: 145px">
		<div class="term-cond" style="margin-top:10px;">
			<p style="padding-left: 10px;"><strong>Terms & Conditions</strong></p>
			<?php $i=0;?>
			@if($campaign->remark1 != "")
			<p style="padding-left: 10px;">
				{{++$i}}. {{$campaign->remark1}}
			</p>
			@endif
			@if($campaign->remark2 != "")
			<p style="padding-left: 10px;">
				{{++$i}}. {{$campaign->remark2}}
			</p>
			@endif
		</div>
	</div>
	<div class="Code-Pane" style="float: left; width: 30%; margin-top:5px; background-color: white; height: 45px">
		<div class="code" style="margin-top:10px;">
			<p style="padding-left: 10px;"><strong>Code:</strong> {{$userCampaign->campaign_code}}</p>
		</div>
	</div>
</div>
</div>

<?php ob_start(); ?>
<div style="width: 1000px; height: 700px">
<div class="Logo-Pane" style="float: left; width: 250px; height: 700px; background-color: #1b7f9f;">
	<div class="Logo" style="padding-top: 40px;">
		<div style="text-align: center"><img src="{{{ asset('assets/img/logolarge.png') }}}" alt="Logo"  height="225px" class ="logo"></div>
	</div>
	<div class="Voucher" style="padding-top: 200px;">
		<div style="text-align: center"><img src="{{{ asset('assets/img/EVoucher.png') }}}" width="240px" class ="Voucher"></div>
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 700px; height: 700px; padding: 10px 10px 0px 10px; display: block; background-color: #1b7f9f;">
	<div class="Banner-Pane" style="float: left; width: 545px; background-color: white; height: 475px">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> album_name . '/banner/', true);
			?>
			<div class="banner-main-pdf">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign-> album_name.'/banner/'.$banner[0]}}" width="545px" height="475px" alt="Banner" align="middle" /></center>
			</div>
		@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post->album_name . '/banner/', true);
			?>
			<div class="banner-main-pdf">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" width="545px" height="475px" alt="Banner" align="middle" /></center>
			</div>
			
		@endif
	</div>
	<div class="Detail-Pane" style="float: left; width: 155px;  background-color: white; height: 475px">
		@if($campaign->hotel_logo!="")
		<p style="text-align: center"><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="Hotel" height="75px"></p>
		<div class="restaurant-name-pdf" style="height: 160px; word-wrap: break-word;"><p style="padding-left: 5px;">
			<p style="padding-left: 5px; font-size: 10pt"><strong>{{String::tidy($campaign->post->restaurant_name)}}</strong></p>
			<p style="padding-left: 5px; font-size: 8pt">
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
		<div class="campaign-detail-pdf" style="height: 160px; word-wrap: break-word;"><p style="padding-left: 5px; font-size: 8pt">Detail: {{ String::tidy($campaign->description) }}</p></div>
		<div><p style="padding-left: 5px; font-size: 8pt">Validity: {{$campaign->expiry_date}}</p></div>
		@endif
	</div>
	<div class="Owner-Pane" style="float: left; width: 540px; margin-top: 10px; background-color:white; height: 170px">
		@if($campaign->show_firstname == 1)
		<div class="customer-detail-pdf" style="margin-top:10px;">
			<p style="padding-left: 5px; font-size: 8pt">
				<strong>Name</strong> {{$userCampaign->user_firstname}}
			@endif
			@if($campaign->show_lastname == 1)
				{{$userCampaign->user_lastname}}
			</p>
			@endif
			@if($campaign->show_email == 1)
			<p style="padding-left: 5px; font-size: 8pt">
				<strong>Email</strong> {{$userCampaign->user_email}}
			</p>
			@endif
			@if($campaign->show_cid == 1)
			<p style="padding-left: 5px; font-size: 8pt">
				<strong>ID No.</strong> {{$userCampaign->user_cid}}
			</p>
			@endif
			@if($campaign->show_tel == 1)
			<p style="padding-left: 5px; font-size: 8pt">
				<strong>MOBILE</strong> {{$userCampaign->user_tel}}
			</p>
		</div>
		@endif
	</div>
	<div class="Term-Code" style="float: left; width: 160px; background-color: #1b7f9f; height: 170px">
		<div class="Term-Pane" style="float: left; width: 160px; margin-left:5px; background-color: white; height: 118px">
		<div class="Term-Cond-pdf">
			<p style="padding-left: 5px; font-size: 8pt"><strong>Terms & Conditions</strong></p>
			<?php $i=0;?>
			@if($campaign->remark1 != "")
			<p style="padding-left: 5px; font-size: 8pt">
				{{++$i}}. {{$campaign->remark1}}
			</p>
			@endif
			@if($campaign->remark2 != "")
			<p style="padding-left: 5px; font-size: 8pt">
				{{++$i}}. {{$campaign->remark2}}
			</p>
			@endif
		</div>
		</div>
		<div class="Code-Pane" style="float: left; width: 160px; margin-left:5px; margin-top:5px; background-color: white; height: 40px">
		<div class="Code-pdf">
			<p style="padding-left: 5px; font-size: 8pt"><strong> {{$userCampaign->campaign_code}}</strong></p>
		</div>
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
	//$pdf->WriteHTML($stylesheet, 1);
	$pdf -> WriteHTML($html, 2);
	$pdf -> Output(storage_path() . '/' . $userCampaign -> id . '.pdf', 'F');
?>


@stop
@section('scripts')

@stop
