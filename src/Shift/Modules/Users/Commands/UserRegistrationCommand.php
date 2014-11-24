<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\Command;

class UserRegistrationCommand extends Command
{
    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var string $passwordConfirmation
     */
    public $passwordConfirmation;

    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     */
    public function __construct($email, $password, $passwordConfirmation)
    {

        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

}