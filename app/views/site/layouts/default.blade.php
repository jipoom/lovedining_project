<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title> @section('title')
			Laravel 4 Sample Site
			@show </title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">

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
	</head>

	<body>
		<!-- for facebook like and share -->
		<div id="fb-root"></div>
		<!-- To make sticky footer need to wrap in a div -->
		<!-- div relaod -->
		<div id="reload">
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
								<li {{ (Request::is('category/'.$category->
									id) ? ' class="active"' : '') }}> <a href="{{{ URL::to('category/'.$category->id) }}}">{{$category->category_name}}
									@if (Auth::check())
									<?php
									$unread = 0;
									$unread = Post::where('category_id', '=', $category -> id) -> count() - PostsUserRead::where('user_id', '=', Auth::user() -> id) -> where('category_id', '=', $category -> id) -> count();
									?>
									@if($unread>0)
									({{$unread}})
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

					@yield('sort')
					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
				<!-- ./ container -->

				<!-- the following div is needed to make a sticky footer -->
				<div id="push"></div>
			</div>
			<!-- ./wrap -->

			<div id="footer">
				<div class="container">
					<p class="muted credit">
						Lovedining
					</p>
				</div>
			</div>

			<!-- Javascripts
			================================================== -->
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
			<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
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
			<!-- for facebook like and share -->
			<script>
				( function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id))
							return;
						js = d.createElement(s);
						js.id = id;
						js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=566292166825639&version=v2.0";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
			</script>

			@yield('scripts')
		</div>
		<!-- end div relaod -->
	</body>
</html>
