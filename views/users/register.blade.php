<h1>Register</h1>

<!-- Registration form -->
{{ Form::open(['action' => 'Tectonic\Shift\Controllers\RegistrationController@register', 'novalidate' => 'novalidate']) }}
	<div class="control">
		<div class="control-label forty">
		    {{ Form::label('firstName', 'First name') }}
		</div>
		<div class="control-field sixty">
		    {{ Form::text('firstName') }}
		</div>
	</div>

	<div class="control">
		<div class="control-label forty">
			{{ Form::label('lastName', 'Last name') }}
		</div>
		<div class="control-field sixty">
			{{ Form::text('lastName') }}
		</div>
	</div>

	<div class="control">
		<div class="control-label forty">
			{{ Form::label('email', 'Email') }}
		</div>
		<div class="control-field sixty">
			{{ Form::email('email') }}
		</div>
	</div>

	<div class="control">
		<div class="control-label forty">
			{{ Form::label('password', 'Password') }}
		</div>
		<div class="control-field sixty">
			{{ Form::password('password') }}
		</div>
	</div>

	<div class="control">
		<div class="control-label forty">
			{{ Form::label('password_confirmation', 'Password') }}
		</div>
		<div class="control-field sixty">
            {{ Form::password('password_confirmation') }}
		</div>
	</div>

	<div class="control">
		<div class="control-label forty">
			<label for="recaptcha_response_field" mandatory>Authorisation</label>
		</div>
		<div class="control-field sixty">
			<div id="captcha-box" captcha model="user"></div>
		</div>
	</div>

	<div class="control">
		<div class="control-field">
			<input type="submit" ng-disabled="" value="Register">
		</div>
	</div>

{{ Form::close() }}
