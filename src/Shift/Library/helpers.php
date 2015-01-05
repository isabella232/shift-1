<?php
/**
 * Manages the output for a translation of a given model object, and the required field. It will
 * use the language that is being used by the user and then return the value for that given field and
 * language code.
 *
 * @param Entity $model
 * @param string $field
 */
function lang(\Tectonic\LaravelLocalisation\Translator\Translated\Entity $model, $field)
{
    $languageCode = \Tectonic\Shift\Library\Facades\CurrentLocale::code();

    if (isset($model->{$field}[$languageCode])) {
        return $model->{$field}[$languageCode];
    }

    // No Translation Available
    return '&lt;&lt;NTA&gt;&gt;';
}
