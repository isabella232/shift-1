<?php

namespace Tectonic\Shift\Modules\Users\Entities;

use Crypt;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Authentication;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Entity
{
    use Authentication;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="users")
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="userId")
     * @ORM\JoinColumn(name="user_id")
     */
    private $ownedAccounts;

    /**
     * Construct a new User entity, hydrating the required fields.
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($email, $firstName, $lastName)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Returns an array of accounts that the user is assigned to.
     *
     * @return array
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Returns the name of the user concatenated together.
     *
     * @return string
     */
    public function getName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Whenever a new user is updated, we want to encrypt their password, if it has been assigned.
     *
     * @ORM\preUpdate
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if ($eventArgs->hasChangedField('password')) {
            $this->setPassword(Crypt::encrypt($this->getPassword()));
        }
    }

    /**
     * Returns the full list of accounts that the user owns.
     *
     * @return mixed
     */
    public function getOwnedAccounts()
    {
        return $this->ownedAccounts;
    }
}
