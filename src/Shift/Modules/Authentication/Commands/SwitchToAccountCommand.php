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
    public $userId;

    /**
     * @param $accountId
     * @param $userId
     */
    public function __construct($accountId, $userId)
    {
        $this->accountId = $accountId;
        $this->userId = $userId;
    }
}