<!doctype html>
<html lang="en" ng-app="application" id="application">
<head>
    @include( 'shift::partials.header.head' )
</head>
<body>
    @include('shift::partials.misc.browser')

    <header id="header">
        <div class="container">
            <a href="" class="logo"></a>
        </div>
    </header>

    <nav id="navigation">
        <div class="container pad-on-handheld">
            <ul class="horizontal menu"></ul>
        </div>
    </nav>

    <section id="content">
        <div>@yield('main')</div>
    </section>

    <div id="footer-links">
        <div class="container">
            <footer-links input="footerLinks"></footer-links>
        </div>
    </div>

    @include('shift::partials.footer.foot')
</body>
</html>
