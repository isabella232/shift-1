<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Permissions should not remain in the database once removed, nor do we really care
     * when they are updated by users. Either they exist or they don't.
     *
     * @var bool
     */
    public $timestamps = false;

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
