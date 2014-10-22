<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainInterface;

class Domain extends Model implements DomainInterface
{
    /**
     * Fillable attributes.
     *
     * @var array
     */
    public $fillable = ['domain'];

    /**
     * Domains belong to an account.
     *
     * @return mixed
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Retrieves the id for the domain.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the domain string value.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set the domain value. This is a string representation of the domain in question.
     *
     * @param string $domain
     * @return void
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Set the account relationship for this particular domain.
     *
     * @param Account $account
     */
    public function setAccount(AccountInterface $account)
    {
        $this->accountId = $account->getId();
    }
}
