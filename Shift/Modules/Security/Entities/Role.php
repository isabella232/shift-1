<?php namespace Tectonic\Shift\Modules\Security\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;

/**
 * Class Role
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository")
 * @table(name="roles")
 */
class Role
{
    use Timestamps;
    use SoftDeletes;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", name="account_id" options={"unsigned"=true})
     */
    private $accountId;

    /**
     * @Column(type="integer" options={"unsigned"=true})
     */
    private $access;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="boolean" options={"default"=0})
     */
    private $default;

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
     * @OneToOne(targetEntity="Tectonic\Shift\Modules\Accounts\Models\Account", mappedBy="id")
     */
    private $account;

    /**
     * @OneToMany(targetEntity="Tectonic\Shift\Modules\Security\Entities\Permission", mappedBy="roleId")
     */
    private $permissions;

    /**
     * @OneToMany(targetEntity="Tectonic\Shift\Modules\Users\Entities\Users", mappedBy="userId")
     */
    private $users;
}