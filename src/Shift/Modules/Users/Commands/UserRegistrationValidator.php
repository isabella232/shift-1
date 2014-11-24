<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Validation\Validator;

class UserRegistrationValidator extends Validator
{
    /**
     * @var array
     */
    protected $rules = [
        'email'                => 'required|email',
        'password'             => 'required',
        'passwordConfirmation' => 'required|same:password'
    ];
}