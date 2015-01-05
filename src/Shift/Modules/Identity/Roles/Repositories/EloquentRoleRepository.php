<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Repositories;

use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;

class EloquentRoleRepository extends Repository implements RoleRepositoryInterface
{
    function __construct(Role $model)
    {
        $this->setModel($model);
    }

    /**
     * Returns the default role for an account.
     *
     * There is no way to do this without a set of account details.
     *
     * @return Role
     */
    public function getDefault()
    {
        $defaultRole = $this->getBy('default', true);

        if (!$defaultRole->isEmpty()) {
            return $defaultRole->first();
        }

        return null;
    }

    /**
     * Roles have some special requirements when queried for by slugs.
     *
     * @param string $slug
     * @return mixed
     */
    public function requireBySlug($slug)
    {
        $query = $this->getQuery();
        $query = $query->with('permissions');
        $query = $query->whereSlug($slug);

        $role = $query->first();

        if (!$role) {
            $exception = with(new ModelNotFoundException)->setModel(get_class($this->model));

            throw $exception;
        }

        return $role;
    }

    /**
     * Set the default role for an account. It will also unset another role, if another
     * role is the current default role for the account.
     *
     * @param Role $role
     * @return Role
     */
    public function setDefault($role)
    {
        $updateRoles = function() use ($role) {
            $existingRole = $this->getDefault();

            if (!is_null($existingRole)) {
                if ($existingRole->id == $role->id) {
                    return $role;
                }

                $existingRole->default = false;
                $role->default = true;

                $this->saveAll($existingRole, $role);
            }

            $role->default = true;

            parent::save($role);
        };

        $updateRoles->bindTo($this);

        DB::transaction($updateRoles);
    }

    /**
     * Saves the resource provided to the database. If the role in this case is wishing to be set as the default
     * role, then we'll save the role via the setDefault method and return this result.
     *
     * @param $resource
     * @return Resource
     */
    public function save($resource)
    {
        if ($resource->default) {
            return $this->setDefault($resource);
        }

        return parent::save($resource);
    }
}
