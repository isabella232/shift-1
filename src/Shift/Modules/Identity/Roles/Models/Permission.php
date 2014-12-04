<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

class Permission
{
    /**
     * Fillable attributes for role permissions.
     *
     * @var array
     */
    public $fillable = ['action', 'resource', 'allow'];

    /**
     * Each permission belongs to exactly one role.
     *
     * @return mixed
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
