<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Validation\Validator;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;

class RegisterUserValidator extends Validator
{
    /**
     * Retrieve the rules necessary for user registration. This particular use-case has
     * some interesting requirements based on the email due to the fact that a single user
     * email address can be shared across accounts. That is, a user can be assigned to one
     * or more accounts, and can have an existing user account when they register against
     * a client's account.
     *
     * @return array
     */
    public function getRules()
    {
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => ['required', 'email', 'unique_account'],
            'password' => ['required', 'min:6']
        ];

        return $rules;
    }
}
