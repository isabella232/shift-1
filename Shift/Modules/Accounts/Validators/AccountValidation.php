<?php namespace Tectonic\Shift\Modules\Accounts\Validators;

use Tectonic\Shift\Library\Validation\Validator;

class AccountValidation extends Validator
{
    protected $rules = [
        'name' => ['required']
    ];
}
