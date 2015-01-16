@extends('layouts.fullpage')

@section('main')
    <div class="container ng-scope">
    	<div class="island"></div>

        @include('partials.errors.display')

    	<div class="row">
    		<div class="column-third">
    		    <!-- Info box goes here... -->
    		    <h1>3 easy steps</h1>
                <div class="tips islet">
                    <div class="tips-title"></div>
                    <div class="tips-body tips-home">
                        <ol>
                            <li>Create your very own user login account.</li>
                            <li>Choose your award category.</li>
                            <li>Submit your entry.</li>
                        </ol>
                    </div>
                </div>
    		</div>

    		<div class="column-third">
                @include('users.register')
    		</div>

    		<div class="column-third">
                @include('authentication.login')
    		</div>

        </div>
    </div>
@stop
