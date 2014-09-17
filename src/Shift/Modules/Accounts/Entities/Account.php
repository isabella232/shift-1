<?php namespace Tectonic\Shift\Modules\Accounts\Entities;

use Doctrine\ORM\Mapping as ORM;
use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;
use Tectonic\Shift\Modules\Users\Entities\User;

/**
 * Account
 *
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository")
 * @ORM\Table(name="accounts")
 */
class Account extends Entity
{
	use Timestamps;
	use SoftDeletes;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="user_id", options={"unsigned"=true}, nullable=true)
     */
    protected $userId;

    /**
     * @ORM\ManyToOne(targetEntity="Tectonic\Shift\Modules\Users\Entities\User")
     * @ORM\JoinColumn(name="user_id")
     */
    protected $owner;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Domain", mappedBy="accountId")
     */
    protected $domains;

    /**
     * @ORM\ManyToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", inversedBy="accounts")
     * @ORM\JoinTable(name="account_user")
     */
    protected $users;

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
     * Returns the user that is currently responsible for the account.
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the owner for the account.
     *
     * @param User $user
     */
    public function setOwner(User $user)
    {
        $this->owner = $user->getId();
    }

    /**
     * Add a new domain to an account.
     *
     * @param Domain $domain
     */
    public function addDomain(Domain $domain)
    {
        $this->domains[] = $domain;
    }

    /**
     * Returns an array of all domains associated with this account.
     *
     * @return array Domain
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Add a user as a qualified user of this account.
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Returns an array of all users that are registered with this account.
     *
     * @return array User
     */
    public function getUsers()
    {
        return $this->users;
    }
}
