<?php
namespace Tests\Unit\Modules\Identity\Roles\Services;

use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionResourcesService;
use Tests\UnitTestCase;

class PermissionResourcesServiceTest extends UnitTestCase
{
    private $service;

    public function init()
    {
        $this->service = new PermissionResourcesService;
    }

    public function testResourceRetrieval()
    {
        $this->assertEquals(['Document', 'Field', 'Role', 'User'], $this->service->get());
    }

    public function testResourceExistence()
    {
        $this->assertTrue($this->service->exists('Field'));
        $this->assertFalse($this->service->exists('asdsdf'));
    }

    public function testResourceAddition()
    {
        $this->service->add('Resource');

        $this->assertTrue($this->service->exists('Resource'));
    }
}
