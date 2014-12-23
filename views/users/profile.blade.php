@extends('shift::layouts.fullpage')

@section('main')

<div class="container">
    <div class="row">

        <h1>Edit profile</h1>

        @include('shift::partials.errors.display')

        <!-- User profile form -->
        {{ Form::open(['action' => 'Tectonic\Shift\Controllers\UserController@updateProfile', 'novalidate' => 'novalidate', 'class' => 'vertical']) }}

            <div class="control">
                <div class="control-label">
                    {{ Form::label('firstName', 'First name') }}
                </div>
                <div class="control-field">
                    {{ Form::text('firstName', Input::old('firstName', $profile->first_name)) }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('lastName', 'Last name') }}
                </div>
                <div class="control-field">
                    {{ Form::text('lastName', Input::old('lastName', $profile->last_name)) }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('email', 'Email') }}
                </div>
                <div class="control-field">
                    {{ Form::email('email', Input::old('email', $profile->email)) }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('password', 'Password') }}
                </div>
                <div class="control-field">
                    {{ Form::password('password') }}
                </div>
            </div>

            <div class="control">
                <div class="control-label">
                    {{ Form::label('passwordConfirmation', 'Password') }}
                </div>
                <div class="control-field">
                    {{ Form::password('passwordConfirmation') }}
                </div>
            </div>

            <div class="control">
                <div class="control-field">
                    {{ Form::submit('Save') }}
                </div>
            </div>

        {{ Form::close() }}


    </div>
</div>

@stop