<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class LocaleValidator extends Validator
{
    protected $rules = [
        'locale' => 'required',
        'code'   => 'required|unique:locales,code|localeCode'
    ];
}
