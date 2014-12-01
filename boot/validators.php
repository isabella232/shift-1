<?php

use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;

/**
 * A collection of additional validators for global use.
 *
 * @authors Kirk Bushell
 * @date 25th November 2014
 */

/**
 * Only really applies to the email field. Checks to see whether or not the email address
 * is unique to the account the user is signing up for.
 *
 * @param string $attribute Not used.
 * @param string $email
 * @return boolean
 */
Validator::extend('unique_account', function($attribute, $email) {
    $userRepository = App::make(UserRepositoryInterface::class);

    return !$userRepository->getByEmailAndAccount($email, CurrentAccount::get());
});

/**
 * The following validator uses the recaptcha library to check the response from the
 * google servers and returns boolean true or false based on that response.
 *
 * @param string $attribute
 * @param string $value
 * @param array $params
 * @return boolean
 */
Validator::extend('recaptcha', function($attribute, $value, $params) {
    return Recaptcha::checkAnswer(Config::get('recaptcha.key'), Request::ip(), '', $value);
});
