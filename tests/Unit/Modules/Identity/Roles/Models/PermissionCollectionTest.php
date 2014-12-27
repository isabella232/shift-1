<?php
namespace Tests\Unit\Modules\Identity\Roles\Models;

use Mockery as m;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;
use Tectonic\Shift\Modules\Identity\Roles\Models\PermissionCollection;
use Tests\UnitTestCase;

class PermissionCollectionTest extends UnitTestCase
{
	public function testMatching()
    {
        $mockPermission = m::mock(Permission::class);
        $mockPermission->shouldReceive('matches')->once()->with('resource', 'action')->andReturn(true);

        $collection  = new PermissionCollection([$mockPermission]);

        $this->assertEquals($mockPermission, $collection->match('resource', 'action'));
    }

    public function testNullMatching()
    {
        $mockPermission = m::mock(Permission::class);
        $mockPermission->shouldReceive('matches')->once()->with('resource', 'action')->andReturn(false);

        $collection  = new PermissionCollection([$mockPermission]);

        $this->assertNull($collection->match('resource', 'action'));
    }
}
