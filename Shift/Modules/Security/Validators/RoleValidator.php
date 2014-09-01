<?php namespace Tectonic\Shift\Modules\Security\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class RoleValidator extends Validator
{
    protected $rules = [
        'name' => ['required']
    ];
}
