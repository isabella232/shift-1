<?php

namespace Tectonic\Shift\Modules\Security\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\BaseModel;

class Role extends BaseModel
{
    protected $softDelete = true;

    /**
     * Below are the fields that can be mass-assigned on the model.
     *
     * @var array
     */
    public $fillable = ['name', 'access', 'default'];

    /**
     * Represents the account that this role belongs to.
     */
    public function account()
    {
        return $this->belongsTo('Tectonic\Shift\Modules\Accounts\Models\Account');
    }

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
