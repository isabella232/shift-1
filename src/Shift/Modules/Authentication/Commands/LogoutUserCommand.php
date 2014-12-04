<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Auth\UserInterface;
use Tectonic\Application\Commanding\Command;

class LogoutUserCommand extends Command
{
    /**
     * @var \Illuminate\Auth\UserInterface
     */
    public $user;

    /**
     * @param \Illuminate\Auth\UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
} 