<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

class LocaleCustomValidationRules
{
    /**
     * A custom validator rule to ensure locale code follows the
     * ISO standard of language-country. E.g: "en_GB".
     *
     * @param $attributes
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function localeCode($attributes, $value, $parameters)
    {
        $regex = '/^[a-z]{2}_[A-Z]{2}$/';

        return (bool) preg_match($regex, $value);
    }
}