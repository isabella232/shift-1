<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class LocaleValidator extends Validation
{
    protected $rules = [
        'locale' => 'required',
        'code'   => 'required|unique:locales,code|localeCode'
    ];
}
