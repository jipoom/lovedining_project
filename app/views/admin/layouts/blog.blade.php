<!DOCTYPE html>

<html lang="en">

<head id="Starter-Site">

	<meta charset="UTF-8">

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
		@section('title')
			{{{ $title }}} :: Administration
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
    <link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />

	<style>
	.tab-pane {
		padding-top: 20px;
	}
	</style>

	@yield('styles')

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
	<script type="text/javascript">
		var _gaq = _gaq || [];
	  	_gaq.push(['_setAccount', 'UA-31122385-3']);
	  	_gaq.push(['_trackPageview']);

	  	(function() {
	   		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  	})();

	</script> -->

</head>

<body>
	<div id = "showCategory">
			<!-- Container -->
			<div id="wrap">
				<!-- Navbar -->
				<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<img src="smiley.gif" alt="Logo" width="100" height="100">

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
						<div class="collapse navbar-collapse navbar-ex1-collapse">
							<ul class="nav navbar-nav">
								<li{{ (Request::is('admin') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
									<li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
										<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}>
											<a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Comments</a></li>
											<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
												<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}"> <span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span> </a>
												<ul class="dropdown-menu">
													<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}>
														<a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a>
											</li>
											<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}>
												<a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
							</ul>
							</li>

							<li class="dropdown{{ (Request::is('admin/category*|admin/order*') ? ' active' : '') }}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/category') }}}"> <span class="glyphicon glyphicon-list-alt"></span> Category <span class="caret"></span> </a>
								<ul class="dropdown-menu">
									<li{{ (Request::is('admin/category*') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('admin/category') }}}"><span class="glyphicon glyphicon-list-alt"></span> Manage</a>
							</li>
							<li{{ (Request::is('admin/order*') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('admin/order') }}}"><span class="glyphicon glyphicon-list-alt"></span> Order</a></li>
								</ul>
								</li>

								<li{{ (Request::is('admin/campaign*') ? ' class="active"' : '') }}>
									<a href="{{{ URL::to('admin/campaign') }}}"><span class="glyphicon glyphicon-list-alt"></span> Campaign</a></li>
									</ul>
									<ul class="nav navbar-nav pull-right">

										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li>
													<a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-wrench"></span> View Homepage</a>
												</li>
												<li class="divider-vertical"></li>
												<li>
													<a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-wrench"></span> Info</a>
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
	<script src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
	<script src="{{asset('assets/js/jquery.simple-dtpicker.js')}}"></script>
	
 <script type="text/javascript">
$(document).ready(function(){
$('.close_popup').click(function(){
parent.oTable.fnReloadAjax();
parent.jQuery.fn.colorbox.close();
return false;
});
$('#deleteForm').submit(function(event) {
var form = $(this);
$.ajax({
type: form.attr('method'),
url: form.attr('action'),
data: form.serialize()
}).done(function() {
parent.jQuery.colorbox.close();
parent.oTable.fnReloadAjax();
}).fail(function() {
});
event.preventDefault();
});
});
$('.wysihtml5').wysihtml5();
$(prettyPrint)


//DatePicker
$(function(){
		$('*[name=expiryDate]').appendDtpicker();
});


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