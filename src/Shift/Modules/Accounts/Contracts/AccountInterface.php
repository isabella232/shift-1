<?php
namespace Tectonic\Shift\Modules\Accounts\Contracts;

use Tectonic\Shift\Modules\Users\Contracts\UserInterface;

/**
 * Interface AccountInterface
 *
 * An account represents an id, name, and a list of domains. This is generally what we need to
 * query against.
 *
 * @package Tectonic\Shift\Modules\Accounts\Contracts
 */
interface AccountInterface
{
    /**
     * Returns the id for the account.
     *
     * @return integer
     */
    public function getId();

    /**
     * Should return a collection of domains assigned to this account.
     *
     * @return collection
     */
    public function getDomains();

    /**
     * Returns the user that is the owner of this account.
     *
     * @return UserInterface
     */
    public function getOwner();

    /**
     * Sets the owner of an account.
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function setOwner(UserInterface $user);
}