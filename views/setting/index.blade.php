@extends('shift::layouts.application')

@section('main')

    <div class="container">
        <div class="row">

            <h1>Settings</h1>

            {!! Form::open(['action' => 'Tectonic\Shift\Controllers\SettingController@update', 'class' => 'vertical']) !!}

                @foreach($registry as $key => $value)
                <div class="row">
                    <h1>{!! $key !!}</h1>
                    <div class="column-half seventy">
                        @foreach($value as $setting)
                            <div class="control">
                                <div class="control-label">
                                    {!! $setting['label'] !!}
                                </div>
                                <div class="control-field">
                                    {!! Field::custom($setting['type'], $setting['name'], Input::get($setting['name'], $settings[$setting['name']]), $setting['options']) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

            <div class="control">
                <div class="control-field">
                    {!! Form::submit('Save') !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop