<?php namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Support\Str;
use Tectonic\Application\Commanding\Command;
use Tectonic\Application\Commanding\CommandBusInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Models\AccountSwitch;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;

class SwitchAccountCommandHandler implements CommandBusInterface
{

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface
     */
    private $domainRepository;


    /**
     * @param \Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface $domainRepository
     */
    public function __construct(DomainRepositoryInterface $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    /**
     * Handle switching account
     *
     * @param \Tectonic\Application\Commanding\Command $command
     *
     * @return string
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException
     */
    public function execute(Command $command)
    {
        // 1. Make sure user is associated with account.
        $accountUser = DB::table('account_user')
            ->where('account_id', '=', $command->accountId)
            ->where('user_id', '=', $command->userId)
            ->first();

        if(!$accountUser) throw new UserAccountAssociationException;

        // 2. Create a DB record with unique token, account id and user id (if an existing record doesn't exist)
        $accountSwitchRecord = AccountSwitch::create([
            'account_id' => $command->accountId,
            'user_id'    => $command->userId,
            'token'      => md5(Str::random())
        ]);

        // 3. Generate the URL for the account we're switching to (inclusive of token)
        $domainRecord = $this->domainRepository->getBy('account_id', $command->accountId);

        // 4. Return that URL
        return $domainRecord->domain . '?token=' . $accountSwitchRecord->token;
    }
}