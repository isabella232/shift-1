<?php
namespace Tectonic\Shift\Modules\Users\Commands;

class SendRegistrationEmailCommand
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
