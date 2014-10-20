<?php namespace Tests\Stubs;

use Tectonic\Shift\Library\Authorization\ConsumerInterface;

class ConsumerStub implements ConsumerInterface
{
    private $accounts = [];

	public function id()
    {
        return 0;
    }

    public function getAccountId()
    {
        return 0;
    }

    public function getAccounts()
    {
        return $this->account;
    }

    public function setAccounts(array $accounts)
    {
        $this->accounts = $accounts;
    }
}
