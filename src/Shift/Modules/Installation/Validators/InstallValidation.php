<?php namespace Tectonic\Shift\Modules\Installation\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class InstallValidation extends Validation
{
    protected $rules = [
        'name'     => 'required',
        'host'     => 'required',
        'email'    => 'required',
        'password' => 'required',
        'passwordConfirmation' => 'required|same:password'
    ];

}
