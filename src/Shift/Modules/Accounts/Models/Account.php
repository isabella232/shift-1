<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Localisation\Models\Language;
use Tectonic\Shift\Modules\Users\Contracts\UserInterface;
use Tectonic\Shift\Modules\Users\Models\User;

class Account extends Model implements AccountInterface
{
    use SoftDeletingTrait;

    /**
     * Fillable fields via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * An account can have one or more domains, and is often queried via this relationship.
     *
     * @return collection
     */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function locales()
    {
        return $this->belongsToMany(Language::class);
    }

    /**
     * Each account can have one owner. That owner gets additional permissions for the account, and is basically
     * the top-level user for a given account, regardless of permissions.
     *
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * Each account is has many users.
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Returns the id for the account.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return a collection of domains assigned to this account.
     *
     * @return collection
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Creates a new account instance.
     *
     * @param string $name
     * @return Account
     */
    public static function add()
    {
        $account = new self;

        return $account;
    }

    /**
     * Sets the owner for the account.
     *
     * @param UserInterface $user
     */
    public function setOwner(UserInterface $user)
    {
        $this->userId = $user->getId();
    }

    /**
     * Returns the user that is the owner of this account.
     *
     * @return UserInterface
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
