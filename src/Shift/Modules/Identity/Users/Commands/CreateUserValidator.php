<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Validation\Validator;

class CreateUserValidator extends Validator
{
	protected $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'passwordConfirmation' => 'required|same:password'
    ];
}
