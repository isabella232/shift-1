<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @foreach(Asset::containers() as $container)
        {{ $container->styles() }}
    @endforeach
</head>
<body>
    <div>@yield('content')</div>
</body>
</html>
