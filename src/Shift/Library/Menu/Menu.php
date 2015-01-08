<?php
namespace Tectonic\Shift\Library\Menu;

use Menufy;

class Menu extends MenuItem
{
    /**
     * Stores the name for the menu. This used as a reference point for menu items (where
     * necessary) as well as when rendering specific required menus.
     *
     * @var string
     */
    private $name;

    /**
     * Construct a new menu with the following text.
     *
     * @param string $name
     * @param string $text
     */
    public function __construct($name, $text = null)
    {
        $this->text = $text;
        $this->name = $name;
    }

    /**
     * Returns the name of the menu.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Add a new child menu item, and set its parent.
     *
     * @param Item $item
     */
    public function addChild(MenuItem $item)
    {
        $this->children[] = $item;

        $item->setParent($this);

        Menufy::register($item);
    }

    /**
     * Returns the array of children this item has.
     *
     * @return array
     */
    public function children()
    {
        return $this->children;
    }
}
