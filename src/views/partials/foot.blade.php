<!--[if lt IE 9]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><!--<![endif]-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.20/angular.min.js"></script>

{{-- Core shift files and scripts --}}
{{-- @foreach ( Asset::$containers as $name => $container )
	@if ( $name != 'custom' )
		{{ Asset::container( $name )->scripts() }}
	@endif
@endforeach --}}

{{-- Custom scripts --}}
{{-- Asset::container('custom')->scripts() --}}

<script type="text/javascript">
	/*var user         = {{-- $user --}};
	var settings     = {{-- json_encode( $settings ) --}};
	var config       = {{-- json_encode( $config ) --}};
	var customViews  = {{-- json_encode( $custom_views ) --}};
	var customFields = {{-- $custom_fields --}};*/
</script>
