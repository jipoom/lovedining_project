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
		Campaign Banner
	</div>
	<div class="Detail-Pane" style="float: left; width: 30%;  margin-top: 10px; background-color: yellow; height: 390px">
		Campaign Detail
	</div>
	<div class="Owner-Pane" style="float: left; width: 69%; margin-top:5px; margin-right:1%;background-color:pink; height: 280px">
		Onwer Info
	</div>
	<div class="Term-Pane" style="float: left; width: 30%; margin-top:5px; background-color: blue; height: 180px">
		Term and Condition
	</div>
	<div class="Code-Pane" style="float: left; width: 30%; margin-top:5px; background-color: violet; height: 95px">
		Code
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
		Campaign Banner
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
