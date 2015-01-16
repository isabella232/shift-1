@section('main')
    <div class="row island">
        <div class="column-half">
            <div class="title">
                <h1>
                    <a href="{{ route('users.index') }}">{{ trans('users.titles.main')}}</a>
                    &gt; {{ trans('users.titles.new') }}
                </h1>
            </div>
        </div>
    </div>

    @include('partials.errors.display')

    <div class="row">
        @include('users.form')
    </div>
@stop
