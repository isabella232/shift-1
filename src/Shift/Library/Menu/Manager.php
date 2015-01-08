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
    private $menus = [];

    /**
     * Return a given menu, if it exists.
     *
     * @param string $menuName
     * @return Menu
     */
    public function get($menuName)
    {
        if (!$this->has($menuName)) {
            throw new \Exception("No menu named [$menuName] has been registered.");
        }

        return $this->menus[$menuName];
    }

    /**
     * Add a newly created menu to the manager.
     *
     * @param Menu $menu
     */
    public function register(Menu $menu)
    {
        $this->menus[$menu->name()] = $menu;

        Event::fire('menu added: '.$menu->name(), [$menu]);
    }

    /**
     * Returns true if the requested menu exists within the registered menus.
     *
     * @param string $menuName
     * @return bool
     */
    public function has($menuName)
    {
        return isset($this->menus[$menuName]);
    }
}
