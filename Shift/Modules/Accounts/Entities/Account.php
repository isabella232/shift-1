<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Modules\Users\Entities\User;

/**
 * Account
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository")
 * @package Tectonic\Shift\Modules\Accounts\Entities
 */

class Account
{
	use Timestamps;
	use SoftDeletes;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @ManyToOne(targetEntity="Tectonic\Shift\Modules\Users\Entities\User", mappedBy="userId")
     */
    private $owner;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @OneToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Domain", mappedBy="accountId")
     */
    private $domains;

    /**
     * Required variables for account creation and hydration.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns an array of the domains that have been registered to this account.
     *
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Returns the user that is currently responsible for the account.
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the owner for the account.
     *
     * @param User $user
     */
    public function setOwner(User $user)
    {
        $this->owner = $user->getId();
    }

    /**
     * Add a new domain to an account.
     *
     * @param Domain $domain
     */
    public function addDomain(Domain $domain)
    {
        $this->domains[] = $domain;
    }
}
