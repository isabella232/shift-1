<!doctype html>
<html lang="en" ng-app="application" id="application">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ HTML::setting( 'app.site.name' ) }}</title>
		<meta name="author" content="Tectonic Digital">
		<link rel="icon" type="image/png" href="/bundles/shift/img/favicons/favicon_64.png">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="/bundles/shift/img/favicons/favicon_57.png">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="/bundles/shift/img/favicons/favicon_72.png" sizes="72x72">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="/bundles/shift/img/favicons/favicon_114.png" sizes="114x114">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="/bundles/shift/img/favicons/favicon_144.png" sizes="144x144">
		<link rel="shortcut icon" href="/bundles/shift/favicon.ico">
		@include( 'shift::partials.head' )
	</head>
	<body>

		<div id="unsupported-browser" class="pad-on-handheld">
			You are using an unsupported browser.
			Please upgrade to <a href="http://www.google.com/chrome" target="_blank">Chrome</a>,
			<a href="http://www.firefox.com" target="_blank">Firefox</a> or the
			latest version of <a href="http://www.beautyoftheweb.com" target="_blank">Internet Explorer</a>.
		</div>

		<div id="initial-load-indicator" class="pad-on-handheld">
			<div id="initial-load-content">
				{{ HTML::setting( 'app.site.name' ) }} is loading...<br>
				Please be patient.<br>
				{{ HTML::image('bundles/shift/img/ajax-loader2.gif', 'Loading...') }}
			</div>
		</div>

		<div id="loading-indicator" class="display-on-load">
			{{ HTML::image('bundles/shift/img/ajax-loader2.gif', 'Loading...') }}
		</div>

		<div id="modal-container" class="display-on-load" ng-show="visible" modal>
			<div id="modal-content">
				<div id="modal-close" ng-click="close()"><span class="icon-close"></span></div>
				<div id="modal-scrollable-content" ng-include="template"></div>
			</div>
		</div>

		<div id="alert-container" class="top-right display-on-load" notification-container>
			<div floating-notification ng-repeat="notification in notifications"></div>
		</div>

		<header id="header" class="display-on-load">
			<div class="container">
				<div class="logo">{{ HTML::setting('app.site.name') }}</div>

				<div id="control-panel" user-panel ng-show="user"></div>
			</div>
		</header>

		<nav id="navigation" class="display-on-load">
			<div class="container pad-on-handheld">
				<ul class="horizontal menu" top-menu></ul>
			</div>
		</nav>

		<section id="content" class="display-on-load">
			<div ng-view>
				@output('content')
			</div>
		</section>

		<!-- Add an extra element to allow the client to add their own image. -->
		<div id="client-extra"><div class="container"></div></div>
		<footer id="footer" class="display-on-load">
			<div class="container">
				<!-- Used to allow overriding by parent application. -->
				<div id="client-logo"></div>

				<p id="copyright">
					Copyright &copy; <a href="http://tectonicdigital.com.au" target="_blank">Tectonic Digital Pty Ltd</a> {{ date('Y') }}. All rights reserved.
				</p>

				<div id="awardforce">
					<a href="http://awardforce.com" target="_blank">
						<img src="/bundles/shift/img/award-force.png" alt="Awards management system by Tectonic Digital"><br>
						Awards management system<br>
						by Tectonic Digital
					</a>
				</div>
			</div>
		</footer>

		@include('shift::partials.foot')
	</body>
</html>
