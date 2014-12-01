<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Auth\AuthManager;
use Tectonic\Application\Commanding\CommandHandlerInterface;

class LogoutUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authenticate;

    /**
     * @param \Illuminate\Auth\AuthManager $authenticate
     */
    public function __construct(AuthManager $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        return $this->authenticate->logout();
    }
}