<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Tectonic\Shift\Modules\Accounts\ValueObjects\DomainName;

class Domain
{
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
     * @param $accountId
     * @param DomainName $domain
     */
    public function __construct($accountId, DomainName $domain)
    {
        $this->accountId = $accountId;
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
