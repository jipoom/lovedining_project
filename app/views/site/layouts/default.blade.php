<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title> @section('title')
			LoveDinings
			@show </title>
		<meta name="keywords" content="{{ (isset($post) ? $post->title : 'Lovedinings')}}" />
		<meta name="author" content="LoveDinings" />
		<meta name="description" content="{{(isset($post) ? $post->title : 'Lovedinings')}}" />
		@if(isset($post))
			<meta property="og:title" content="{{$post->title}}" />
			<meta property="og:url" content="{{$post->url()}}" />
			<meta property="og:type" content="website" />
			<meta property="og:image" content="{{Config::get('app.image_base_url').'/'.$post->album_name.'/'.$post->profile_picture_name}}" />
			<meta property="fb:app_id" content="566292166825639"/>
			@if(Session::get('Lang') == 'TH')
				<meta property="og:description" content="{{Str::limit(preg_replace('%(([<][/]*[ก-๙a-zA-Z0-9 =/_{}:;\".-]*[>]*)+)|(&nbsp;)%', '', $post->content()), 200, '...')}}" />
			@elseif(Session::get('Lang') == 'EN')
				<meta property="og:description" content="{{Str::limit(preg_replace('%(([<][/]*[ก-๙a-zA-Z0-9 =/_{}:;\".-]*[>]*)+)|(&nbsp;)%', '', $post->content_en()), 200, '...')}}" />
			@elseif(Session::get('Lang') == 'CN')
				<meta property="og:description" content="{{Str::limit(preg_replace('%(([<][/]*[ก-๙a-zA-Z0-9 =/_{}:;\".-]*[>]*)+)|(&nbsp;)%', '', $post->content_cn()), 200, '...')}}" />
			@endif
		@endif
		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/ribbon.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/dbcdss.css')}}">
		<style>

			@section('styles')
			@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
		<!-- CSS -->
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/prettify.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/bootstrap-wysihtml5.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">

		@yield('styles')
	</head>

	<body>
		<!-- for facebook like and share -->
		<div id="fb-root"></div>
		<!-- To make sticky footer need to wrap in a div -->
		<!-- div relaod -->
		<div id="reload">
			<div id="wrap">
				<!-- Navbar -->
				<div class="navbar navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<a href="{{{ URL::to('/') }}}"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo"  height="125" class ="logo"></a>

							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						
						<div class="slogan">

							

						</div>   
						<!-- Home Contact About -->
						<div class ="home-contact-about pull-right">
							<br />
							<a href="{{{ URL::to('/') }}}"><span class="glyphicon"></span>	<font color="#0D8FA9">HOME</font> </a></li> | 
							<a href="{{{ URL::to('about-us') }}}"><span class="glyphicon"></span>	<font color="#0D8FA9">ABOUT US</font> </a></li> |
							<a href="{{{ URL::to('/') }}}"><span class="glyphicon"></span>	<font color="#0D8FA9">CONTACT </font></a></li>
				
						</div>
						
						<!-- Social -->
						<div id="social">
							<br />
							<a href="{{{ URL::to('/') }}}"><img src={{asset('assets/img/social_blue/fb.png')}} style="width: 25px;"></a></li>
							<a href="{{{ URL::to('/') }}}"><img src={{asset('assets/img/social_blue/twitter.png')}} style="width: 25px;"></a></li>

						</div>
						
						<!-- language flag -->
						<div id="langflag">
							<!--
							<a href="{{{ URL::to('lang/TH') }}}">{{(Session::get('Lang') == 'TH') ? '<strong>TH</strong>': 'TH'}} </a></li>
							<a href="{{{ URL::to('lang/EN') }}}">{{(Session::get('Lang') == 'EN') ? '<strong>EN</strong>': 'EN'}} </a></li>
							<a href="{{{ URL::to('lang/CN') }}}">{{(Session::get('Lang') == 'CN') ? '<strong>CN</strong>': 'CN'}} </a></li>
							-->
							<br />
							<a href="{{{ URL::to('lang/TH') }}}">{{(Session::get('Lang') == 'TH') ? '<img src='.asset('assets/img/thD.png').' title="Thai" class="lang_th">': '<img src='.asset('assets/img/th.png').' title="Thai" class="lang_th">'}} </a></li>
							<a href="{{{ URL::to('lang/EN') }}}">{{(Session::get('Lang') == 'EN') ? '<img src='.asset('assets/img/enD.png').' title="Thai" class="lang_en">': '<img src='.asset('assets/img/en.png').' title="English" class="lang_en">'}} </a></li>
							<a href="{{{ URL::to('lang/CN') }}}">{{(Session::get('Lang') == 'CN') ? '<img src='.asset('assets/img/cnD.png').' title="Thai" class="lang_cn">': '<img src='.asset('assets/img/cn.png').' title="Chinese" class="lang_cn">'}} </a></li>
						</div>
						
					</div>
					<div class="container">
						<div class="collapse navbar-collapse navbar-ex1-collapse">

							<ul class="nav navbar-nav">

								<!--<li{{ (Request::is('/') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
-->
									<?php $mode = CategoryOrder::getMode(); ?>
									@foreach(CategoryOrder::getOrder($mode) as $category)
									<li {{ (Request::is('category/'.$category->
										id.'*') ? ' class="selected"' : '') }}> <a href="{{{ URL::to('category/'.$category->id) }}}">{{$category->category_name}} 
											@if (Auth::check())
											<?php $numUnread = PostsUserRead::getUnreadReviews($category, Auth::user() -> id); ?>
											@if($numUnread>0)
												({{$numUnread}})
											@endif
										@endif <font color="#777">|</font> </a>
									</li>

									@endforeach
									<li {{ (Request::is('news*') ? ' class="selected"' : '') }}><a href="{{{ URL::to('/') }}}">News   |</a></li>
									<li {{ (Request::is('campaign*') ? ' class="selected"' : '') }}><a href="{{{ URL::to('campaign') }}}">Campaigns   |</a></li>
									
									<li>
										<form class ="form-dropdown ">
											<select name="sort" id ="mode" onchange="showReviews(this.value)">
												<option value="" selected>View by</option>
												@if($mode == "date")
												<option value="date" selected>Recently published</option>
												@else
												<option value="date">Recently published</option>
												@endif
												@if($mode == "reviewName")
												<option value="reviewName" selected>Review Name</option>
												@else
												<option value="reviewName">Review Name</option>
												@endif
												@if($mode == "restaurantName")
												<option value="restaurantName" selected>Restaurant Name</option>
												@else
												<option value="restaurantName">Restaurant Name</option>
												@endif
												@if($mode == "popularity")
												<option value="popularity" selected>Popularity</option>
												@else
												<option value="popularity">Popularity</option>
												@endif
											</select>
										</form>
									</li>
							</ul>
							

							<ul class="nav navbar-nav pull-right">
								@if (Auth::check())

								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span> </a>
									<ul class="dropdown-menu">
										@if (Auth::user()->hasRole('admin'))
										<li>
											<a href="{{{ URL::to('admin/home') }}}"><span class="glyphicon"></span> Admin Panel</a>
										</li>
										@endif
										<?php $numNewMessage = PrivateMessage::newMessage(Auth::user() -> username); ?>
										<li>
											<a href="{{{ URL::to('message_service') }}}"><span class="glyphicon"></span> Inbox @if($numNewMessage>0) ({{$numNewMessage}}) @endif</a>
										</li>
										<li>
											<a href="{{{ URL::to('user') }}}"><span class="glyphicon"></span> Settings</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a>
										</li>
									</ul>
								</li>
								@else
								<li {{ (Request::is('user/login') ? ' class="selected"' : '') }}>
									<a href="{{{ URL::to('user/login') }}}">Login&nbsp;&nbsp;</a>
								</li>
								<li {{ (Request::is('user/create') ? ' class="selected"' : '') }}>
									<a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a>
								</li>
								@endif
							</ul>

							<!-- ./ nav-collapse -->
						</div>
					</div>
				</div>
				<!-- ./ navbar -->

				<!-- .Ads
				<div class="ads-right ">

				<div class="col-md-12">

				<a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
				<a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a><a href="" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>

				</div>
				</div>
				./ Ads -->

				<!-- Container -->
				<div class="container">
					<!-- Notifications -->
					@include('notifications')

					<!-- ./ notifications -->

					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
				<!-- ./ container -->

				<!-- the following div is needed to make a sticky footer -->
				<div id="push"></div>
			</div>
			<!-- ./wrap -->
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
						
			<!-- Javascripts
			================================================== -->
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
			<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('assets/js/wysihtml5/wysihtml5-0.3.0.js')}}"></script>
			<script src="{{asset('assets/js/wysihtml5/bootstrap-wysihtml5.js')}}"></script>
			<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
			<script src="{{asset('assets/js/datatables-bootstrap.js')}}"></script>
			<script src="{{asset('assets/js/datatables.fnReloadAjax.js')}}"></script>
			<script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
			<script src="{{asset('assets/js/prettify.js')}}"></script>

			<!-- Search Review -->
			<script>
				function searchActionDefault(mode) {
					var word = $("#keywords").val();
					if (mode == "") {
						document.getElementById("txtHint").innerHTML = "";
						return;
					}
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							document.getElementById("reload").innerHTML = xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET", "{{{ URL::to('search') }}}/" + word, true);
					xmlhttp.send();

				}

				function runScript(e) {
					if (e.keyCode == 13) {
						searchActionDefault("go");
					}
				}
			</script>
			<!-- End Search Review -->
			
			<!-- Sort Review -->
<script>
	function showReviews(mode) {
		var categoryId = $("#category").val();
		var keyword = $("#keywords").val();
		if (mode == "") {
			document.getElementById("txtHint").innerHTML = "";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("reload").innerHTML = xmlhttp.responseText;
				document.getElementById("mode").value = mode;
			}
		}
		//xmlhttp.open("GET", categoryId + "/" + mode, true);
		if(keyword!="")
		{
			xmlhttp.open("GET", "{{{ URL::to('category') }}}/"+categoryId + "/" + mode + "/" + keyword, true);
		}
		else
		{
			xmlhttp.open("GET", "{{{ URL::to('category') }}}/"+categoryId + "/" + mode, true);
		}
		xmlhttp.send();

	}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59527800-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End Sort Review -->
			
			@yield('scripts')
		</div>
		<!-- end div relaod -->
	</body>
</html>
