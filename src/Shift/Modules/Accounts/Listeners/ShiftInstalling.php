<?php
namespace Tectonic\Shift\Modules\Accounts\Listeners;

use Event;
use Tectonic\Shift\Library\Support\Listener;
use Tectonic\Shift\Modules\Accounts\Services\AccountDomainsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Services\AccountUsersService;

class ShiftInstalling extends Listener
{
    /**
     * @var AccountDomainsService
     */
    private $accountDomainsService;

    /**
     * @var AccountManagementService
     */
    private $accountsService;
    /**
     * @var AccountUsersService
     */
    private $accountUsersService;

    /**
     * @param AccountManagementService $accountsService
     * @param AccountUsersService $accountUsersService
     * @param AccountDomainsService $domainsService
     */
    public function __construct(AccountManagementService $accountsService, AccountUsersService $accountUsersService, AccountDomainsService $domainsService)
    {
        $this->accountDomainsService = $domainsService;
        $this->accountsService = $accountsService;
        $this->accountUsersService = $accountUsersService;
    }

    /**
     * Returns an array containing the events the listener will hook into. The key is the event,
     * and the value is the event handler method on the class.
     *
     * @returns array
     */
    public function hooks()
    {
        return [
            'shift.installing' => 'createAccount'
        ];
    }

    /**
     * Creates the account and associated account data.
     *
     * @param User $user
     * @param array $input
     */
    public function createAccount($user, array $input)
    {
        $account = $this->accountsService->create($input);

        $this->accountUsersService->transferOwnership($account, $user);
        $this->accountUsersService->addUser($account, $user);
        $this->accountDomainsService->addDomain($account, $input['host']);

        Event::fire('account.installed', [$account]);
    }
}
 