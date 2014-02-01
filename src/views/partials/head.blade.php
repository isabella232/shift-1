<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
	<script src="/bundles/shift/js/ie-compat.js"></script>
<![endif]-->
<!--[if lt IE 8]><script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.2.4/json3.min.js"></script><![endif]-->

{{-- Core shift files and scripts --}}
@foreach ( Asset::$containers as $name => $container )
	@if ( $name != 'custom' )
		{{ Asset::container( $name )->styles() }}
	@endif
@endforeach

{{-- Here we call the 'custom' container, which can hold all manner of things required for client software development --}}
{{ Asset::container( 'custom' )->styles() }}

<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-39121718-1']);
	_gaq.push(['_setDomainName', 'awardsplatform.com']);
	_gaq.push(['_trackPageview']);
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>