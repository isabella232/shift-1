<?php

namespace Tectonic\Shift\Modules\Security\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Each permission is assigned to a given role.
     *
     * @return mixed
     */
    public function role()
    {
        return $this->hasMany('Tectonic\Shift\Modules\Security\Models\Role');
    }
}
