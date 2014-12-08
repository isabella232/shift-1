@foreach ($supportedLanguages as $language)
    {{Form::text("translated[{$name}][{$language->code}]", $value, $options)}}
@endforeach
