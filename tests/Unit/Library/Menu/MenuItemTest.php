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

        $this->assertEquals('text', $this->menuItem->text);
    }
}
