<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
<script src="/packages/tectonic/shift/js/ie-compat.js"></script>
<![endif]-->
<!--[if lt IE 8]><script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.2.4/json3.min.js"></script><![endif]-->

@foreach(Asset::containers(['custom']) as $container)
    {!! $container->styles() !!}
@endforeach
{!! Asset::container('custom')->styles() !!}

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
