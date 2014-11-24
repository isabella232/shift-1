@section('main')
    <div class="container ng-scope">
    	<div class="island"></div>

    	<div validation-errors="">
    	    <div class="alert-error sticky island">
    	        <ul class="validation-errors">

    	        </ul>
    	    </div>
    	</div>

    	<div class="row">
    		<div class="column-half">
    		    <!-- LOGIN FORM GOES HERE -->
    		</div>

    		<div class="column-half">
                @include('shift::users.register')
    		</div>
    	</div>
    </div>
@stop
