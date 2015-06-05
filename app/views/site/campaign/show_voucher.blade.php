<?php
require_once (public_path() . '/mpdf60/mpdf.php');
?>
@extends('site.layouts.modal_voucher')

{{-- Content --}}
@section('content')
<div class="Logo-Pane" style="float: left; width: 30%; height: 700px; background-color: blue;">
	<div class="Logo" style="padding-top: 100px;">
		<center>Lovedining LOGO</center>
	</div>
	<div class="Voucher" style="padding-top: 400px;">
		<center>Voucher</center>
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 70%; height: 700px; padding: 0px 10px 0px 10px; display: block; background-color: red;">
	<div class="Banner-Pane" style="float: left; width: 70%; margin-top: 10px; background-color: green; height: 390px">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post-> album_name . '/banner/', true);
			?>
			<div>
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" width="90%" alt="Banner" align="middle" /></center>
			</div>
		
		@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign ->album_name . '/banner/', true);
			?>
			<div>
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" width="90%" alt="Banner" align="middle" /></center>
			</div>
		@endif
	</div>
	<div class="Detail-Pane" style="float: left; width: 30%;  margin-top: 10px; background-color: yellow; height: 390px">
		@if($campaign->hotel_logo!="")
		<p>
		<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="150"></center>
		</p>
		
		<p><strong>Restaurant Name</strong></p>
		<p>Address:</p>
		<p>Detail:</p>
		<p>Validity:</p>
		@else
		<img src="http://placehold.it/260x180" alt="" height="150">
		@endif
	</div>
	<div class="Owner-Pane" style="float: left; width: 69%; margin-top:5px; margin-right:1%;background-color:pink; height: 280px">
		Onwer Info
	</div>
	<div class="Term-Pane" style="float: left; width: 30%; margin-top:5px; background-color: blue; height: 180px">
		<p><strong>Terms & Conditions</strong></p>
	</div>
	<div class="Code-Pane" style="float: left; width: 30%; margin-top:5px; background-color: violet; height: 95px">
		<p><strong>Code</strong></p>
	</div>
</div>


<?php ob_start(); ?>
<div class="Logo-Pane" style="float: left; width: 25%; height: 650px; background-color: blue;">
	<div class="Logo" style="padding-top: 100px;">
		<center>Lovedining LOGO</center>
	</div>
	<div class="Voucher" style="padding-top: 400px;">
		<center>Voucher</center>
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 70%; height: 640px; padding: 10px 10px 0px 10px; display: block; background-color: red;">
	<div class="Banner-Pane" style="float: left; width: 70%; background-color: green; height: 370px">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->post->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post -> album_name . '/banner/', true);
			?>
			<div>
				<a href="{{$campaign->url()}}"><img src="{{Config::get('app.image_base_url').'/'.$campaign->post->album_name.'/banner/'.$banner[0]}}" alt="Banner" align="middle" /></a>
			</div>
		@endif
	</div>
	<div class="Detail-Pane" style="float: left; width: 30%;  background-color: yellow; height: 370px">
		Campaign Detail
	</div>
	<div class="Owner-Pane" style="float: left; width: 70%; margin: 5px 5px 0px 0px; background-color:pink; height: 255px">
		Onwer Info
	</div>
	<div class="Term-Code" style="float: left; width: 30%; background-color: blue; height: 255px">
		<div class="Term-Pane" style="background-color: blue; height: 150px">
			Term and Condition
		</div>
		<div class="Code-Pane" style=" margin-top: 5px; background-color: violet; height: 100px">
			Code
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
