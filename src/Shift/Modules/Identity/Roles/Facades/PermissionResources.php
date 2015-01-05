<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionResources extends Facade
{
	public static function getFacadeAccessor()
    {
        return 'permission.resources';
    }
}
