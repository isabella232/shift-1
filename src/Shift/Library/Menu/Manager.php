<?php
namespace Tectonic\Shift\Library\Menu;

use Event;
use Illuminate\Support\Collection;

class Manager extends Collection
{
    /**
     * Add a newly created menu to the manager.
     *
     * @param MenuItem $menuItem
     */
    public function register(MenuItem $menuItem)
    {
        $this->items[] = $menuItem;

        Event::fire('Menu item registered', [$menuItem]);
    }

    /**
     * Return a specific menu.
     *
     * @param string $menuName
     * @return static
     */
    public function menu($menuName)
    {
        return $this->filter(function($menuItem) use ($menuName) {
            return $menuItem instanceof Menu && $menuItem->name == $menuName;
        });
    }

    /**
     * Returns true if the requested menu exists within the registered menus.
     *
     * @param string $menuItem
     * @return bool
     */
    public function has($menuItem)
    {
        return $this->where('name', $menuItem);
    }

    /**
     * @param $url
     */
    public function activateByUrl($url)
    {
        $activated = $this->activateByFullMatch($url);

        if (!$activated) {
            // When no active item is found, we'll try and make a partial match
            $this->activateByPartialMatch($url);
        }
    }

    /**
     * Set the current range of items to an active state based on the full url.
     *
     * @param string $url
     * @return boolean
     */
    public function activateByFullMatch($url)
    {
        foreach ($this->itemsOnly() as $item) {
            if ($item->link == $url) {
                $item->setActive();

                return true;
            }
        }

        return false;
    }

    /**
     * Activate a menu based on a partial match.
     *
     * @param string $url
     */
    public function activateByPartialMatch($url)
    {
        $this->itemsOnly()->each(function($menuItem) use ($url) {
            if (strpos($url, $menuItem->link) === 0) {
                $menuItem->setActive();
            }
        });
    }

    /**
     * Return only the items of the menu items, not the menus.
     *
     * @return Collection
     */
    protected function itemsOnly()
    {
        return $this->filter(function($menuItem) {
            return $menuItem instanceof Item;
        });
    }
}
