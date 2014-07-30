<!DOCTYPE html>

<html lang="en">

	<head id="Starter-Site">

		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title> @section('title')
			{{{ $title }}} :: Administration
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

	<body onunload="reload()">
		<!-- Container -->
		<div class="container">

			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<div class="page-header">
				<h3> {{ $title }}
				<div class="pull-right">
					<button class="btn btn-default btn-small btn-inverse close_popup">
						<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
					</button>
				</div></h3>
			</div>

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
			$(document).ready(function() {
				$('.close_popup').click(function() {
					parent.oTable.fnReloadAjax();
					parent.jQuery.fn.colorbox.close();
					return false;
				});
				$('#deleteForm').submit(function(event) {
					var form = $(this);
					$.ajax({
						type : form.attr('method'),
						url : form.attr('action'),
						data : form.serialize()
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
			$(function() {
				$('*[name=expiryDate]').appendDtpicker();
			});
		
		</script>
		<script>
		function reload()
		{
			parent.oTable.fnReloadAjax();
		}
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
