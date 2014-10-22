<?php
namespace Tectonic\Shift\Modules\Users\Models;

use Illuminate\Auth\UserInterface as AuthUserInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Users\Contracts\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class User extends Model implements UserInterface, AuthUserInterface, RemindableInterface
{
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Fillable attributes for the user model.
     *
     * @var array
     */
    public $fillable = ['firstName', 'lastName', 'email', 'password'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Returns the accounts that the user owns.
     *
     * @return QueryBuilder
     */
    public function ownedAccounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Should create a new instance of the entity, with the first name, last name and email provided.
     *
     * @param $firstName
     * @param $lastName
     * @param $email
     * @return UserInterface
     */
    public static function add($firstName, $lastName, $email)
    {
        $user = new self;
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);

        return $user;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Determine whether or not the user is an owner of the provided account.
     *
     * @param AccountInterface $account
     */
    public function ownerOf(AccountInterface $account)
    {
        $ownedAccountIds = $this->ownedAccounts->lists('id');

        return in_array($account->getId(), $ownedAccountIds);
    }

    /**
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Password attribute mutator
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = \Hash::make($value);
    }

}
