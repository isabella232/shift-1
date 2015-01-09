@section('main')
    <div class="row island">
        <div class="column-half">
            <div class="title">
                <h1>
                    <a href="{{ route('roles.index') }}">{{ trans('shift::roles.titles.main')}}</a>
                    &gt; {{ trans('shift::roles.titles.new') }}
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        @include('shift::roles.form')
    </div>
@stop
