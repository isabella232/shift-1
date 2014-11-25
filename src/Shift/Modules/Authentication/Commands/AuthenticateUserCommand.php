<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Tectonic\Application\Commanding\Command;

class AuthenticateUserCommand extends Command
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $remember;

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
