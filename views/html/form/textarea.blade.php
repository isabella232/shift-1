@foreach ($supportedLanguages as $language)
    {{Form::textarea("translated[{$name}][{$language->code}]", $value, $options)}}
@endforeach
