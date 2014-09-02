<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Modules\Accounts\ValueObjects\DomainName;

class Domain
{
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
     * @Column(type="integer")
     */
    private $accountId;

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
