<?php

namespace Tectonic\Shift\Modules\Users\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Authentication;
use Tectonic\Shift\Library\Authorization\UserInterface;
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
     * @ManyToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", inversedBy="users")
     * @JoinTable(name="account_user")
     */
    private $accounts;

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
        return [];
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
}
