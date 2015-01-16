@section('main')
    <div class="row island">
        <div class="column-half">
            <div class="title">
                <h1>
                    <a href="{{ route('roles.index') }}">{{ trans('roles.titles.main')}}</a>
                    &gt; {{ lang($role, 'name') }}
                </h1>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    @include('partials.errors.display')
=======
@section('breadcrumbs')
    <h1>
        <a href="{!! action('Tectonic\Shift\Controllers\RoleController@getIndex') !!}">{!! trans('roles.titles.main')!!}</a>
        &gt; {!! lang($role, 'name') !!}
    </h1>
@stop
>>>>>>> l5

    <div class="row">
        @include('roles.form')
    </div>
@stop
