<?php

namespace Tectonic\Shift\Modules\Security\Models;

use Tectonic\Shift\Library\BaseModel;

class Role extends BaseModel
{
    /**
     * Below are the fields that can be mass-assigned on the model.
     *
     * @var array
     */
    public $fillable = ['name', 'access'];

    /**
     * Sets the join for the permissions that roles employ.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasMany('Tectonic\Shift\Modules\Security\Models\Permission');
    }

    /**
     * Each role has a number of users.
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany('Tectonic\Shift\Modules\Users\Models\User');
    }
}
