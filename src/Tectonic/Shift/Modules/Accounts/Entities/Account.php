<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

/**
 * @entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository")
 */
class Account
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="\Tectonic\Shift\Modules\Users\Entities\User")
     * @Column(type="integer", name="user_id")
     */
    private $userId;

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
}
