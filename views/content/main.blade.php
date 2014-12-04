@section('main')
    <div class="page-heading">
        <div class="container">
            <div class="column-half">
                @yield('breadcrumbs')
            </div>

            <div class="column-half buttons">
                @yield('buttons')
            </div>
        </div>
    </div>

    @yield('filters')
    @yield('content')
@stop
