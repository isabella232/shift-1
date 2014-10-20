<?php

namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\collection;
use User;

class Account extends Model implements AccountInterface
{
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

    public function owner()
    {
        return $this->belongsTo(User::class);
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
}
