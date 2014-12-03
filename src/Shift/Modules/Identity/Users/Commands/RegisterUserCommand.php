<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\Command;

class RegisterUserCommand extends Command
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $password_confirmation;
    public $captcha;

    public function __construct($firstName, $lastName, $email, $password, $passwordConfirmation, $captcha)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;

        // Note the different casing - this is required for Laravel's confirmed validation rule
        $this->password_confirmation = $passwordConfirmation;
        $this->captcha = $captcha;
    }
}
