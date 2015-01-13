@section('main')
    <div class="row island">
        <div class="column-half">
            <div class="title">
                <h1>
                    <a href="{{ route('accounts.index') }}">{{ trans('shift::accounts.titles.main')}}</a>
                    &gt; {{ lang($account, 'name') }}
                </h1>
            </div>
        </div>
    </div>

    @include('shift::partials.errors.display')

    {{ Form::model($account, ['route' => $account->id ? ['accounts.update', $account->slug] : 'accounts.create', 'method' => $account->id ? 'put' : 'post', 'class' => 'vertical', 'data-pjax' => '']) }}
        <div class="row">
            <div class="column-half accounts-left-column">
                <div class="control">
                    <div class="control-label">
                        {{ Form::label('name', trans('shift::accounts.form.name.label')) }}
                    </div>
                    <div class="control-field">
                        {{ Multilingual::text('name', $account) }}
                        <div class="help-text">{{ trans('shift::accounts.form.name.hint') }}</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-label">
                        {{ Form::label('defaultLanguageCode', trans('shift::accounts.form.default_language.label')) }}
                    </div>
                    <div class="control-field">
                        {{ Form::select('defaultLanguageCode', $languages->lists('language', 'code'), ['required']) }}
                        <div class="help-text">{{ trans('shift::accounts.form.default_language.hint') }}</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-label">
                        {{ Form::label('domain', trans('shift::accounts.form.domain.label')) }}
                    </div>
                    <div class="control-field">
                        <div class="http">http://</div>
                        <div class="domain">{{ Form::text('domain') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="button primary big ladda-button" data-style="contract" data-spinner-color="#333">
                {{ trans('shift::buttons.saveNext') }}
            </button>
        </div>
    {{Form::close()}}

@stop
