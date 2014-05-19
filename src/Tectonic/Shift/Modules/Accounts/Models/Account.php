<?php

namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\BaseModel;

class Account extends BaseModel
{
    /**
     * Below are the fields that can be mass-assigned on the model.
     *
     * @var array
     */
    public $fillable = ['name', 'url'];

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
        return $this->hasMany('Tectonic\Shift\Modules\Users\Models\User');
    }
}
