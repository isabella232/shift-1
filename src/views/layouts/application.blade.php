<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @include( 'shift::partials.header.head' )
</head>
<body>

    @include('shift::partials.misc.browser')

    <div ng-view>
        @yield('content', '<h1 align="center">Shift &#8226; Award Force</h1>')
    </div>

    @include('shift::partials.footer.foot')

</body>
</html>
