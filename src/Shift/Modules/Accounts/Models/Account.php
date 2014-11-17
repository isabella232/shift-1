<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Tectonic\Localisation\Translator\Translatable;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Localisation\Models\Language;
use Tectonic\Shift\Modules\Accounts\Models\SupportedLanguage;
use Tectonic\Shift\Modules\Users\Contracts\UserInterface;
use Tectonic\Shift\Modules\Users\Models\User;

class Account extends Model implements AccountInterface
{
    use SoftDeletingTrait;
    use Translatable;

    /**
     * An account can have one or more domains, and is often queried via this relationship.
     *
     * @return collection
     */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    /**
     * Each account has a variety of languages that it supports.
     *
     * @return mixed
     */
    public function languages()
    {
        return $this->hasManyThrough(Language::class, SupportedLanguage::class);
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Sets the name attribute.
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Creates a new account instance.
     *
     * @param string $name
     * @return Account
     */
    public static function add($name)
    {
        $account = new self;
        $account->setName($name);

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

    /**
     * Returns an array of the field names that can be used for translations.
     *
     * @return array
     */
    public function getTranslatableFields()
    {
        return ['name'];
    }
}
