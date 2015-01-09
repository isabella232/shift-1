<!doctype html>
<html lang="en">
<head>
    @include('shift::partials.header.head')
</head>
<body>
    @include('shift::partials.misc.browser')

    <header id="head">
        <div class="app-title">{{ lang($account, 'name') }}</div>
        <div class="user-info"></div>
    </header>

    <section id="main">
        <nav id="navigation">
            {{ HTML::menu('main') }}
        </nav>

        <section id="content">
            @yield('main')

            <div id="footer-links">
                <div class="container">
                    <footer-links input="footerLinks"></footer-links>
                </div>
            </div>
        </section>
    </section>

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

    @include('shift::partials.footer.foot')
</body>
</html>
