<?php
namespace Tests\Stubs;

use Tectonic\Shift\Library\Menu\MenuItem;

class MenuItemStub extends MenuItem
{
    public function __construct($text)
    {
        $this->text = $text;
    }
}
