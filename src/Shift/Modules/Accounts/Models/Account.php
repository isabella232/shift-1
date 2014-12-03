<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Localisation\Translator\Translatable;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Library\Support\Database\Eloquent\TranslatableModel;
use Tectonic\Shift\Modules\Accounts\Events\AccountWasInstalled;
use Tectonic\Shift\Modules\Accounts\Events\OwnerWasChanged;
use Tectonic\Shift\Modules\Localisation\Languages\Language;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class Account extends Model
{
    use EventGenerator;
    use SoftDeletingTrait;
    use Translatable;
    use TranslatableModel;

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
}
