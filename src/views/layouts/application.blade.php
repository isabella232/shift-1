<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @include( 'shift::partials.header.head' )
</head>
<body>
    @include('shift::partials.misc.browser')

    @yield('content', '<h1 align="center">Shift &#8226; Award Force</h1>')

    @include('shift::partials.footer.foot')

</body>
</html>
