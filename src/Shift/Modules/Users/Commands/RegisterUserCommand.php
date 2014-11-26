<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\Command;

class RegisterUserCommand extends Command
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $passwordConfirmation;

    public function __construct($firstName, $lastName, $email, $password, $passwordConfirmation)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
}
