@section('main')
    <div class="row island">
        <div class="column-half">
            <div class="title">
                <h1>
                    <a href="{{ route('users.index') }}">{{ trans('shift::users.titles.main')}}</a>
                    &gt; {{ trans('shift::users.titles.new') }}
                </h1>
            </div>
        </div>
    </div>

    @include('shift::partials.errors.display')

    <div class="row">
        @include('shift::users.form')
    </div>
@stop
