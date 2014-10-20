<?php

namespace Tectonic\Shift\Modules\Accounts\Contracts;

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
     * The name of the account.
     *
     * @return string
     */
    public function getName();

    /**
     * Should return a collection of domains assigned to this account.
     *
     * @return collection
     */
    public function getDomains();
} 