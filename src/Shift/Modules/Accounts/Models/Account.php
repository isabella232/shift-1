<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Localisation\Contracts\TranslatableInterface;
use Tectonic\Localisation\Translator\Translatable;
use Tectonic\Shift\Library\Slugs\Sluggable;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Library\Support\Database\Eloquent\TranslatableModel;
use Tectonic\Shift\Modules\Accounts\Events\AccountWasCreated;
use Tectonic\Shift\Modules\Accounts\Events\AccountWasInstalled;
use Tectonic\Shift\Modules\Accounts\Events\OwnerWasChanged;
use Tectonic\Shift\Modules\Localisation\Languages\Language;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class Account extends Model implements TranslatableInterface
{
    use EventGenerator;
    use SoftDeletes;
    use Translatable;
    use TranslatableModel;
    use Sluggable;

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
        return $this->hasMany(SupportedLanguage::class);
    }

    /**
     * Returns the default supported language for an account.
     *
     * @return Language
     */
    public function defaultLanguage()
    {
        // @TODO: Support default language choice for accounts
        return new Language($this->languages()->first()->code);
    }

    /**
     * Each account can have one owner. That owner gets additional permissions for the account, and is basically
     * the top-level user for a given account, regardless of permissions.
     *
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
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
     * Adds a new user to an account.
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users()->attach($user->id);
    }

    /**
     * Sets the owner for the account.
     *
     * @param User $user
     */
    public function setOwner(User $user)
    {
        $this->owner()->associate($user);
        $this->raise(new OwnerWasChanged($user));
    }

    /**
     * Create a new account instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $account = new static($attributes);
        $account->raise(new AccountWasCreated($account));

        return $account;
    }

    /**
     * Create a new account. This is for the installation use-case.
     *
     * @return Account
     */
    public static function install()
    {
        $account = static::create([]);
        $account->raise(new AccountWasInstalled($account));

        return $account;
    }

    /**
     * Add a new supported language to the account.
     *
     * @param Language $language
     */
    public function addLanguage(Language $language)
    {
        $supportedLanguage = new SupportedLanguage;
        $supportedLanguage->code = $language->code;

        $this->languages()->save($supportedLanguage);
    }

    /**
     * Add a new domain to the account.
     *
     * @param $domain
     */
    public function addDomain($domain)
    {
        $newDomain = new Domain(['domain' => $domain]);

        $this->domains()->save($newDomain);
    }

    /**
     * The required translatable fields for this model.
     *
     * @return array
     */
    public function getTranslatableFields()
    {
        return ['name'];
    }

    public function getId()
    {
        return $this->id;
    }
}
