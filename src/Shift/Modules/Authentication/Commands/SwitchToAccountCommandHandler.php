<?php namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tectonic\Application\Commanding\Command;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Authentication\Models\Token;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;

class SwitchToAccountCommandHandler implements CommandHandlerInterface
{

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface
     */
    private $domainRepository;

    /**
     * @var \Tectonic\Application\Eventing\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @param \Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface  $domainRepository
     * @param \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface $accountRepository
     * @param \Tectonic\Application\Eventing\EventDispatcher                        $eventDispatcher
     */
    public function __construct(
        DomainRepositoryInterface $domainRepository,
        AccountRepositoryInterface $accountRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->domainRepository = $domainRepository;
        $this->eventDispatcher  = $eventDispatcher;
        $this->accountRepository = $accountRepository;
    }

    /**
     * Handle switching account
     *
     * @param \Tectonic\Application\Commanding\Command $command
     *
     * @return string
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException
     */
    public function handle($command)
    {
        // 1. Make sure user is associated with account.
        if(!$this->accountUserExists($command->user->id)) {
            throw new UserAccountAssociationException;
        }

        // 2. Create a DB record with unique token, account id and user id (if an existing record doesn't exist)
        $token = $this->createAccountSwitchRecord($command);
        $this->accountRepository->save($token);

        // 3. Release events
        $this->eventDispatcher->dispatch($token->releaseEvents());

        // 4. Generate the URL for the account we're switching to (inclusive of token)
        $domainRecord = $this->domainRepository->getOneBy('account_id', $command->accountId);

        return $this->generateReturnUrl($domainRecord->domain, $token->token);
    }

    /**
     * Check to see if user is associated with account
     *
     * @param $user
     *
     * @return bool
     */
    protected function accountUserExists($user)
    {
        $accountUser = $this->accountRepository->getByUser($user);

        if($accountUser) return true;

        return false;
    }

    /**
     * Generate the return URL
     *
     * @param $domain
     * @param $token
     *
     * @return string
     */
    protected function generateReturnUrl($domain, $token)
    {
        if(substr($domain, 0, 4) !== 'http') $domain = 'http://' . $domain;

        return $domain . '/auth/switch?token=' . $token;
    }

    /**
     * Create a new AccountSwitch record
     *
     * @param \Tectonic\Application\Commanding\Command $command
     *
     * @return mixed
     */
    protected function createAccountSwitchRecord(Command $command)
    {
        return Token::createToken($command->accountId, CurrentAccount::get(), $command->user->id, md5(Str::random()));
    }
}