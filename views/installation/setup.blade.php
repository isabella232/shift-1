@extends('shift::layouts.installation')

@section('content')
<div class="container">
    <div validation-errors></div>
</div>

<div class="container pad-on-handheld">
    {{ Form::open(['action' => 'Tectonic\Shift\Controllers\InstallationController@postInstall']) }}
        <div class="row">
            <div class="column-half vertical">
                <div class="control island">
                    <div class="control-label">
                        {{ Form::label('name', 'Name') }}
                    </div>
                    <div class="control-field">
                        {{ Form::text('name', 'Shift 2.0', ['autofocus', 'required']) }}
                        <div class="help-text">Enter the name of the first account for this installation.</div>
                    </div>
                </div>

                <div class="control island">
                    <div class="control-label">
                        {{ Form::label('name', 'Host \ Domain') }}
                    </div>
                    <div class="control-field">
                        {{ Form::text('name', $host, ['autofocus', 'required']) }}
                        <div class="help-text">Enter the domain or host information for this account (eg. somedomain.com or 192.168.1.1:8000.</div>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>
@endsection