<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Request;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\LaravelLocalisation\Facades\Translator;

/**
 * Class CurrentAccountService
 *
 * This service manages the functionality surrounding the current account for the request. Accounts
 * are determined based on the domain name of the request. There are some special use-cases for when
 * an account does not exist, and also some edge cases where managers of accounts can log into a separate
 * account as another user.
 *
 * All of this functionality is managed by the current account service.
 *
 * @author Kirk Bushell
 * @package Tectonic\Shift\Modules\Accounts\Services
 */
class CurrentAccountService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var Account
     */
    private $account;

    /**
     * The translated version of the account model.
     *
     * @var Entity
     */
    private $translatedAccount;

	/**
	 * @param \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface $accountRepository
	 */
	public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Returns the currently active account for this request.
     *
     * @return AccountInterface
     */
    public function get()
    {
        return $this->account;
    }

    /**
     * Set the account that is currently being used for this request.
     *
     * @param $account
     */
    public function set(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Returns the default language for the account.
     *
     * @return \Tectonic\Shift\Modules\Localisation\Languages\Language
     */
    public function defaultLanguage()
    {
        return $this->account->defaultLanguage();
    }

    /**
     * Determines the account that is being used for the current request.
     *
     * @return Account
     */
    public function determine($domain)
    {
        return $this->accountRepository->requireByDomain($domain);
    }

    /**
     * Returns the account entity, which has been translated from the original model - which can be used
     * for dealing with the account name and any other fields that are translated to a user's locality.
     *
     * @return Entity
     */
    public function translated()
    {
        if (!$this->translatedAccount) {
            $this->translatedAccount = Translator::translate($this->account);
        }

        return $this->translatedAccount;
    }
} 