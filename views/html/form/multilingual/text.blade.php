@foreach ($supportedLanguages as $language)
    $value = (isset($model->$name) && isset($model->{$name}[$language->code])) ? $model->{$name}[$language->code] : null;

    {{ Form::text("translated[{$name}][{$language->code}]", $value, $options) }}
@endforeach
