<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;

class PermissionWasAdded extends Event
{
    /**
     * @var Permission
     */
    private $permission;

    /**
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
}
