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
				<!-- CSS -->
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/prettify.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/bootstrap-wysihtml5.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">
		
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
						<!--
						<div style="height: 45px;">

						testttttttt

						</div>   -->

						<!-- Searchbox -->
						<div id="tfnewsearch">

							<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}"size="15" maxlength="120" onkeypress="return runScript(event)">
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
<div class="container">
						<div class="collapse navbar-collapse navbar-ex1-collapse">

							<ul class="nav navbar-nav">
								
								<li{{ (Request::is('/') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>

									
								
								
								
								
								
								<?php $mode = CategoryOrder::getMode(); ?>
								@foreach(CategoryOrder::getOrder($mode) as $category)
								<li {{ (Request::is('category/'.$category-> id) ? ' class="active"' : '') }}> <a href="{{{ URL::to('category/'.$category->id) }}}"><span class="glyphicon glyphicon-cutlery"></span> {{$category->category_name}}
									@if (Auth::check())
										<?php $numUnread = PostsUserRead::getUnreadReviews($category,Auth::user()->id); ?>
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
											<a href="{{{ URL::to('admin') }}}"><span class="glyphicon"></span> Admin Panel</a>
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
		<script src="{{asset('assets/js/wysihtml5/wysihtml5-0.3.0.js')}}"></script>
		<script src="{{asset('assets/js/wysihtml5/bootstrap-wysihtml5.js')}}"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
		<script src="{{asset('assets/js/datatables-bootstrap.js')}}"></script>
		<script src="{{asset('assets/js/datatables.fnReloadAjax.js')}}"></script>
		<script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
		<script src="{{asset('assets/js/prettify.js')}}"></script>
			
			
			@yield('scripts')
		</div>
		<!-- end div relaod -->
	</body>
</html>
