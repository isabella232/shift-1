{{ Form::model($user, ['route' => $user->id ? ['users.update', $user->slug] : 'users.create', 'method' => $user->id ? 'put' : 'post', 'class' => 'vertical', 'data-pjax' => '']) }}
    <div class="row">
        <div class="column-half users-left-column">
            <!-- @TODO: if the user has manage account permission - show an account dropdown. This will be the initial account a user is assigned to -->

            <div class="control">
                <div class="control-label">
                    {{ Form::label('firstName', trans('shift::users.form.first_name.label')) }}
                </div>
                <div class="control-field">
                    {{ Form::text('firstName') }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('lastName', trans('shift::users.form.last_name.label')) }}
                </div>
                <div class="control-field">
                    {{ Form::text('lastName') }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('email', trans('shift::users.form.email.label')) }}
                </div>
                <div class="control-field">
                    {{ Form::email('email') }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('password', trans('shift::users.form.password.label')) }}
                </div>
                <div class="control-field">
                    {{ Form::password('password') }}
                    <div class="help-text">{{ trans('shift::users.form.password.hint') }}</div>
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('passwordConfirmation', trans('shift::users.form.password_confirmation.label')) }}
                </div>
                <div class="control-field">
                    {{ Form::password('passwordConfirmation') }}
                    <div class="help-text">{{ trans('shift::users.form.password_confirmation.hint') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="button primary big ladda-button" data-style="contract" data-spinner-color="#333">
            {{ trans('shift::buttons.saveNext') }}
        </button>
    </div>
{{ Form::close() }}
