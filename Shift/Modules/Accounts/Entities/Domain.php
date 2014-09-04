<?php namespace Tectonic\Shift\Modules\Accounts\Entities;

use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Modules\Accounts\ValueObjects\DomainName;

/**
 * Class Domain
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineDomainRepository")
 * @table(name="domains")
 */
class Domain
{
    use Accountable;
    use Timestamps;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $domain;

    /**
     * Construct a new domain entity. Account id and the domain name are always required.
     *
     * @param Account $account
     * @param DomainName $domain
     */
    public function __construct(Account $account, DomainName $domain)
    {
        $this->accountId = $account->getId();
        $this->domain = $domain;
    }

    /**
     * Returns the domain name's value.
     *
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain->getDomainName();
    }
}
