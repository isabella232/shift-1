<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Localisation\Contracts\TranslatableInterface;
use Tectonic\Localisation\Translator\Translatable;
use Tectonic\Shift\Library\Slugs\Sluggable;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Library\Support\Database\Eloquent\TranslatableModel;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Identity\Roles\Events\RoleWasCreated;
use Tectonic\Shift\Modules\Identity\Roles\Events\RoleWasUpdated;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class Role extends Model implements TranslatableInterface
{
    use EventGenerator;
    use Translatable;
    use TranslatableModel;
    use Sluggable;

    /**
     * Roles only have one definable attribute that can be mass-assigned.
     *
     * @var array
     */
    public $fillable = ['default'];

    /**
     * Each role belongs to exactly one account.
     *
     * @return Query
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Sets the account id for the role.
     *
     * @param Account $account
     */
    public function setAccount(Account $account)
    {
        $this->accountId = $account->id;
    }

    /**
     * A role can be assigned to many users, and vise-versa.
     *
     * @return Query
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Each role is assigned a number of permissions which defines what a role is permitted to do
     * throughout the system for a given account.
     *
     * @return Query
     */
    public function permissions()
    {
        return $this->hasMany();
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

    /**
     * Roles themselves don't require any fields to create the records - but they do need a record. The name
     * translations are handled within the business rules of the translations.
     *
     * @return static
     */
    public static function create(array $attributes)
    {
        $role = new static;
        $role->raise(new RoleWasCreated($role));

        return $role;
    }

    /**
     * Flag the role as updated.
     *
     * @return $this
     */
    public function update(array $attributes = [])
    {
        $this->default = $attributes['default'];
        $this->raise(new RoleWasUpdated($this));

        return $this;
    }
}
