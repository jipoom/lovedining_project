<!DOCTYPE html>

<html lang="en">

	<head id="Starter-Site">

		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title> @section('title')
			Administration
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
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">

		@yield('styles')

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>

	<body>

		<div id = "showCategory">
			<!-- Container -->
			<div id="wrap">
				<!-- Navbar -->
				<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<a href="{{{ URL::to('/') }}}"><img src="{{{ asset('assets/img/logo.png') }}}" alt="Logo" width="170" height="100"></a>

							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="slogan navbar-fixed-top">



						</div>  

						<!-- Searchbox -->
						<div id="tfnewsearch">

							<input type="text" class="tftextinput" name="keyword" id ="keywords" value = "{{isset($keyword) ? $keyword : null}}" placeholder = "ค้นหา ชื่อร้าน ชื่อรีวิว หรือสถานที่"size="25" maxlength="120" onkeypress="return runScript(event)">
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
								<li{{ (Request::is('admin/home*') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('admin/home') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>






									<li{{ (Request::is('admin/introduction*') ? ' class="active"' : '') }}>
									 @if(Introduction::first())
										<a href="{{ URL::to('admin/introduction') }}/{{Introduction::first()->id}}/edit"><span class="glyphicon glyphicon-book"></span> Introduce</a></li>
									 @else
									 	<a href="{{ URL::to('admin/introduction/create') }}"><span class="glyphicon glyphicon-book"></span> Introduce</a></li>
									 @endif
										
									 
							<li class="dropdown{{ (Request::is('admin/blogs*|admin/comments*') ? ' active' : '') }}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/blogs') }}}"> <span class="glyphicon glyphicon-list-alt"></span> Manage Reviews <span class="caret"></span> </a>
								<ul class="dropdown-menu">
									<li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-briefcase"></span> Reviews</a>
							</li>
							<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bookmark"></span> Comments</a></li>
								</ul>
							
							
								
												<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
													<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}"> <span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span> </a>
													<ul class="dropdown-menu">
														<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}>
															<a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a>
												</li>
												<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}>
													<a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-heart"></span> Roles</a></li>
							</ul>
							




							<li class="dropdown{{ (Request::is('admin/category*|admin/order*') ? ' active' : '') }}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/category') }}}"> <span class="glyphicon glyphicon-list-alt"></span> Category <span class="caret"></span> </a>
								<ul class="dropdown-menu">
									<li{{ (Request::is('admin/category*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/category') }}}"><span class="glyphicon glyphicon-briefcase"></span> Manage</a>
							</li>
							<li{{ (Request::is('admin/order*') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('admin/order') }}}"><span class="glyphicon glyphicon-bookmark"></span> Order</a></li>
								</ul>
								</li>

								<li{{ (Request::is('admin/campaign*') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('admin/campaign') }}}"><span class="glyphicon glyphicon-envelope"></span> Campaigns</a></li>




									<li{{ (Request::is('admin/ads*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/ads') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Ads</a></li>
								
									<li{{ (Request::is('admin/stat*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/stat') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Stat</a></li>
									
					<li class="dropdown{{ (Request::is('admin/dressing*|admin/foodtype*|admin/meal*') ? ' active' : '') }}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/blogs') }}}"> <span class="glyphicon glyphicon-list-alt"></span> Misc. <span class="caret"></span> </a>
								<ul class="dropdown-menu">
									<li{{ (Request::is('admin/meal*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/meal') }}}"><span class="glyphicon glyphicon-briefcase"></span> Meal</a>
							</li>
							<li{{ (Request::is('admin/dressing*') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('admin/dressing') }}}"><span class="glyphicon glyphicon-bookmark"></span> Dressing Style</a></li>
							<li{{ (Request::is('admin/foodtype*') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('admin/foodtype') }}}"><span class="glyphicon glyphicon-bookmark"></span> Food Type</a></li>	
								</ul>

</ul>

							<ul class="nav navbar-nav pull-right">
											<li class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span> </a>
												<ul class="dropdown-menu">
													<li>
														<a href="{{{ URL::to('/') }}}"><span class="glyphicon"></span> View Homepage</a>
													</li>
													<li class="divider-vertical"></li>
													<li>
														<a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon"></span> Info</a>
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
										</ul>
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
		<script type="text/javascript">
			$(".iframe").colorbox({
				iframe : true,
				width : "80%",
				height : "80%"
			});
		</script>
			<!-- Search Review -->
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
				document.getElementById("showCategory").innerHTML = xmlhttp.responseText;
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
<!-- End Sort Review -->

		@yield('scripts')

	</body>

</html>
