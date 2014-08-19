<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @include( 'shift::partials.header.head' )
</head>
<body>

    @include('shift::partials.misc.browser')

    <div ng-view></div>

    {{ $language }}

    @include('shift::partials.footer.foot')

</body>
</html>
