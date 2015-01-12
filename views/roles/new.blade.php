@extends('shift::content.main')

@section('breadcrumbs')
    <h1>
        <a href="{!! action('Tectonic\Shift\Controllers\RoleController@getIndex') !!}">{!! trans('shift::roles.titles.main')!!}</a>
        &gt; {!! trans('shift::roles.titles.new') !!}
    </h1>
@stop

@section('content')
    @include('shift::roles.form')
@stop
