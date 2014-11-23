<?php
namespace Tectonic\Shift\Modules\Accounts\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Accounts\Models\Account;

class AccountWasInstalled extends Event
{
    /**
     * @var Account
     */
    public $account;

    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
