@extends('layouts.application')

@section('main')
    <div class="page-heading">
    	@yield('page-header')
    </div>

    @yield('filters')
    @yield('content')
@stop
