<!DOCTYPE html>

<html lang="en">

<head id="Starter-Site">

	<meta charset="UTF-8">

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
		@section('title')
			Administration
		@show
	</title>

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

	<style>
	body {
		padding: 60px 0;
	}
	
	#sortable1, #sortable2 {
    border: 1px solid #eee;
    width: 142px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  #sortable1 li, #sortable2 li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 120px;
	</style>

	@yield('styles')

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>

<body>
	
	<div id = "showCategory">
		<!-- Container -->
		<div class="container">
			<!-- Navbar -->
			<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
	            <div class="container">
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                    </button>
	                </div>
	    			<div class="collapse navbar-collapse navbar-ex1-collapse">
	    				<ul class="nav navbar-nav">
	    					<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	    					<li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
	    					<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Comments</a></li>
	    					<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
	    						<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
	    							<span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span>
	    						</a>
	    						<ul class="dropdown-menu">
	    							<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
	    							<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
	    						</ul>
	    					</li>
	    					
							<li class="dropdown{{ (Request::is('admin/category*|admin/order*') ? ' active' : '') }}">
	    						<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/category') }}}">
	    							<span class="glyphicon glyphicon-list-alt"></span> Category <span class="caret"></span>
	    						</a>
	    						<ul class="dropdown-menu">
	    							<li{{ (Request::is('admin/category*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/category') }}}"><span class="glyphicon glyphicon-list-alt"></span> Manage</a></li>
	    							<li{{ (Request::is('admin/order*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/order/') }}}"><span class="glyphicon glyphicon-list-alt"></span> Order</a></li>
	    						</ul>
	    					</li>
							    			    					
	    					<li{{ (Request::is('admin/campaign*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/campaign') }}}"><span class="glyphicon glyphicon-list-alt"></span> Campaign</a></li>
	    				</ul>
	    				<ul class="nav navbar-nav pull-right">
	    					<li class="dropdown">
	    							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	    								<span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}}	<span class="caret"></span>
	    							</a>
	    							<ul class="dropdown-menu">
	    								<li><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-wrench"></span> View Homepage</a></li>
	    								<li class="divider-vertical"></li>
	    								<li><a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-wrench"></span> Info</a></li>
	    								<li><a href="{{{ URL::to('user') }}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
	    								<li class="divider"></li>
	    								<li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
	    							</ul>
	    					</li>
	    				</ul>
	    			</div>
	            </div>
			</div>
			<!-- ./ navbar -->
	
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->
	
			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
	
			<!-- Footer -->
			<footer class="clearfix">
				@yield('footer')
			</footer>
			<!-- ./ Footer -->
	
		</div>
		<!-- ./ container -->


	</div>
	<!-- ./ showCategory -->
	<!-- Javascripts -->
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/wysihtml5/wysihtml5-0.3.0.js')}}"></script>
    <script src="{{asset('assets/js/wysihtml5/bootstrap-wysihtml5.js')}}"></script>
    <script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
    <script src="{{asset('assets/js/prettify.js')}}"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    

   

    @yield('scripts')

</body>

</html>
