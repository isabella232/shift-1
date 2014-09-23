<?php

namespace Tectonic\Shift\Modules\Accounts\ValueObjects;

/**
 * Class DomainName
 *
 * Value object. Simply converts a domain name to a lowercase representation.
 *
 * @package Tectonic\Shift\Modules\Accounts\ValueObjects
 */

class DomainName
{
    /**
     * @var string
     */
    private $domainName;

    /**
     * @param $domainName
     */
    public function __construct($domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * Retrieve the domain name, lowercased.
     *
     * @return mixed
     */
    public function getDomainName()
    {
        return strtolower($this->domainName);
    }
}
