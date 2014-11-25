<h1>Log In</h1>

<!-- Login form -->
{{ Form::open(['action' => 'Tectonic\Shift\Controllers\RegistrationController@register']) }}

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
			{{ Form::label('remember', 'Remember me') }}
		</div>
		<div class="control-field sixty">
			{{ Form::checkbox('remember') }}
		</div>
	</div>

	<div class="control">
		<div class="control-field">
			<input type="submit" value="Log In">
		</div>
	</div>

{{ Form::close() }}
