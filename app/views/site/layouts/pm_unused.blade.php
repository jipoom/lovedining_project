<!DOCTYPE html>

<html lang="en">

	<head id="Starter-Site">

		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title> @section('title')
			Private Message
			@show </title>

		<meta name="keywords" content="@yield('keywords')" />
		<meta name="author" content="@yield('author')" />
		<!-- Google will often use this as its description of your page/site. Make it good. -->
		<meta name="description" content="@yield('description')" />

		<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
		<meta name="google-site-verification" content="">

		<!-- Dublin Core Metadata : http://dublincore.org/ -->
		<meta name="DC.title" content="Project Name">
		<meta name="DC.subject" content="@yield('description')">
		<meta name="DC.creator" content="@yield('author')">

		<!--  Mobile Viewport Fix -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- This is the traditional favicon.
		- size: 16x16 or 32x32
		- transparency is OK
		- see wikipedia for info on browser support: http://mky.be/favicon/ -->
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">

		<!-- iOS favicons. -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

		<!-- CSS -->
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/prettify.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/bootstrap-wysihtml5.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">

		@yield('styles')

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>

	<body>

		<div id = "reload">
			<!-- Container -->
			<div id="wrap">
				<!-- Navbar -->
				<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo" width="170" height="100">

							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div style="height: 45px;">

							testttttttt
							<!-- Searchbox -->
							<div id="tfnewsearch">

								<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder ="Search" size="15" maxlength="120" onkeypress="return runScript(event)">
								<input type="submit" value="Go" id = "go" class="tfbutton" onclick ="searchAction(this.value)">

								<!--Sort by:<select name="sort" id ="mode" onchange="searchAction(this.value)">
								<option value="date">Recently published</option>
								<option value="reviewName">Review Name</option>
								<option value="restaurantName">Restaurant Name</option>
								<option value="popularity">Popularity</option>
								</select>	-->

								<div class="tfclear"></div>
							</div>

						</div>

						<div class="collapse navbar-collapse navbar-ex1-collapse">

							<ul class="nav navbar-nav">
								<li {{ (Request::is('/') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('') }}}">Home</a>
								</li>
								<?php $mode = CategoryOrder::getMode(); ?>
								@foreach(CategoryOrder::getOrder($mode) as $category)
								<li {{ (Request::is('category/'.$category->id) ? ' class="active"' : '') }}> <a href="{{{ URL::to('category/'.$category->id) }}}">{{$category->category_name}}
									@if (Auth::check())
										<?php $numUnread = PostsUserRead::getUnreadReviews($category,Auth::user()->id);?>
										@if($numUnread>0)
											({{$numUnread}})
										@endif
									@endif </a>
								</li>

								@endforeach
							</ul>

							<ul class="nav navbar-nav pull-right">
								@if (Auth::check())
								<li class="divider-vertical"></li>
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span> </a>
									<ul class="dropdown-menu">
										@if (Auth::user()->hasRole('admin'))
										<li>
											<a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-wrench"></span> Admin Panel</a>
										</li>
										@endif
										<?php $numNewMessage = PrivateMessage::newMessage(Auth::user() -> username); ?>
										<li>
											<a href="{{{ URL::to('message_service') }}}"><span class="glyphicon glyphicon-wrench"></span> Inbox @if($numNewMessage>0) ({{$numNewMessage}}) @endif</a>
										</li>
										<li>
											<a href="{{{ URL::to('user') }}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a>
										</li>
									</ul>
								</li>
								@else
								<li {{ (Request::is('user/login') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('user/login') }}}">Login</a>
								</li>
								<li {{ (Request::is('user/register') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a>
								</li>
								@endif
							</ul>

							<!-- ./ nav-collapse -->
						</div>
					</div>
				</div>
				<!-- ./ navbar -->

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
			<!-- Footer -->
			<footer class="clearfix">
				@yield('footer')
			</footer>
			<!-- ./ Footer -->

			<!-- ./ container -->
		</div>
		<!-- ./ showCategory -->

		<!-- Javascripts -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/js/wysihtml5/wysihtml5-0.3.0.js')}}"></script>
		<script src="{{asset('assets/js/wysihtml5/bootstrap-wysihtml5.js')}}"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
		<script src="{{asset('assets/js/datatables-bootstrap.js')}}"></script>
		<script src="{{asset('assets/js/datatables.fnReloadAjax.js')}}"></script>
		<script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
		<script src="{{asset('assets/js/prettify.js')}}"></script>

		<script type="text/javascript">
			$('.wysihtml5').wysihtml5();
			$(prettyPrint);
		</script>
		<!-- SearchAction -->
		<script>
				function searchAction(mode) {
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
						searchAction("go");
					}
				}
			</script>
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="{{asset('assets/js/tiny_mce/tiny_mce.js')}}"></script>
		<script type="text/javascript">
			tinyMCE.init({

				mode : "textareas",

				// ===========================================
				// Set THEME to ADVANCED
				// ===========================================

				theme : "advanced",

				// ===========================================
				// INCLUDE the PLUGIN
				// ===========================================

				plugins : "jbimages,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

				// ===========================================
				// Set LANGUAGE to EN (Otherwise, you have to use plugin's translation file)
				// ===========================================

				language : "en",

				theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,preview,|,forecolor,backcolor,|,jbimages,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions",

				// ===========================================
				// Put PLUGIN'S BUTTON on the toolbar
				// ===========================================

				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// ===========================================
				// Set RELATIVE_URLS to FALSE (This is required for images to display properly)
				// ===========================================

				relative_urls : false

			});
		</script>
		<!-- /TinyMCE -->
		@yield('scripts')

	</body>

</html>
