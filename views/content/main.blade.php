@section('main')
    <div class="page-heading island">
        <div class="container">
            <div class="column-half">
                @yield('breadcrumbs')
            </div>
            asdfasdfasdf
            <div class="column-half buttons">
                @yield('buttons')
            </div>
        </div>
    </div>

    @yield('filters')
    @yield('content')
@stop
