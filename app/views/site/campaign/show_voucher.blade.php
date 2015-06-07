<?php
require_once (public_path() . '/mpdf60/mpdf.php');
?>
@extends('site.layouts.modal_voucher')

{{-- Content --}}
@section('content')
<div style="width: 1200px; height: 538px; border: 1px solid">
<div class="Logo-Pane" style="float: left; width: 200px; height: 536px; background-color: #1b7f9f;">
	<div class="Logo" >
		<!-- <center>Lovedining LOGO</center> -->
		<img src="{{{ asset('assets/img/logolarge.png') }}}" alt="Logo"  height="195px" class ="logo">
	</div>
	<div class="Voucher" style="padding-top: 200px;">
		<!-- <center>Voucher</center> -->
		<img src="{{{ asset('assets/img/EVoucher.png') }}}" width="200px" class ="Voucher">
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 998px; height: 536px; padding: 0px 0px 0px 10px; display: block; background-color: #1b7f9f;">
	<div class="Banner-Pane" style="float: left; width: 758px; background-color: #1b7f9f; height: 237px;">
		@if(!(count(glob(Config::get('app.image_path').'/'.$campaign->album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign ->album_name . '/banner/', true);
			?>
			<div class="banner_reserve">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/banner/'.$banner[0]}}" alt="Banner" align="middle" width="758px" height="237px"/></center>
			</div>
		@elseif(!(count(glob(Config::get('app.image_path').'/'.$campaign->post-> album_name.'/banner/'.'*.{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}',GLOB_BRACE)) === 0))
			<?php
			$banner = Picture::directoryToArray(Config::get('app.image_path') . '/' . $campaign -> post-> album_name . '/banner/', true);
			?>
			<div class="banner_main">
				<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->post-> album_name.'/banner/'.$banner[0]}}" width="90%" alt="Banner" align="middle" /></center>
			</div>
		@endif
		<div class="Owner-Pane" style="float: left; width: 758px; margin-top:5px; border-radius: 5px; margin-right:1%;background-color:white; height: 75px;">
			<div class="customer-detail" style="margin-top:10px;">
			@if($campaign->show_firstname == 1 || $campaign->show_lastname == 1)
				<p style="padding-left: 10px;">
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
				<p style="padding-left: 10px;">
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
		<div class="Main-Bottom" style="float: left; width: 758px; margin-top:5px; background-color:#1b7f9f; height:212px; ">
			<div class="Priviledge-detail" style="float: left; background-color: white; width: 374px; height: 210px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 5px"><strong>Priviledge Detail: </strong></p>
				<p style="padding-left: 20px;">{{ String::tidy($campaign->description) }}</p>
			</div>
			<div class="Term-Cond" style="float: left;  margin-left:10px; background-color: white; width: 374px; height: 210px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 5px"><strong>Term & Conditions</strong></p>
				<?php $i=0;?>
				@if($campaign->remark1 != "")
				<p style="padding-left: 20px;">
					{{++$i}}. {{$campaign->remark1}}
				</p>
				@endif
				@if($campaign->remark2 != "")
				<p style="padding-left: 20px;">
					{{++$i}}. {{$campaign->remark2}}
				</p>
				@endif
			</div>
		</div>
	</div>
	<div class="Detail-Pane" style="float: left; width: 220px; margin-left: 10px; background-color: white; height: 536px; ">
		@if($campaign->hotel_logo!="")
		<p>
		<center><img src="{{Config::get('app.image_base_url').'/'.$campaign->album_name.'/'.$campaign->hotel_logo}}" alt="" height="75px"></center>
		</p>
		@else
		<p>
		<img src="http://placehold.it/260x180" alt="" height="150">
		</p>
		@endif
		<div class="restaurant-name" style="margin-top: 70px">
		<p style="padding-left: 10px; line-height: 10%;"><strong>Restaurant Name: </strong></p>
		<p style="padding-left: 15px;">{{String::tidy($campaign->post->restaurant_name)}}</p>
		</div >
		<br />
		<div class="restaurant-address" style="height: 100px; word-wrap: break-word; margin-top: 20px"><p style="padding-left: 10px;">
			<p style="padding-left: 10px; line-height: 10%;"><strong>Address:</strong></p> 
			<p style="padding-left: 15px;">
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
		<p style="padding-left: 10px; line-height: 10%"><strong>Validity:</strong></p>
		<?php $startDate =  new DateTime($campaign->start_date); ?>
		<?php $endDate =  new DateTime($campaign->expiry_date); ?>
		@if($startDate->format('Y') == $endDate->format('Y'))
			<p style="padding-left: 15px;">{{{ $startDate->format('d M') }}} - {{{ $endDate->format('d M Y') }}}</p>
		@else
			<p style="padding-left: 15px;">{{{ $startDate->format('d M Y') }}} - {{{ $endDate->format('d M Y') }}}</p>
		@endif
		<div class="code" style="margin-top:100px;">
			<p style="padding-left: 10px; line-height: 10%"><strong>Code:</strong></p>
			<p style="padding-left: 15px;">{{$userCampaign->campaign_code}}</p>
		</div>
		
	</div>
</div>
</div>
<br />
<br />
<div class="panel-footer footer-container">
			<div id="footer" style="word-break: break-all;">
				<div class="container">
					<p class="pull-right">		
						<a href="{{{ URL::to('/') }}}"><img src={{asset('assets/img/spoonforkfooter.png')}} style="width: 50px;"></a></li>
					</p>
					<p class="pull-right">		
						<br></br>
						<br>
						<a href="{{{ URL::to('/') }}}"><img src={{asset('assets/img/social_gray/fb.png')}} style="width: 25px;"></a></li>
						<a href="{{{ URL::to('/') }}}"><img src={{asset('assets/img/social_gray/twitter.png')}} style="width: 25px;"></a></li>
					</p>
					
					
					<table>
						<tr>
							<th class="col-md-4"><a href="{{{ URL::to('/') }}}" style="color:#0D8FA9;">Advertisement</a></li>
						</th>
							<td class="col-md-4"><a href="{{{ URL::to('about-us') }}}" style="color:#0D8FA9;">เกี่ยวกับเรา</a></td>
						</tr>
						<tr>
							<td class="col-md-4"><a href="{{{ URL::to('/') }}}" style="color:#0D8FA9;">ติดต่อโฆษณา</a></td>
							<td class="col-md-4"><a href="{{{ URL::to('/') }}}" style="color:#0D8FA9;">ติอต่อเรา</a></td>
						</tr>
						<tr>
							<td class="col-md-4"><a href="{{{ URL::to('/') }}}" style="color:#0D8FA9;">Lovedining</a></td>
							
						</tr>
						<tr>
							<td class="col-md-4"><a href="http://www.2madames.com" style="color:#0D8FA9;">2madames.com</a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="footer-container">
			<p class="muted credit pull-right">
						<font color="#0D8FA9">© 2014 LOVEDININGS.com</font>
						
					</p>
		</div>
<?php ob_start(); ?>
<div style="width: 1000px; height: 448px; border: 1px solid">
<div class="Logo-Pane" style="float: left; width: 180px; height: 448px; background-color: #1b7f9f;">
	<div class="Logo" style="margin-top:15px">
		<!-- <center>Lovedining LOGO</center> -->
		<img src="{{{ asset('assets/img/logolarge.png') }}}" alt="Logo"  height="195px" class ="logo">
	</div>
	<div class="Voucher" style="padding-top: 140px;">
		<!-- <center>Voucher</center> -->
		<img src="{{{ asset('assets/img/EVoucher.png') }}}" width="180px" class ="Voucher">
	</div>
	
</div>
<div class="Main-Pane" style="float: left; width: 810px; height: 448px; padding: 0px 0px 0px 10px; display: block; background-color: #1b7f9f;">
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
		<div class="Owner-Pane" style="float: left; width: 610px; margin-top:5px; border-radius: 5px; margin-right:1%;background-color:white; height: 50px;">
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
		<div class="Main-Bottom" style="float: left; width: 610px; margin-top:5px; background-color:#1b7f9f; height:190px; ">
			<div class="Priviledge-detail" style="float: left; background-color: white; width: 300px; height: 185px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 15px;line-height: 10%;font-size: 12px"><strong>Priviledge Detail: </strong></p>
				<p style="padding-left: 20px;line-height: 100%;font-size: 12px">{{ String::tidy($campaign->description) }}</p>
			</div>
			<div class="Term-Cond" style="float: left;  margin-left:10px; background-color: white; width: 300px; height: 185px; border-radius: 5px;">
				<p style="padding-left: 10px; margin-top: 15px;line-height: 10%;font-size: 12px"><strong>Term & Conditions</strong></p>
				<?php $i=0;?>
				@if($campaign->remark1 != "")
				<p style="padding-left: 20px;line-height: 100%;font-size: 12px">
					{{++$i}}. {{$campaign->remark1}}
				</p>
				@endif
				@if($campaign->remark2 != "")
				<p style="padding-left: 20px;">
					{{++$i}}. {{$campaign->remark2}}
				</p>
				@endif
			</div>
		</div>
	</div>
	<div class="Detail-Pane" style="float: left; width: 190px; margin-left: 10px; background-color: white; height: 448px; ">
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
	//$pdf->WriteHTML($stylesheet, 1);
	$pdf -> WriteHTML($html, 2);
	$pdf -> Output(storage_path() . '/' . $userCampaign -> id . '.pdf', 'F');
?>


@stop
@section('scripts')

@stop
