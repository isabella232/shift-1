<!--[if lt IE 9]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><!--<![endif]-->

{{-- Load Assets --}}
@foreach(Asset::containers(['custom']) as $container)
    {{ $container->scripts() }}
@endforeach
{{ Asset::container('custom')->scripts() }}

<script type="text/javascript">
	angular.value('BootstrapConfig', '{{ HTML::obscure($configuration) }}');
</script>
