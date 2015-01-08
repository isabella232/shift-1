@extends('shift::content.main')

@section('breadcrumbs')
    <h1>
        <a href="{{ route('roles.index') }}">{{ trans('shift::roles.titles.main')}}</a>
        &gt; {{ trans('shift::roles.titles.new') }}
    </h1>
@stop

@section('content')
    @include('shift::roles.form')
@stop
