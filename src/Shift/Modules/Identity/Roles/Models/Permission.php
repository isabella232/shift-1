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

    /**
     * Create a new permission object.
     *
     * @return Permission
     */
    public static function create(array $attributes)
    {
        $permission = new static($attributes);

        $permission->raise(new PermissionWasCreated($permission));

        return $permission;
    }

    /**
     * Determines whether or not a permission object matches the required resource/action requirement.
     *
     * @param string $resource
     * @param string|null $action
     * @return bool
     */
    public function matches($resource, $action = null)
    {
        if ($resource == $this->resource && (is_null($action) or $action == $this->action)) {
            return true;
        }

        return false;
    }

    /**
     * Create a new collection, this time using the permission collection which provides some specific
     * search/find mechanisms based on a loaded collection.
     *
     * @param array $models
     * @return PermissionCollection
     */
    public function newCollection(array $models = array())
    {
        return new PermissionCollection($models);
    }
}
