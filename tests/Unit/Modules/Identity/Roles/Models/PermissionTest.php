<?php
namespace Tests\Unit\Modules\Identity\Roles\Models;

use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;
use Tests\UnitTestCase;

class PermissionTest extends UnitTestCase
{
    private $permission;

    public function init()
    {
        $this->permission = new Permission;
        $this->permission->resource = 'resource';
        $this->permission->action = 'action';
    }

	public function testFullMatch()
    {
        $this->assertTrue($this->permission->matches('resource', 'action'));
        $this->assertFalse($this->permission->matches('resource', 'action2'));
        $this->assertFalse($this->permission->matches('resources', 'action'));
    }

    public function testPartialMatch()
    {
        $this->assertTrue($this->permission->matches('resource'));
        $this->assertFalse($this->permission->matches('resources'));
    }
}
