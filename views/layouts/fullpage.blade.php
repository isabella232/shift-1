<!doctype html>
<html lang="en">
<head>
    @include('shift::partials.header.head')
</head>
<body>
    @include('shift::partials.misc.browser')

    <header id="header">
        <div class="container">
            <a href="" class="logo"></a>
            <div id="control-panel">
                <ul class="horizontal">
                    <li>{{ trans('shift::header.haveAccount') }} <a href="/">{{ trans('shift::header.login') }}</a></li>
                    @if(Auth::check())
                    <li>
                        <span id="accountName">{{ lang($account, 'name') }}</span>
                        <input type="hidden" id="accountSwitcher" style="width: 300px;"/>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    <nav id="navigation">
        <div class="container pad-on-handheld">
            {{ HTML::menu('main') }}
        </div>
    </nav>

    <section id="content">
        @yield('main')
    </section>

    <div id="footer-links">
        <div class="container">
            <footer-links input="footerLinks"></footer-links>
        </div>
    </div>

    @include('shift::partials.footer.foot')
</body>
</html>
