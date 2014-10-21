<?php
namespace Tectonic\Shift\Modules\Accounts\Contracts;

interface DomainInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * Returns the domain string value.
     *
     * @return string
     */
    public function getDomain();

    /**
     * Set the domain value. This is a string representation of the domain in question.
     *
     * @param string $domain
     * @return void
     */
    public function setDomain($domain);
}
 