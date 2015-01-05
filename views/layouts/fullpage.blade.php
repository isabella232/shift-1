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
            <div id="control-panel">
                <ul class="horizontal">
                    <li>Have an account? <a href="#">Log in</a></li>
                    @if(Auth::check())
                    <li>
                        <span id="accountName">{{ $account->name[1] }}</span>
                        <input type="hidden" id="accountSwitcher" style="width: 300px;"/>
                    </li>
                    @endif
                </ul>
            </div>
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
