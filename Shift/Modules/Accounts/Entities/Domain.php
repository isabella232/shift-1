<?php namespace Tectonic\Shift\Modules\Accounts\Entities;

/**
 * Class Domain
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineDomainRepository")
 * @table(name="domains")
 */
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
     * @Column(type="integer" name="account_id" options={"unsigned"=true})
     */
    private $accountId;
}
