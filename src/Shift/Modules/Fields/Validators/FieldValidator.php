<?php namespace Tectonic\Shift\Modules\Fields\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class FieldValidator extends Validation
{

    protected $rules = [
        'resource'    => ['required'],
        'type'        => ['required'],
        'field_title' => ['required']
    ];

    // TODO: Validate that field_code is unique for a given resource

}
