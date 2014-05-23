<?php namespace Tectonic\Shift\Modules\CustomFields\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class CustomFieldValidator extends Validator
{

    protected $rules = [
        'resource'    => ['required'],
        'type'        => ['required'],
        'field_title' => ['required']
    ];

}
