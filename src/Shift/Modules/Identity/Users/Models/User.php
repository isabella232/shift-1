<?php
namespace Tectonic\Shift\Modules\Identity\Users\Models;

use CurrentAccount;
use Illuminate\Auth\UserInterface as AuthUserInterface;
use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Identity\Users\Events\AdminUserWasCreated;
use Tectonic\Shift\Modules\Identity\Users\Events\UserHasRegistered;
use Tectonic\Shift\Modules\Identity\Users\Events\UserWasAdded;

class User extends Model implements AuthUserInterface, RemindableInterface
{
    use EventGenerator;

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
     * A user can be an owner of 1 or more accounts, but it can also be a member of 1 or
     * more accounts. Owners are defined as the user_id field on the accounts table, whereas
     * the accounts a user is apart of, can be many.
     *
     * @return mixed
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    /**
     * A user has many roles, but only for the current account that has been loaded.
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->whereAccountId(CurrentAccount::get()->id);
    }

    /**
     * Should create a new instance of the entity, with the first name, last name and email provided.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function add($firstName, $lastName, $email, $password)
    {
        $user = new static(compact('firstName', 'lastName', 'email', 'password'));

        $user->raise(new UserWasAdded($user));

        return $user;
    }

    /**
     * When installing shift, this is a special use-case.
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function install($email, $password)
    {
        $user = static::add('Super', 'Admin', $email, $password);

        $user->raise(new AdminUserWasCreated($user));

        return $user;
    }

    /**
     * Register a new user on the system.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function register($firstName, $lastName, $email, $password)
    {
        $user = static::add($firstName, $lastName, $email, $password);

        $user->raise(new UserHasRegistered($user));

        return $user;
    }

    /**
     * Determine whether or not the user is an owner of the provided account.
     *
     * @param Account $account
     */
    public function ownerOf(Account $account)
    {
        $ownedAccountIds = $this->ownedAccounts->lists('id');

        return in_array($account->getId(), $ownedAccountIds);
    }

    /**
     * Returns a concatenated version of both first and last names.
     *
     * @return string
     */
    public function getName()
    {
        return $this->firstName.' '.$this->lastName;
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

    /**
     * Generates a new confirmation token for a user account and then returns said token.
     *
     * @return string
     */
    public function generateConfirmationToken()
    {
        $this->confirmationToken = md5(time().$this->id);

        return $this->confirmationToken;
    }
}
