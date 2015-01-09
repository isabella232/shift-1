<!doctype html>
<html lang="en">
<head>
    @include('shift::partials.header.head')
</head>
<body>
    @include('shift::partials.misc.browser')

    <header id="head">
        <div class="app-title">{{ lang($account, 'name') }}</div>
        <div class="user-info">
            <div id="control-panel">
                <ul class="horizontal">
                    @if (Auth::check())
                        <li>
                            <span id="accountName">{{ lang($account, 'name') }}</span>
                            <input type="hidden" id="accountSwitcher" style="width: 300px;"/>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    <section id="main">
        <nav id="navigation">
            {{ HTML::menu('main') }}
        </nav>

        <section id="content">
            <header id="header">
                <a href="" class="logo"></a>
            </header>

            <div class="content">
                <div id="pjaxContainer">
                    @yield('main')
                </div>

                <div id="loader">
                    <div class="spinner">
                        <div class="cube1"></div>
                        <div class="cube2"></div>
                    </div>
                </div>
            </div>



            <div id="footer-links">
                <div class="container">
                    <footer-links input="footerLinks"></footer-links>
                </div>
            </div>
        </section>
    </section>

    @include('shift::partials.footer.foot')
</body>
</html>
