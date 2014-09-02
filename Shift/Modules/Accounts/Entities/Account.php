<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;

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
     * @ManyToOne(targetEntity="Tectonic\Shift\Modules\Users\Entities\User")
     */
    private $user;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    /**
     * @Column(type="datetime", name="deleted_at")
     */
    private $deletedAt;

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
    public function getUser()
    {
        return $this->user;
    }
}
