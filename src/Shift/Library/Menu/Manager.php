<?php
namespace Tectonic\Shift\Library\Menu;

use Event;

class Manager
{
    /**
     * Stores an array of the menus registered with the system.
     *
     * @var array
     */
    private $items = [];

    /**
     * Return a given menu, if it exists.
     *
     * @param string $menuItem
     * @return Menu
     */
    public function get($menuItem)
    {
        if (!$this->has($menuItem)) {
            throw new \Exception("No menu named [$menuItem] has been registered.");
        }

        return $this->items[$menuItem];
    }

    /**
     * Add a newly created menu to the manager.
     *
     * @param MenuItem $menuItem
     */
    public function register(MenuItem $menuItem)
    {
        $name = $menuItem instanceof Menu ? $menuItem->name() : $menuItem->text();

        $this->items[$name] = $menuItem;

        Event::fire('item registered: '.$name, [$menuItem]);
    }

    /**
     * Returns true if the requested menu exists within the registered menus.
     *
     * @param string $menuItem
     * @return bool
     */
    public function has($menuItem)
    {
        return isset($this->items[$menuItem]);
    }
}
