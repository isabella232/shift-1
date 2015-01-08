<?php
namespace Tests\Unit\Library\Menu;

use Tests\Stubs\MenuItemStub;
use Tests\UnitTestCase;

class MenuItemTest extends UnitTestCase
{
    private $menuItem;

    public function init()
    {
        $this->menuItem = new MenuItemStub('text');
    }

	public function testTextAssignment()
    {
        $this->menuItem = new MenuItemStub('text');

        $this->assertEquals('text', $this->menuItem->text());
    }

    public function testParentCheck()
    {
        $this->assertFalse($this->menuItem->hasParent());
        $this->assertNull($this->menuItem->parent());
    }

    public function testRenderableSetting()
    {
        $this->menuItem->setRenderable(true);

        $this->assertTrue($this->menuItem->renderable());
    }
}
