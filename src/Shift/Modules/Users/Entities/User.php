<?php

namespace Tectonic\Shift\Modules\Users\Entities;

use Crypt;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\Hash;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Mitch\LaravelDoctrine\Traits\Authentication;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Users\Repositories\DoctrineUserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="users")
 */
class User extends Entity implements UserInterface
{
    use Authentication;
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="users")
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="userId")
     * @ORM\JoinColumn(name="user_id")
     */
    protected $ownedAccounts;

    /**
     * Construct a new User entity, hydrating the required fields.
     *
     * @param string $email
     * @param $first_name
     * @param $last_name
     * @param $password
     */
    public function __construct($email, $firstName, $lastName, $password)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $this->setPassword($password);
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

    /**
     * Setter to has password.
     *
     * @param string $str
     */
    public function setPassword($str)
    {
        $this->password = Hash::make($str);
    }
}
