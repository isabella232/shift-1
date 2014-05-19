<?php

namespace Tectonic\Shift\Modules\Security\Models;

use Tectonic\Shift\Library\Support\BaseModel;

class Permission extends BaseModel
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
