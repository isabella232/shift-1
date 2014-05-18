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

    @yield('content', '<h1 align="center">No content section supplied</h1>')

    @include('shift::partials.foot')

</body>
</html>
