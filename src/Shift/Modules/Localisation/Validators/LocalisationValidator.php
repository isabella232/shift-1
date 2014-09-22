<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class LocalisationValidator extends Validator
{
    protected $rules = [
        'locale_id'  => 'required',
        'foreign_id' => 'required',
        'resource'   => 'required',
        'field'      => 'required',
        'value'      => 'required'
    ];
}
