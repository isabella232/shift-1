<?php namespace Tectonic\Shift\Library\Authorization;

interface ConsumerInterface
{
    /**
     * Returns an array of accounts that the consumer can manage.
     *
     * @return array Account
     */
    public function getAccounts();

    /**
     * Returns the exact account id that the consumer is currently managing.
     *
     * @return integer
     */
    public function getAccountId();
}
