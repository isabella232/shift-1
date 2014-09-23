<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @foreach(Asset::containers() as $container)
        {{ $container->styles() }}
    @endforeach
</head>
<body>
    <header id="header">
        <div class="container">
            <a href="" class="logo"></a>
            <div id="control-panel" user-panel ng-show="user"></div>
            <div id="control-panel" ng-hide="user">
                <ul class="horizontal">
                    <li>Have an account? <a href="/">Login</a>.</li>
                </ul>
            </div>
        </div>
    </header>

    <nav id="navigation">
        <div class="container pad-on-handheld">
            <ul class="horizontal menu" top-menu></ul>
        </div>
    </nav>

    <section id="content">
        <div
            @yield('content')
        </div>
    </section>

    <div id="footer-links">
        <div class="container">
            <footer-links input="footerLinks"></footer-links>
        </div>
    </div>
</body>
</html>
