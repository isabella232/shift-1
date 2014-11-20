<?php
namespace Tectonic\Shift\Modules\Installation\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Models\User;

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
     * @param EventDispatcher $dispatcher
     * @param AccountRepositoryInterface $accounts
     */
    public function __construct(EventDispatcher $dispatcher, AccountRepositoryInterface $accounts, UserRepositoryInterface $users)
    {
        $this->dispatcher = $dispatcher;
        $this->accounts = $accounts;
        $this->users = $users;
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

        $this->accounts->save($account);
        $this->users->save($account);

        $account->setOwner($user);
        $account->addLanguage($command->language);
        $account->addTranslation($command->language, 'name', $command->name);

        $this->dispatcher->dispatch($account->releaseEvents());
        $this->dispatcher->dispatch($user->releaseEvents());
    }
}
