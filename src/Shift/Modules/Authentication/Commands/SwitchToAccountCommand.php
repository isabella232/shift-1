<?php namespace Tectonic\Shift\Modules\Authentication\Commands;

use Tectonic\Application\Commanding\Command;

class SwitchToAccountCommand extends Command
{
    /**
     * @var int
     */
    public $accountId;

    /**
     * @var int
     */
    public $user;

    /**
     * @param $accountId
     * @param $user
     */
    public function __construct($accountId, $user)
    {
        $this->accountId = $accountId;
        $this->user = $user;
    }
}