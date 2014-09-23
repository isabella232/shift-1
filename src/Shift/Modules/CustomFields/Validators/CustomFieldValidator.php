<?php namespace Tectonic\Shift\Modules\CustomFields\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class CustomFieldValidator extends Validator
{

    protected $rules = [
        'resource'    => ['required'],
        'type'        => ['required'],
        'field_title' => ['required']
    ];

    // TODO: Validate that field_code is unique for a given resource

}
