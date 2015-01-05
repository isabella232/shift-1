<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Identity\Roles\Events\PermissionWasAdded;
use Tectonic\Shift\Modules\Identity\Roles\ValueObjects\Mode;

class Permission extends Model
{
    use EventGenerator;

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
    public $fillable = ['action', 'resource', 'mode'];

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
     * Add a new permission object.
     *
     * @param Role $role
     * @param string $resource
     * @param string $action
     * @param Mode $mode
     * @return Permission
     */
    public static function add(Role $role, $resource, $action, Mode $mode)
    {
        $permission = new static;
        $permission->roleId = $role->id;
        $permission->resource = $resource;
        $permission->action = $action;
        $permission->mode = $mode;

        $permission->raise(new PermissionWasAdded($permission));

        return $permission;
    }

    /**
     * Always ensures that the mode value, is returned as a value object.
     *
     * @return Mode
     */
    public function getModeAttribute()
    {
        return new Mode($this->attributes['mode']);
    }

    /**
     * Ensures the permission's "mode" field is always set to the Mode value object.
     *
     * @param Mode $mode
     */
    public function setModeAttribute(Mode $mode)
    {
        $this->attributes['mode'] = (string) $mode;
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
