<?php
namespace Tests\Unit\Library\Html;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\Facades\View;
use Mockery as m;
use Tectonic\Shift\Library\Html\ButtonBuilder;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;
use Tests\UnitTestCase;

class ButtonBuilderTest extends UnitTestCase
{
    private $buttonBuilder;
    private $mockPermissonsService;

	public function init()
    {
        $this->mockPermissonsService = m::mock(PermissionsService::class);

        $this->buttonBuilder = new ButtonBuilder($this->mockPermissonsService);
    }

    public function testLinkGenerationWithNoOptions()
    {
        View::shouldReceive('make')->with('shift::html.buttons.link', ['title' => 'Home', 'url' => 'home', 'icon' => '', 'iconClass' => '', 'size' => 'big', 'type' => ''])->once()->andReturn('optionless button');

        $this->assertEquals('optionless button', $this->buttonBuilder->link('home', 'Home'));
    }

    public function testLinkGenerationWithIconOptions()
    {
        View::shouldReceive('make')->with('shift::html.buttons.link', ['title' => 'Home', 'url' => 'home', 'icon' => 'setting', 'iconClass' => 'icon', 'size' => 'big', 'type' => ''])->once()->andReturn('icon button');

        $this->assertEquals('icon button', $this->buttonBuilder->link('home', 'Home', ['icon' => 'setting']));
    }

    public function testLinkWithPermissionsDenied()
    {
        $this->mockPermissonsService->shouldReceive('permits')->once()->with(['User' => 'read'])->andReturn(false);

        $this->assertNull($this->buttonBuilder->link('users', 'Users', ['permissions' => ['User' => 'read']]));
    }

    public function testLinkWithPermissionsAllowed()
    {
        $this->mockPermissonsService->shouldReceive('permits')->once()->with(['User' => 'write'])->andReturn(true);

        View::shouldReceive('make')->with('shift::html.buttons.link', ['title' => 'Edit user', 'url' => 'users/edit/1', 'icon' => '', 'iconClass' => '', 'size' => 'big', 'type' => ''])->once()->andReturn('permitted button');

        $this->assertEquals('permitted button', $this->buttonBuilder->link('users/edit/1', 'Edit user', ['permissions' => ['User' => 'write']]));
    }
}
