<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Tectonic\Application\Commanding\Command;

class AuthenticateUserCommand extends Command
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $remember;

    /**
     * @param string $email
     * @param string $password
     * @param bool   $remember
     */
    public function __construct($email, $password, $remember = false)
    {
        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
    }
}
