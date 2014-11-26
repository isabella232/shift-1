<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\Command;
use Tectonic\Shift\Modules\Users\Models\User;

class SendRegistrationEmailCommand extends Command
{
    /**
     * @var User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
