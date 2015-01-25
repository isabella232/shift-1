<h1>Register</h1>

<!-- Registration form -->
{!! Form::open(['action' => '\Tectonic\Shift\Controllers\RegistrationController@register', 'novalidate' => 'novalidate', 'class' => 'vertical well']) !!}
    <div class="control">
        <div class="control-label">
            {!! Form::label('firstName', 'First name') !!}
        </div>
        <div class="control-field">
            {!! Form::text('firstName') !!}
        </div>
    </div>

    <div class="control">
        <div class="control-label">
            {!! Form::label('lastName', 'Last name') !!}
        </div>
        <div class="control-field">
            {!! Form::text('lastName') !!}
        </div>
    </div>

    <div class="control">
        <div class="control-label">
            {!! Form::label('email', 'Email') !!}
        </div>
        <div class="control-field">
            {!! Form::email('email') !!}
        </div>
    </div>

    <div class="control">
        <div class="control-label">
            {!! Form::label('password', 'Password') !!}
        </div>
        <div class="control-field">
            {!! Form::password('password') !!}
        </div>
    </div>

    <div class="control">
        <div class="control-label">
            {!! Form::label('password_confirmation', 'Password') !!}
        </div>
        <div class="control-field">
            {!! Form::password('password_confirmation') !!}
        </div>
    </div>

    <div class="control">
        <div class="control-label">
            <label for="recaptcha_response_field" mandatory>Authorisation</label>
        </div>
        <div class="control-field">
            <div class="g-recaptcha" data-sitekey="6Le_jf4SAAAAAJxm20fnRq95rlljtAYI1ELq_52d"></div>
        </div>
    </div>

    <div class="control">
        <div class="control-field">
            <input type="submit" ng-disabled="" value="Register">
        </div>
    </div>

{!! Form::close() !!}
