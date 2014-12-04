<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class Role extends Model
{
    public $fillable = ['name'];

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
}
