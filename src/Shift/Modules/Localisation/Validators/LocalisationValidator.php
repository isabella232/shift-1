<?php namespace Tectonic\Shift\Modules\Localisation\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class LocalisationValidator extends Validation
{
    protected $rules = [
        'locale_id'  => 'required',
        'foreign_id' => 'required',
        'resource'   => 'required',
        'field'      => 'required',
        'value'      => 'required'
    ];
}
