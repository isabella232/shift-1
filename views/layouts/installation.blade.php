<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @foreach(Asset::containers() as $container)
        {{ $container->styles() }}
    @endforeach
</head>
<body>
    <section id="content" class="install">
        <div>
            @yield('content')
        </div>
    </section>
</body>
</html>
