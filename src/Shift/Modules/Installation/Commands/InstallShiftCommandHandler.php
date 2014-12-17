<?php
namespace Tectonic\Shift\Modules\Installation\Commands;

use CurrentAccount;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class InstallShiftCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var AccountRepositoryInterface
     */
    private $accounts;

    /**
     * @var UserRepositoryInterface
     */
    private $users;
    /**
     * @var LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @param EventDispatcher $dispatcher
     * @param AccountRepositoryInterface $accounts
     */
    public function __construct(
        EventDispatcher $dispatcher,
        AccountRepositoryInterface $accounts,
        UserRepositoryInterface $users,
        LanguageRepositoryInterface $languageRepository
    ) {
        $this->dispatcher = $dispatcher;
        $this->accounts = $accounts;
        $this->users = $users;
        $this->languageRepository = $languageRepository;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $account = Account::install();

        $user = User::install($command->email, $command->password);
        $this->users->save($user);

        $account->setOwner($user);

        $this->accounts->save($account);

        CurrentAccount::set($account);

        $language = $this->addLanguage($account, $command->language);

        $account->addUser($user);

        CurrentAccount::set($account);
        $account->addTranslation($language->code, 'name', $command->name);
        $account->addDomain($command->host);

        $this->dispatcher->dispatch($account->releaseEvents());
        $this->dispatcher->dispatch($user->releaseEvents());
    }

    public function addLanguage(Account $account, $languageCode)
    {
        $language = $this->languageRepository->getByCode($languageCode);

        $account->addLanguage($language);

        return $language;
    }
}
