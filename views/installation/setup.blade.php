@extends('shift::layouts.installation')

@section('content')
<div class="page-heading island">
	<div class="container">
		<h1>Shift installation</h1>
	</div>
</div>

@if ($errors->count())
    <div class="container">
        <div class="alert-error sticky island animate-fade">
            <ul class="validation-errors">
                @foreach ($errors->default as $field => $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="container pad-on-handheld">
    {{ Form::open(['action' => 'Tectonic\Shift\Controllers\InstallationController@postInstall', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="column-half vertical">
                <h3 class="first">Application details</h3>

                <div class="control">
                    <div class="control-label forty">
                        {{ Form::label('name', 'Account name') }}
                    </div>
                    <div class="control-field sixty">
                        {{ Form::text('name', 'Shift 2.0', ['autofocus', 'required']) }}
                        <div class="help-text">Enter the name of the first account for this installation.</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-label forty">
                        {{ Form::label('host', 'Host \ Domain') }}
                    </div>
                    <div class="control-field sixty">
                        {{ Form::text('host', $host) }}
                        <div class="help-text">Enter the domain or host information for this account (eg. somedomain.com or 192.168.1.1:8000.</div>
                    </div>
                </div>

                <h3>Administrator</h3>

                <div class="control">
                    <div class="control-label forty">
                        {{ Form::label('email', 'Email address') }}
                    </div>
                    <div class="control-field sixty">
                        {{ Form::text('email') }}
                        <div class="help-text">Enter the email address of the administrator's account.</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-label forty">
                        {{ Form::label('password', 'Password') }}
                    </div>
                    <div class="control-field sixty">
                        {{ Form::password('password') }}
                        <div class="help-text">Every administrator needs a good a password.</div>
                    </div>
                </div>
            </div>

            <div class="column-half">
                <h3 class="first">What's this?</h3>

                <p>You're seeing this page because you've accessed a Shift installation without any prior configuration.</p>

                <p>We just need a few important things from you before the process can continue, namely:</p>

                <ul>
                    <li>The name of the first account to be created. For more information accounts, please see: <a href="">TODO: WRITE ACCOUNT DOCS!</a></li>
                    <li>The host that the application will reside at. This should be a domain name in the case of a production environment, or the address you usually host the local development version on. We've tried to figure this part out for you, based on the location of the application.</li>
                </ul>

                <p>Once all the information appears correct, click install. It should only take a moment or two, and you'll be redirected to the login screen if everything goes according to plan.</p>
            </div>
        </div>

        <div class="form-actions">
            <input type="submit" class="button primary" value="Install">
        </div>
    {{ Form::close() }}
</div>
@endsection