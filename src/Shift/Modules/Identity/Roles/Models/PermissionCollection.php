<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Models;

use Illuminate\Database\Eloquent\Collection;

class PermissionCollection extends Collection
{
    /**
     * Find a matching permission in the collection based on the resource and (optionally) the action.
     *
     * @param string $resource
     * @param string|null $action
     */
    public function match($resource, $action = null)
    {
        foreach ($this->items as $item) {
            if ($item->matches($resource, $action)) {
                return $item;
            }
        }

        return null;
    }
}
