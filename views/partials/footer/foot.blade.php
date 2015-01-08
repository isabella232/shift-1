<!--[if lt IE 9]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><!--<![endif]-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{{-- Load Assets --}}
@foreach(Asset::containers(['custom']) as $container)
    {{ $container->scripts() }}
@endforeach
{{ Asset::container('custom')->scripts() }}

