<?php namespace Tectonic\Shift\Modules\Authentication\Services;

use Illuminate\Support\Facades\Auth;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class AccountSwitcherService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface
     */
    protected $accountRepository;

    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @param \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface    $accountRepository
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface $userRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository, UserRepositoryInterface $userRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository    = $userRepository;
    }

    /**
     * Get a list of account a user belongs to.
     *
     * @return mixed
     */
    public function getUserAccounts()
    {
        return $this->userRepository->getAccounts(Auth::user());
    }

    /**
     * Handle switching user to another account
     *
     * @param int $id
     *
     * @return mixed
     */
    public function switchToAccount($id)
    {
        return 'Swtiching to account: ' . $id;
    }
}