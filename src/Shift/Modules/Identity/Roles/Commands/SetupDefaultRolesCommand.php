<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Shift\Modules\Accounts\Models\Account;

class SetupDefaultRolesCommand
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
