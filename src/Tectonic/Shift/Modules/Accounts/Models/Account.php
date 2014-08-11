<?php

namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\BaseModel;

class Account extends BaseModel
{
    /**
     * Below are the fields that can be mass-assigned on the model.
     *
     * @var array
     */
    public $fillable = ['name'];

	/**
	 * Each account can have one or more domains.
	 *
	 * @return mixed
	 */
	public function domains()
	{
		return $this->hasMany('Tectonic\Shift\Modules\Accounts\Models\Domain');
	}

    /**
     * Any given account has many roles for that account.
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->hasMany('Tectonic\Shift\Modules\Security\Models\Role');
    }

    /**
     * Each account has a number of users.
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('Tectonic\Shift\Modules\Accounts\Models\User');
    }

	/**
	 * Each account has one owner, which is represented by the user_id field.
	 *
	 * @return mixed
	 */
	public function owner()
	{
		return $this->belongsTo('Tectonic\Shift\Modules\Accounts\Models\User');
	}
}
