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
    private $accountDomains;

    /**
     * @var AccountManagementService
     */
    private $accounts;

    /**
     * @var AccountUsersService
     */
    private $accountUsers;

    /**
     * @var SupportedLanguagesService
     */
    private $supportedLanguages;

    /**
     * @param AccountManagementService $accountsService
     * @param AccountUsersService $accountUsersService
     * @param AccountDomainsService $domainsService
     * @param SupportedLanguagesService $supportedLanguagesService
     */
    public function __construct(
        AccountManagementService $accountsService,
        AccountUsersService $accountUsersService,
        AccountDomainsService $domainsService,
        SupportedLanguagesService $supportedLanguagesService
    ) {
        $this->accountDomains = $domainsService;
        $this->accounts = $accountsService;
        $this->accountUsers = $accountUsersService;
        $this->supportedLanguages = $supportedLanguagesService;
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
            'shift.installing' => 'whenShiftIsInstalling'
        ];
    }

    /**
     * Creates the account and associated account data.
     *
     * @param User $user
     * @param array $input
     * @listens shift.installing
     */
    public function whenShiftIsInstalling($user, array $input)
    {
        $account = $this->accounts->create($input);

        $this->accountUsers->add($account, $user);
        $this->accountUsers->seOwner($account, $user);
        $this->accountDomains->addDomain($account, $input['host']);
        $this->supportedLanguages->addLanguage($account, $input['language']);

        Event::fire('account.installed', [$account]);
    }
}
 