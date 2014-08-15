<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

class LocaleCustomValidationRules
{
    public function localCode($attributes, $value, $parameters)
    {
        $regex = '/^[a-z]{2}_[A-Z]{2}$/';

        return (bool) preg_match($regex, $value);
    }
}