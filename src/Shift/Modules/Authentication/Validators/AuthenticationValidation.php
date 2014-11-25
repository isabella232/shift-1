<?php
namespace Tectonic\Shift\Modules\Authentication\Validators;


use Tectonic\Application\Validation\Validator;

class AuthenticationValidation extends Validator
{
    /**
     * @var array
     */
    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required'
    ];
}
