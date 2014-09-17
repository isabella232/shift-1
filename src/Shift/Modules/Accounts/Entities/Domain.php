<?php namespace Tectonic\Shift\Modules\Accounts\Entities;

use Doctrine\ORM\Mapping as ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Modules\Accounts\ValueObjects\DomainName;

/**
 * Class Domain
 *
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineDomainRepository")
 * @ORM\Table(name="domains")
 */
class Domain
{
    use Accountable;
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $domain;

    /**
     * Construct a new domain entity. Account id and the domain name are always required.
     *
     * @param Account $account
     * @param DomainName $domain
     */
    public function __construct(Account $account, DomainName $domain)
    {
        $this->accountId = $account->getId();
        $this->domain = $domain;
    }

    /**
     * Returns the domain name's value.
     *
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain->getDomainName();
    }
}
