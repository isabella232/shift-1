<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Event;

class PermissionResourcesService
{
    /**
     * The following array represents the default resources supported by Shift 2.
     *
     * @var array
     */
    protected $resources = [
        'FilesAll',
        'FilesOwner',
        'Fields',
        'Roles',
        'Users',
    ];

    /**
     * Add a resource to the resources array. Will only add the resource if it does
     * not already exist within the array.
     *
     * @param $resource
     */
    public function add($resource)
    {
        if (!$this->exists($resource)) {
            $this->resources[] = $resource;
        }
    }

    /**
     * Determines whether or not a resource exists within the resource registry.
     *
     * @param string $resource
     * @return bool
     */
    public function exists($resource)
    {
        return false !== array_search($resource, $this->resources);
    }

    /**
     * Return all registered resources.
     *
     * @fires Tectonic.Shift.Permissions.Requested
     * @return array
     */
    public function get()
    {
        Event::fire('Tectonic.Shift.Permissions.Requested', [$this]);

        return $this->resources;
    }
}
