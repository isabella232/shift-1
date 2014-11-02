<?php
namespace Tectonic\Shift\Modules\Localisation\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class TranslationValidator extends Validation
{
    protected $rules = [
        'language_id'  => 'required',
        'foreign_id' => 'required',
        'resource'   => 'required',
        'field'      => 'required',
        'value'      => 'required'
    ];
}
