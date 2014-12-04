<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Validation\Validator;

class UpdateUserProfileValidator extends Validator
{
    protected $rules = [
        'firstName' => 'required',
        'lastName'  => 'required',
        'email'     => 'required|email',
        'password'  => 'required',
        'passwordConfirmation' => 'required|same:password'
    ];

    /**
     * Retrieve the rules necessary for updating user profile information.
     * This use-case is unique in such that, if the password fields are empty,
     * we don't need to validate them, as the user is not changing their password.
     *
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        parent::__construct($input);

        if($input['password'] == null || $input['password'] == "") {
            unset($this->rules['password']);
            unset($this->rules['passwordConfirmation']);
        }
    }
} 